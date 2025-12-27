from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from kubernetes import client, config
from kubernetes.client.rest import ApiException
import crud, schemas, db, models
import os
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

router = APIRouter()


@router.get("/", response_model=dict)
def list_jobs(skip: int = 0, limit: int = 100, db: Session = Depends(db.get_db)):
    jobs = crud.get_jobs(db, skip=skip, limit=limit)
    return {"jobs": [schemas.JobOut.from_orm(j) for j in jobs]}


@router.post("/", response_model=schemas.JobOut)
def create_job(job_in: schemas.JobCreate, db: Session = Depends(db.get_db)):
    j = crud.create_job(
        db=db,
        name=job_in.name,
        namespace=job_in.namespace,
        worker_id=job_in.worker_id,
        arguments=job_in.arguments,
        service_account_id=job_in.service_account_id,
        completions=job_in.completions,
        parallelism=job_in.parallelism,
        backoff_limit=job_in.backoff_limit,
        active_deadline_seconds=job_in.active_deadline_seconds,
        ttl_seconds_after_finished=job_in.ttl_seconds_after_finished,
        restart_policy=job_in.restart_policy,
        image=job_in.image,
        command=job_in.command,
        args=job_in.args,
        env_vars=job_in.env_vars,
        resources=job_in.resources,
        volumes=job_in.volumes,
        volume_mounts=job_in.volume_mounts,
        image_pull_secrets=job_in.image_pull_secrets,
        labels=job_in.labels,
        annotations=job_in.annotations
    )
    return schemas.JobOut.from_orm(j)


@router.post("/{job_id}/execute", response_model=schemas.JobExecuteResponse)
def execute_job(job_id: int, db: Session = Depends(db.get_db)):
    # Get job from database
    job = db.query(models.Job).filter(models.Job.id == job_id).first()
    if not job:
        raise HTTPException(status_code=404, detail="Job not found")
    
    # Load Kubernetes configuration
    # Try in-cluster config first (when running inside Kubernetes)
    # Fall back to kubeconfig file (when running outside)
    try:
        config.load_incluster_config()
    except config.ConfigException:
        # Not running in cluster, try kubeconfig file
        try:
            kubeconfig_path = os.getenv("KUBECONFIG_PATH", os.path.expanduser("~/.kube/config"))
            config.load_kube_config(config_file=kubeconfig_path)
        except Exception as e:
            raise HTTPException(status_code=500, detail=f"Failed to load kubeconfig: {str(e)}")
    
    # Create Kubernetes API client
    batch_v1 = client.BatchV1Api()
    
    # Get service account name if set
    service_account_name = None
    if job.service_account_id:
        sa = db.query(models.ServiceAccount).filter(models.ServiceAccount.id == job.service_account_id).first()
        if sa:
            service_account_name = sa.name
    
    # Build environment variables
    env_vars = []
    if job.env_vars:
        for key, value in job.env_vars.items():
            env_vars.append(client.V1EnvVar(name=key, value=str(value)))
    
    # Build volumes
    volumes = []
    if job.volumes:
        for vol in job.volumes:
            volumes.append(client.V1Volume(**vol))
    
    # Build volume mounts
    volume_mounts = []
    if job.volume_mounts:
        for vm in job.volume_mounts:
            volume_mounts.append(client.V1VolumeMount(**vm))
    
    # Build image pull secrets
    image_pull_secrets = []
    if job.image_pull_secrets:
        for secret_name in job.image_pull_secrets:
            image_pull_secrets.append(client.V1LocalObjectReference(name=secret_name))
    
    # Build resource requirements
    resources = None
    if job.resources:
        resources = client.V1ResourceRequirements(
            requests=job.resources.get("requests"),
            limits=job.resources.get("limits")
        )
    
    # Create container
    container = client.V1Container(
        name=job.name,
        image=job.image,
        command=job.command,
        args=job.args,
        env=env_vars if env_vars else None,
        resources=resources,
        volume_mounts=volume_mounts if volume_mounts else None
    )
    
    # Create pod template spec
    pod_spec = client.V1PodSpec(
        restart_policy=job.restart_policy or "Never",
        containers=[container],
        service_account_name=service_account_name,
        volumes=volumes if volumes else None,
        image_pull_secrets=image_pull_secrets if image_pull_secrets else None
    )
    
    # Create pod template
    template = client.V1PodTemplateSpec(
        metadata=client.V1ObjectMeta(
            labels=job.labels or {},
            annotations=job.annotations or {}
        ),
        spec=pod_spec
    )
    
    # Create job spec
    job_spec = client.V1JobSpec(
        template=template,
        backoff_limit=job.backoff_limit,
        completions=job.completions,
        parallelism=job.parallelism,
        active_deadline_seconds=job.active_deadline_seconds,
        ttl_seconds_after_finished=job.ttl_seconds_after_finished
    )
    
    # Create job object
    k8s_job = client.V1Job(
        api_version="batch/v1",
        kind="Job",
        metadata=client.V1ObjectMeta(
            name=job.name,
            namespace=job.namespace,
            labels=job.labels or {},
            annotations=job.annotations or {}
        ),
        spec=job_spec
    )
    
    # Create the job in Kubernetes
    try:
        api_response = batch_v1.create_namespaced_job(
            namespace=job.namespace,
            body=k8s_job
        )
        
        # Update job status in database
        job.current_status = "running"
        db.add(job)
        db.commit()
        
        return {
            "job_id": job_id,
            "status": "running",
            "pod_name": api_response.metadata.name
        }
    except ApiException as e:
        raise HTTPException(status_code=500, detail=f"Kubernetes API error: {e.body}")

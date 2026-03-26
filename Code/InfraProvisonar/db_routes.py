from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from database import get_db, DBInstance, AdminConfig
from models import DBProvisionRequest, DBStatusResponse
from kubernetes_client import K8sClient
import uuid
import random
import string

router = APIRouter(prefix="/db", tags=["db"])
k8s = K8sClient()

def generate_short_id(length=6):
    return ''.join(random.choices(string.ascii_lowercase + string.digits, k=length))

@router.post("/provision", response_model=DBStatusResponse)
def provision_db(payload: DBProvisionRequest, db: Session = Depends(get_db)):
    # 1. Handle NodePort Logic
    nodeport = None
    config = db.query(AdminConfig).first()
    
    if payload.nodeport:
        # Auto Assignment only
        # Ensure we start from nodeport_start if last_used is lower
        next_port = max(config.last_used_nodeport + 1, config.nodeport_start)
        max_port = config.nodeport_start + config.nodeport_range
        
        if next_port >= max_port:
            raise HTTPException(status_code=400, detail="No more NodePorts available in defined range.")
            
        nodeport = next_port
        config.last_used_nodeport = next_port
        db.commit()

    # 2. Namespace Logic
    if payload.namespace:
        namespace = payload.namespace
    elif payload.tenant_id and payload.tenant_id.replace('-', '').isalnum():
        namespace = payload.tenant_id
    else:
        namespace = settings.DEFAULT_NAMESPACE

    try:
        # 3. Create CNPG Cluster
        k8s.create_cnpg_cluster(
            name=payload.name,
            namespace=namespace,
            instances=payload.instance_count,
            storage_size=payload.size,
            storage_class=payload.storage_class_name,
            cpu_request=payload.resource_request.get("cpu", "250m"),
            mem_request=payload.resource_request.get("memory", "256Mi"),
            cpu_limit=payload.resource_limit.get("cpu", "500m"),
            mem_limit=payload.resource_limit.get("memory", "512Mi"),
            db_name=payload.db_name,
            owner=payload.app_user,
            password=payload.app_password,
            root_password=payload.root_password,
            nodeport=nodeport
        )

        # 4. Connection Details
        service_name = f"{payload.name}-rw" # CNPG default
        if nodeport:
            service_name = f"{payload.name}-nodeport"

        # 5. Connection String
        host = config.node_ip if nodeport else f"{payload.name}-rw.{namespace}.svc.cluster.local"
        port = nodeport if nodeport else 5432
        conn_str = f"postgresql://{payload.app_user}:{payload.app_password}@{host}:{port}/{payload.db_name}"

        # 6. Store in Database
        short_id = generate_short_id()
        db_instance = DBInstance(
            id=short_id,
            tenant_id=payload.tenant_id,
            name=payload.name,
            instance_count=payload.instance_count,
            size=payload.size,
            root_password=payload.root_password,
            app_user=payload.app_user,
            app_password=payload.app_password,
            db_name=payload.db_name,
            storage_class_name=payload.storage_class_name,
            resource_request=payload.resource_request,
            resource_limit=payload.resource_limit,
            nodeport_enabled=payload.nodeport,
            nodeport=nodeport,
            status="Provisioning",
            service_name=service_name,
            connection_string=conn_str,
            namespace=namespace
        )
        db.add(db_instance)
        db.commit()
        db.refresh(db_instance)

        return db_instance

    except Exception as e:
        db.rollback()
        raise HTTPException(status_code=500, detail=str(e))

@router.get("/{db_id}/status", response_model=DBStatusResponse)
def get_db_status(db_id: str, db: Session = Depends(get_db)):
    db_instance = db.query(DBInstance).filter(DBInstance.id == db_id).first()
    if not db_instance:
        raise HTTPException(status_code=404, detail="DB instance not found")
    
    # Update status from K8s
    namespace = db_instance.namespace or "default"
    k8s_status = k8s.get_cluster_status(db_instance.name, namespace)
    db_instance.status = k8s_status
    db.commit()
    
    return db_instance

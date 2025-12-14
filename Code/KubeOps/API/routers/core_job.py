from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
import crud, schemas, db

router = APIRouter()


@router.get("/", response_model=dict)
def list_jobs(skip: int = 0, limit: int = 100, db: Session = Depends(db.get_db)):
    jobs = crud.get_jobs(db, skip=skip, limit=limit)
    return {"jobs": [schemas.JobOut.from_orm(j) for j in jobs]}


@router.post("/", response_model=schemas.JobOut)
def create_job(job_in: schemas.JobCreate, db: Session = Depends(db.get_db)):
    j = crud.create_job(db, job_in.name, job_in.namespace, job_in.worker_id, job_in.arguments)
    return schemas.JobOut.from_orm(j)


@router.post("/{job_id}/execute", response_model=schemas.JobExecuteResponse)
def execute_job(job_id: int, db: Session = Depends(db.get_db)):
    # Placeholder implementation: return running status
    return {"job_id": job_id, "status": "running", "pod_name": f"worker-job-{job_id}-abc123"}

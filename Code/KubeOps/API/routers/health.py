from fastapi import APIRouter, Depends
import schemas

router = APIRouter()


@router.get("/health", response_model=dict)
def cluster_health():
    return {"status": "healthy", "nodes": 1, "pods": 0}


@router.get("/deployments", response_model=dict)
def list_deployments():
    return {"deployments": []}


@router.post("/health/schedule", response_model=dict)
def schedule_health(check_data: schemas.HealthScheduleRequest):
    # Placeholder: accept the schedule and return success
    return {"status": "scheduled", "job_id": check_data.job_id, "interval_minutes": check_data.interval_minutes}

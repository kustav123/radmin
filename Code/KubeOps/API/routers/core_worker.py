from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
import crud, schemas, db
from deps import get_current_user, require_role

router = APIRouter()


@router.get("/")
def list_workers(skip: int = 0, limit: int = 100, db: Session = Depends(db.get_db), current_user: object = Depends(get_current_user)):
    workers = crud.get_workers(db, skip=skip, limit=limit)
    return {"workers": [schemas.WorkerOut.from_orm(w) for w in workers]}


@router.post("/")
def create_worker(worker_in: schemas.WorkerCreate, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("operator"))):
    w = crud.create_worker(db, worker_in.name, worker_in.image_url, worker_in.type)
    return schemas.WorkerOut.from_orm(w)


@router.patch("/{worker_id}")
def patch_worker(worker_id: int, payload: dict, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("operator"))):
    # simple partial update for status
    worker = db.query(db.Base.classes.worker).filter_by(id=worker_id).first() if hasattr(db.Base, 'classes') else None
    if not worker:
        # fallback: try ORM model
        from models import Worker
        worker = db.query(Worker).filter(Worker.id == worker_id).first()
    if not worker:
        raise HTTPException(status_code=404, detail="Worker not found")
    if 'status' in payload:
        worker.status = payload['status']
    db.add(worker)
    db.commit()
    db.refresh(worker)
    return schemas.WorkerOut.from_orm(worker)


@router.delete("/{worker_id}")
def delete_worker(worker_id: int, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("operator"))):
    from models import Worker
    worker = db.query(Worker).filter(Worker.id == worker_id).first()
    if not worker:
        raise HTTPException(status_code=404, detail="Worker not found")
    db.delete(worker)
    db.commit()
    return {"status": "deleted"}

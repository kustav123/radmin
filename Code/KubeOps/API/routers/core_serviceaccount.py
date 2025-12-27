from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from sqlalchemy.exc import IntegrityError
import crud, schemas, db, models
from deps import get_current_user, require_role

router = APIRouter()


@router.get("/")
def list_serviceaccounts(skip: int = 0, limit: int = 100, db: Session = Depends(db.get_db), current_user: object = Depends(get_current_user)):
    """List all service accounts"""
    serviceaccounts = crud.get_serviceaccounts(db, skip=skip, limit=limit)
    return {"serviceaccounts": [schemas.ServiceAccountOut.from_orm(sa) for sa in serviceaccounts]}


@router.post("/")
def create_serviceaccount(sa_in: schemas.ServiceAccountCreate, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("operator"))):
    """Create a new service account"""
    try:
        sa = crud.create_serviceaccount(db, sa_in.name)
        return schemas.ServiceAccountOut.from_orm(sa)
    except IntegrityError as ie:
        db.rollback()
        raise HTTPException(status_code=400, detail=f"Service account with this name already exists: {ie.orig}")


@router.patch("/{sa_id}")
def patch_serviceaccount(sa_id: int, payload: dict, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("operator"))):
    """Update service account (partial update)"""
    sa = db.query(models.ServiceAccount).filter(models.ServiceAccount.id == sa_id).first()
    if not sa:
        raise HTTPException(status_code=404, detail="Service account not found")
    
    # Allow partial updates for name only
    if "name" in payload and payload["name"] is not None:
        sa.name = payload["name"]
        try:
            db.add(sa)
            db.commit()
            db.refresh(sa)
        except IntegrityError as ie:
            db.rollback()
            raise HTTPException(status_code=400, detail=f"Database integrity error: {ie.orig}")
    
    return schemas.ServiceAccountOut.from_orm(sa)


@router.delete("/{sa_id}")
def delete_serviceaccount(sa_id: int, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("operator"))):
    """Delete a service account"""
    sa = crud.get_serviceaccount_by_id(db, sa_id)
    if not sa:
        raise HTTPException(status_code=404, detail="Service account not found")
    
    # Check if any job is using this service account
    jobs_using_sa = db.query(models.Job).filter(models.Job.service_account_id == sa_id).count()
    if jobs_using_sa > 0:
        raise HTTPException(
            status_code=400, 
            detail=f"Cannot delete service account. {jobs_using_sa} job(s) are using this service account."
        )
    
    crud.delete_serviceaccount(db, sa_id)
    return {"message": "Service account deleted successfully", "id": sa_id}

from fastapi import APIRouter, UploadFile, File, Depends, HTTPException
from sqlalchemy.orm import Session
import os, shutil
import crud, db, schemas

router = APIRouter()

UPLOAD_DIR = os.getenv("UPLOAD_DIR", "uploads")
os.makedirs(UPLOAD_DIR, exist_ok=True)


@router.post("/{job_id}", response_model=schemas.UploadResponse)
def upload_files(job_id: int, files: list[UploadFile] = File(...), db: Session = Depends(db.get_db)):
    uploaded = []
    job_folder = os.path.join(UPLOAD_DIR, f"job_{job_id}")
    os.makedirs(job_folder, exist_ok=True)
    for f in files:
        dest = os.path.join(job_folder, f.filename)
        with open(dest, "wb") as out:
            shutil.copyfileobj(f.file, out)
        stat = os.stat(dest)
        uploaded.append({"id": None, "filename": f.filename, "file_path": dest, "file_size": stat.st_size, "content_type": f.content_type, "uploaded_at": None})
    return {"uploaded": uploaded}


@router.get("/{job_id}/{filename}")
def download_file(job_id: int, filename: str):
    path = os.path.join(UPLOAD_DIR, f"job_{job_id}", filename)
    if not os.path.exists(path):
        raise HTTPException(status_code=404, detail="File not found")
    return {"download_url": f"/api/v1/files/{job_id}/{filename}", "file_path": path}

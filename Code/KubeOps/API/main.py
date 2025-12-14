from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import os
import logging

from db import engine, Base, SessionLocal
from routers import auth, core_worker, core_job, files, health
import crud

logger = logging.getLogger(__name__)

Base.metadata.create_all(bind=engine)

app = FastAPI(title="KubeOps API", openapi_url="/api/v1/openapi.json", docs_url="/docs")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(auth.router, prefix="/api/v1/auth", tags=["auth"])
app.include_router(core_worker.router, prefix="/api/v1/core/worker", tags=["worker"])
app.include_router(core_job.router, prefix="/api/v1/core/job", tags=["job"])
app.include_router(files.router, prefix="/api/v1/files", tags=["files"])
app.include_router(health.router, prefix="/api/v1/cluster", tags=["cluster"])


@app.get("/api/v1/health")
def health_check():
    return {"status": "healthy"}


@app.on_event("startup")
def create_default_admin():
    """Seed a default admin user if it doesn't exist.

    This is intentionally simple for development: username `admin`,
    password `kubeops`, role `admin`. In production change/remove this.
    """
    username = "admin"
    email = "admin@example.com"
    password = "kubeops"

    db = SessionLocal()
    try:
        user = crud.get_or_create_admin(db, username=username, email=email, password=password)
        if user:
            logger.info(f"Ensured admin user '{user.username}' exists (id={user.id})")
    except Exception as e:
        logger.exception("Failed to ensure default admin user: %s", e)
    finally:
        db.close()


if __name__ == "__main__":
    import uvicorn

    uvicorn.run("main:app", host="0.0.0.0", port=8000, reload=True)


@app.get('/__debug/read_auth')
def __debug_read_auth():
    """Return the on-disk contents of routers/auth.py (for debugging reloads)."""
    try:
        from pathlib import Path
        p = Path(__file__).parent / 'routers' / 'auth.py'
        return {"path": str(p), "exists": p.exists(), "content_head": p.read_text(encoding='utf-8')[:4000]}
    except Exception as e:
        return {"error": str(e)}

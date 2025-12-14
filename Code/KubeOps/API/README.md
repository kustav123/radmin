# KubeOps API

This folder contains a FastAPI-based API server for KubeOps. It includes:

- SQLAlchemy models in `models.py`
- Simple JWT auth helpers in `security.py`
- Routers under `routers/` for auth, workers, jobs, files, and health
- Alembic configuration in `alembic/` for database migrations

To run locally:

```powershell
python -m venv venv; .\venv\Scripts\Activate.ps1
pip install -r requirements.txt
uvicorn main:app --reload
```

Database defaults to `sqlite:///./kubeops.db`. Set `DATABASE_URL` to change.

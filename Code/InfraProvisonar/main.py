from fastapi import FastAPI
from database import init_db
from db_routes import router as db_router
from admin_routes import router as admin_router
from config import settings

app = FastAPI(
    title="PostGres Provisioner API",
    description="Interface to provision PostgreSQL clusters via CloudNativePG CRD",
    openapi_url="/openapi.json" if settings.SHOW_SWAGGER else None,
    docs_url="/docs" if settings.SHOW_SWAGGER else None,
)

# Init DB on startup
@app.on_event("startup")
def startup_event():
    init_db()

app.include_router(db_router)
app.include_router(admin_router)

@app.get("/")
def read_root():
    return {"message": "Infra Provisioner Service Active"}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)

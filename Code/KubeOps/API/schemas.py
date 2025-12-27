from typing import Optional, List, Any
from pydantic import BaseModel, EmailStr
from datetime import datetime


class UserCreate(BaseModel):
    username: str
    email: EmailStr
    password: str
    role: Optional[str] = "user"
    class Config:
        json_schema_extra = {
            "example": {
                "username": "johndoe",
                "email": "john.doe@example.com",
                "password": "securepassword",
                "role": "operator"
            }
        }


class UserOut(BaseModel):
    id: int
    username: str
    email: EmailStr
    role: str
    created_at: Optional[datetime]

    class Config:
        from_attributes = True


class WorkerBase(BaseModel):
    name: str
    image_url: str
    type: str


class WorkerCreate(WorkerBase):
    pass
    class Config:
        json_schema_extra = {
            "example": {
                "name": "helm-deployer",
                "image_url": "nginx:latest",
                "type": "helm"
            }
        }


class WorkerOut(WorkerBase):
    id: int
    status: str
    created_at: Optional[datetime]

    class Config:
        from_attributes = True


class ServiceAccountCreate(BaseModel):
    name: str
    
    class Config:
        json_schema_extra = {
            "example": {
                "name": "my-service-account"
            }
        }


class ServiceAccountOut(BaseModel):
    id: int
    name: str
    created_at: Optional[datetime]

    class Config:
        from_attributes = True


class JobCreate(BaseModel):
    name: str
    namespace: str
    worker_id: int
    service_account_id: Optional[int] = None
    
    # Kubernetes Job Spec Parameters
    completions: Optional[int] = None
    parallelism: Optional[int] = None
    backoff_limit: Optional[int] = 6
    active_deadline_seconds: Optional[int] = None
    ttl_seconds_after_finished: Optional[int] = None
    
    # Pod Template Parameters
    restart_policy: Optional[str] = "Never"
    image: Optional[str] = None  # If not provided, fetched from worker.image_url
    command: Optional[List[str]] = None
    args: Optional[List[str]] = None
    env_vars: Optional[dict] = None
    resources: Optional[dict] = None
    volumes: Optional[List[dict]] = None
    volume_mounts: Optional[List[dict]] = None
    image_pull_secrets: Optional[List[str]] = None
    
    # Metadata
    labels: Optional[dict] = None
    annotations: Optional[dict] = None
    
    # Worker-specific arguments
    arguments: Any
    
    class Config:
        json_schema_extra = {
            "example": {
                "name": "test-job",
                "namespace": "default",
                "worker_id": 1,
                "service_account_id": 1,
                "backoff_limit": 3,
                "completions": 1,
                "parallelism": 1,
                "restart_policy": "Never",
                "command": ["sh", "-c", "echo Hello from Kubernetes Job && sleep 5"],
                "env_vars": {
                    "ENV_VAR": "value"
                },
                "labels": {
                    "app": "test",
                    "env": "dev"
                },
                "arguments": {
                    "custom": "data"
                }
            },
            "description": "Note: image is automatically fetched from the worker's image_url. You can optionally override it by passing the image parameter."
        }


class LoginRequest(BaseModel):
    username: str
    password: str

    class Config:
        json_schema_extra = {
            "example": {"username": "admin", "password": "kubeops"}
        }


class ChangePasswordRequest(BaseModel):
    old_password: str
    new_password: str

    class Config:
        json_schema_extra = {
            "example": {"old_password": "oldpass", "new_password": "newSecurePass123"}
        }


class RoleUpdateRequest(BaseModel):
    role: str

    class Config:
        json_schema_extra = {"example": {"role": "operator"}}


class JobOut(BaseModel):
    id: int
    name: str
    namespace: str
    worker_id: int
    service_account_id: Optional[int]
    
    # Kubernetes Job Spec Parameters
    completions: Optional[int]
    parallelism: Optional[int]
    backoff_limit: Optional[int]
    active_deadline_seconds: Optional[int]
    ttl_seconds_after_finished: Optional[int]
    
    # Pod Template Parameters
    restart_policy: Optional[str]
    image: Optional[str]
    command: Optional[List[str]]
    args: Optional[List[str]]
    env_vars: Optional[dict]
    resources: Optional[dict]
    volumes: Optional[List[dict]]
    volume_mounts: Optional[List[dict]]
    image_pull_secrets: Optional[List[str]]
    
    # Metadata
    labels: Optional[dict]
    annotations: Optional[dict]
    
    # Worker-specific and status
    arguments: Any
    created_time: Optional[datetime]
    current_status: str

    class Config:
        from_attributes = True


class ArtifactOut(BaseModel):
    id: int
    filename: str
    file_path: str
    file_size: int
    content_type: str
    uploaded_at: Optional[datetime]

    class Config:
        from_attributes = True


class UploadResponse(BaseModel):
    uploaded: List[ArtifactOut]

    class Config:
        json_schema_extra = {
            "example": {
                "uploaded": [
                    {
                        "id": 1,
                        "filename": "values.yaml",
                        "file_path": "/uploads/job_1/values.yaml",
                        "file_size": 1024,
                        "content_type": "application/x-yaml",
                        "uploaded_at": "2023-01-01T00:00:00Z"
                    }
                ]
            }
        }


class JobExecuteResponse(BaseModel):
    job_id: int
    status: str
    pod_name: Optional[str]

    class Config:
        json_schema_extra = {
            "example": {"job_id": 1, "status": "running", "pod_name": "worker-job-1-abc123"}
        }


class NamespaceCreate(BaseModel):
    name: str

    class Config:
        json_schema_extra = {"example": {"name": "new-namespace"}}


class ScaleRequest(BaseModel):
    replicas: int

    class Config:
        json_schema_extra = {"example": {"replicas": 0}}


class HealthCheckItem(BaseModel):
    type: str
    url: Optional[str]
    host: Optional[str]
    port: Optional[int]
    expected_status: Optional[int]


class HealthScheduleRequest(BaseModel):
    job_id: int
    interval_minutes: int
    checks: List[HealthCheckItem]

    class Config:
        json_schema_extra = {
            "example": {
                "job_id": 1,
                "interval_minutes": 30,
                "checks": [
                    {"type": "http", "url": "http://myapp:8080/health", "expected_status": 200}
                ]
            }
        }

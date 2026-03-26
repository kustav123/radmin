from pydantic import BaseModel, Field
from typing import Optional, Dict

class DBProvisionRequest(BaseModel):
    name: str = Field(..., description="Name of the database cluster")
    instance_count: int = Field(default=3, description="Number of instances")
    size: str = Field(default="1Gi", description="Storage size")
    root_password: str = Field(..., description="PostgreSQL root password")
    app_user: str = Field(..., description="Application user name")
    app_password: str = Field(..., description="Application user password")
    db_name: str = Field(..., description="Initial database name")
    storage_class_name: str = Field(default="standard", description="K8s storage class name")
    resource_request: Dict[str, str] = Field(default={"cpu": "250m", "memory": "256Mi"})
    resource_limit: Dict[str, str] = Field(default={"cpu": "500m", "memory": "512Mi"})
    nodeport: bool = Field(default=False, description="Enable NodePort access")
    tenant_id: str = Field(..., description="Tenant identifier")
    namespace: Optional[str] = Field(default=None, description="Kubernetes namespace. Defaults to tenant_id if not provided.")

class DBStatusResponse(BaseModel):
    id: str
    name: str
    tenant_id: str
    status: str
    nodeport: Optional[int]
    service_name: Optional[str]
    connection_string: Optional[str]
    namespace: Optional[str]

class AdminConfigResponse(BaseModel):
    node_ip: str
    nodeport_start: int
    nodeport_range: int
    last_used: int

class AdminConfigSetIP(BaseModel):
    node_ip: str

class AdminConfigSetPortRange(BaseModel):
    nodeport_start: Optional[int] = None
    nodeport_range: Optional[int] = None
    last_used: Optional[int] = None

class AdminNodeIPResponse(BaseModel):
    node_ip: str

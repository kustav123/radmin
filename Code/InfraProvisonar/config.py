import os
from pydantic_settings import BaseSettings, SettingsConfigDict

class Settings(BaseSettings):
    IN_CLUSTER: bool = False
    SERVICE_ACCOUNT_NAME: str = "infra-provisioner-sa"
    SHOW_SWAGGER: bool = True
    NODE_IP: str = "0.0.0.0"  # To be updated via admin API
    NODEPORT_START: int = 30000
    NODEPORT_RANGE: int = 50
    DATABASE_URL: str = "sqlite:///./infra_provisioner.db"
    DEFAULT_NAMESPACE: str = "default"

    model_config = SettingsConfigDict(env_file=".env", env_file_encoding="utf-8")

settings = Settings()

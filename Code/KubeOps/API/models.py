from sqlalchemy import Column, Integer, String, DateTime, ForeignKey, JSON, Boolean, func, Text
from sqlalchemy.orm import relationship
from db import Base


class User(Base):
    __tablename__ = "users"
    id = Column(Integer, primary_key=True, index=True)
    username = Column(String(100), unique=True, nullable=False, index=True)
    email = Column(String(255), unique=True, nullable=False)
    password_hash = Column(String(255), nullable=False)
    role = Column(String(50), nullable=False, default="user")
    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(DateTime(timezone=True), server_default=func.now(), onupdate=func.now())


class Worker(Base):
    __tablename__ = "worker"
    id = Column(Integer, primary_key=True, index=True)
    name = Column(String(255), unique=True, nullable=False)
    image_url = Column(String(500), nullable=False)
    type = Column(String(50), nullable=False)
    status = Column(String(50), nullable=False, default="active")
    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(DateTime(timezone=True), server_default=func.now(), onupdate=func.now())
    jobs = relationship("Job", back_populates="worker")


class Job(Base):
    __tablename__ = "job"
    id = Column(Integer, primary_key=True, index=True)
    name = Column(String(255), nullable=False)
    namespace = Column(String(255), nullable=False)
    worker_id = Column(Integer, ForeignKey("worker.id"), nullable=False)
    arguments = Column(JSON, nullable=False)
    created_time = Column(DateTime(timezone=True), server_default=func.now())
    last_reconciled = Column(DateTime(timezone=True), nullable=True)
    current_status = Column(String(50), nullable=False, default="pending")
    updated_at = Column(DateTime(timezone=True), server_default=func.now(), onupdate=func.now())
    worker = relationship("Worker", back_populates="jobs")
    artifacts = relationship("Artifact", back_populates="job")
    health_checks = relationship("HealthCheck", back_populates="job")


class Artifact(Base):
    __tablename__ = "artifacts"
    id = Column(Integer, primary_key=True, index=True)
    job_id = Column(Integer, ForeignKey("job.id"), nullable=False)
    filename = Column(String(255), nullable=False)
    file_path = Column(String(500), nullable=False)
    file_size = Column(Integer, nullable=False)
    content_type = Column(String(100), nullable=False)
    uploaded_at = Column(DateTime(timezone=True), server_default=func.now())
    job = relationship("Job", back_populates="artifacts")


class HealthCheck(Base):
    __tablename__ = "health_checks"
    id = Column(Integer, primary_key=True, index=True)
    job_id = Column(Integer, ForeignKey("job.id"), nullable=False)
    check_type = Column(String(50), nullable=False)
    check_config = Column(JSON, nullable=False)
    interval_minutes = Column(Integer, nullable=False)
    last_check = Column(DateTime(timezone=True), nullable=True)
    last_status = Column(String(50), nullable=True)
    consecutive_failures = Column(Integer, nullable=False, default=0)
    enabled = Column(Boolean, nullable=False, default=True)
    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(DateTime(timezone=True), server_default=func.now(), onupdate=func.now())
    job = relationship("Job", back_populates="health_checks")

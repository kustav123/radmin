from sqlalchemy import Column, Integer, String, Boolean, JSON, create_engine
from sqlalchemy.orm import declarative_base, sessionmaker
from config import settings

Base = declarative_base()

class DBInstance(Base):
    __tablename__ = "db_instances"

    id = Column(String, primary_key=True)
    tenant_id = Column(String, index=True)
    name = Column(String)
    instance_count = Column(Integer)
    size = Column(String)
    root_password = Column(String)
    app_user = Column(String)
    app_password = Column(String)
    db_name = Column(String)
    storage_class_name = Column(String)
    resource_request = Column(JSON)
    resource_limit = Column(JSON)
    nodeport_enabled = Column(Boolean)
    nodeport = Column(Integer, nullable=True)
    status = Column(String, default="Provisioning")
    service_name = Column(String, nullable=True)
    connection_string = Column(String, nullable=True)
    namespace = Column(String, nullable=True)

class AdminConfig(Base):
    __tablename__ = "admin_config"

    id = Column(Integer, primary_key=True)
    node_ip = Column(String, default="0.0.0.0")
    nodeport_start = Column(Integer, default=30000)
    nodeport_range = Column(Integer, default=50)
    last_used_nodeport = Column(Integer, default=29999) # Start from 1 less than start

engine = create_engine(settings.DATABASE_URL, connect_args={"check_same_thread": False})
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

def init_db():
    Base.metadata.create_all(bind=engine)
    db = SessionLocal()
    # Seed default admin config if it doesn't exist
    if not db.query(AdminConfig).first():
        config = AdminConfig(
            node_ip=settings.NODE_IP,
            nodeport_start=settings.NODEPORT_START,
            nodeport_range=settings.NODEPORT_RANGE,
            last_used_nodeport=settings.NODEPORT_START - 1
        )
        db.add(config)
        db.commit()
    db.close()

def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

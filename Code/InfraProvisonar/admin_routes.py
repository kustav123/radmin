from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from database import get_db, AdminConfig
from models import AdminConfigResponse, AdminConfigSetIP, AdminConfigSetPortRange, AdminNodeIPResponse

router = APIRouter(prefix="/admin", tags=["admin"])

@router.get("/getnodeip", response_model=AdminNodeIPResponse)
def get_node_ip(db: Session = Depends(get_db)):
    config = db.query(AdminConfig).first()
    return AdminNodeIPResponse(node_ip=config.node_ip)

@router.post("/setnodeip")
def set_node_ip(payload: AdminConfigSetIP, db: Session = Depends(get_db)):
    config = db.query(AdminConfig).first()
    config.node_ip = payload.node_ip
    db.commit()
    return {"message": "Node IP updated successfully", "node_ip": config.node_ip}

@router.get("/getnodeport", response_model=AdminConfigResponse)
def get_node_port_range(db: Session = Depends(get_db)):
    config = db.query(AdminConfig).first()
    return AdminConfigResponse(
        node_ip=config.node_ip,
        nodeport_start=config.nodeport_start,
        nodeport_range=config.nodeport_range,
        last_used=config.last_used_nodeport
    )

@router.post("/setnodeport")
def set_node_port_range(payload: AdminConfigSetPortRange, db: Session = Depends(get_db)):
    config = db.query(AdminConfig).first()
    
    if payload.nodeport_start is not None:
        config.nodeport_start = payload.nodeport_start
        # Reset last used to start - 1 if new range starts later
        if config.last_used_nodeport < payload.nodeport_start:
            config.last_used_nodeport = payload.nodeport_start - 1
            
    if payload.nodeport_range is not None:
        config.nodeport_range = payload.nodeport_range
        
    if payload.last_used is not None:
        config.last_used_nodeport = payload.last_used
        
    db.commit()
    return {"message": "NodePort configuration updated successfully"}

from fastapi import Depends, HTTPException
from fastapi.security import HTTPBearer, HTTPAuthorizationCredentials
from sqlalchemy.orm import Session

import db, crud, models, security

security_scheme = HTTPBearer()


def get_db_session():
    # use SessionLocal directly to avoid generator coupling
    db_session = db.SessionLocal()
    try:
        yield db_session
    finally:
        db_session.close()


def get_current_user(credentials: HTTPAuthorizationCredentials = Depends(security_scheme), db: Session = Depends(get_db_session)):
    token = credentials.credentials
    payload = security.decode_access_token(token)
    if not payload:
        raise HTTPException(status_code=401, detail="Invalid token")
    user_id = payload.get("sub")
    try:
        user = db.query(models.User).filter(models.User.id == int(user_id)).first()
    except Exception:
        user = None
    if not user:
        raise HTTPException(status_code=401, detail="User not found")
    return user


def require_role(required_role: str):
    def role_checker(current_user: models.User = Depends(get_current_user)):
        role_hierarchy = {"user": 1, "operator": 2, "admin": 3}
        user_level = role_hierarchy.get(current_user.role, 0)
        required_level = role_hierarchy.get(required_role, 999)
        if user_level < required_level:
            raise HTTPException(status_code=403, detail="Insufficient permissions")
        return current_user

    return role_checker

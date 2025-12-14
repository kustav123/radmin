from fastapi import APIRouter, Depends, HTTPException
import logging
from sqlalchemy.orm import Session

import crud, schemas, db, security
from deps import get_current_user, require_role

router = APIRouter()
logger = logging.getLogger(__name__)


@router.post("/register")
def register(user_in: schemas.UserCreate, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("admin"))):
    """Register a new user. Restricted to admin users by default."""
    existing = crud.get_user_by_username(db, user_in.username)
    if existing:
        raise HTTPException(status_code=400, detail="Username already exists")
    try:
        user = crud.create_user(db, user_in.username, user_in.email, user_in.password, user_in.role)
    except ValueError as ve:
        raise HTTPException(status_code=400, detail=str(ve))

    return {"id": user.id, "username": user.username, "email": user.email, "role": user.role}


@router.post("/login")
def login(login_in: schemas.LoginRequest, db: Session = Depends(db.get_db)):
    username = login_in.username
    password = login_in.password
    user = crud.get_user_by_username(db, username)
    if not user:
        logger.debug("login: user '%s' not found", username)
        raise HTTPException(status_code=401, detail="Invalid credentials")

    # log minimal info for debugging
    try:
        ph = user.password_hash
        logger.debug("login: user='%s' hash-prefix='%s' hash-len=%d", username, ph[:8], len(ph))
        print(f"[DEBUG] Login attempt: username={username}")
        print(f"[DEBUG] Stored hash: {ph[:50]}...")
        print(f"[DEBUG] Password received: {password}")
    except Exception:
        logger.debug("login: user='%s' has missing/invalid password_hash", username)

    if not security.verify_password(password, user.password_hash):
        print(f"[DEBUG] Password verification FAILED")
        logger.debug("login: password verification failed for user '%s'", username)
        raise HTTPException(status_code=401, detail="Invalid credentials")
    print(f"[DEBUG] Password verification SUCCESS")
    token = security.create_access_token(str(user.id))
    return {"access_token": token, "token_type": "bearer", "expires_in": 3600, "user": {"id": user.id, "username": user.username, "role": user.role}}


@router.get("/me")
def me(current_user: object = Depends(get_current_user)):
    return schemas.UserOut.from_orm(current_user)


@router.get("/debug/inspect")
def debug_inspect(username: str, password: str, db: Session = Depends(db.get_db)):
    """Debug endpoint: returns what the server sees for a username and whether the password verifies.
    Only intended for local development debugging and should be removed before production."""
    user = crud.get_user_by_username(db, username)
    if not user:
        return {"found": False}
    ph = user.password_hash
    verified = security.verify_password(password, ph)
    return {"found": True, "username": user.username, "hash_prefix": ph[:12], "hash_len": len(ph), "verified": verified}

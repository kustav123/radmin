from fastapi import APIRouter, Depends, HTTPException, Header, Response, Cookie
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
def login(login_in: schemas.LoginRequest, db: Session = Depends(db.get_db), response: Response = None):
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
    except Exception:
        logger.debug("login: user='%s' has missing/invalid password_hash", username)

    if not security.verify_password(password, user.password_hash):
        logger.debug("login: password verification failed for user '%s'", username)
        raise HTTPException(status_code=401, detail="Invalid credentials")
    token = security.create_access_token(str(user.id))
    # create a long-lived refresh token and set it as a HttpOnly cookie
    refresh = security.create_refresh_token(str(user.id))
    if response is not None:
        # In production set secure=True and appropriate samesite depending on deployment
        response.set_cookie(key="refresh_token", value=refresh, httponly=True, samesite="Lax", secure=False, max_age=security.REFRESH_TOKEN_EXPIRE_MINUTES * 60)
    return {"access_token": token, "token_type": "bearer", "expires_in": 3600, "user": {"id": user.id, "username": user.username, "role": user.role}}


@router.get("/me")
def me(current_user: object = Depends(get_current_user)):
    return schemas.UserOut.from_orm(current_user)


@router.post("/change-password")
def change_password(req: schemas.ChangePasswordRequest, db: Session = Depends(db.get_db), current_user: object = Depends(get_current_user)):
    """Change password for the current authenticated user. Requires current password."""
    # Verify current password
    if not security.verify_password(req.old_password, current_user.password_hash):
        logger.debug("change_password: incorrect current password for user '%s'", current_user.username)
        raise HTTPException(status_code=401, detail="Current password is incorrect")
    try:
        crud.update_user_password(db, current_user.id, req.new_password)
    except ValueError as ve:
        raise HTTPException(status_code=400, detail=str(ve))
    return {"status": "ok", "message": "Password changed"}


@router.patch("/users/{user_id}/role")
def update_role(user_id: int, req: schemas.RoleUpdateRequest, db: Session = Depends(db.get_db), current_user: object = Depends(require_role("admin"))):
    """Update a user's role. Admin-only operation."""
    try:
        user = crud.update_user_role(db, user_id, req.role)
    except ValueError as ve:
        raise HTTPException(status_code=404 if "not found" in str(ve).lower() else 400, detail=str(ve))
    return {"id": user.id, "username": user.username, "role": user.role}



@router.post("/refresh")
def refresh_token(refresh_token: str = Cookie(None), db: Session = Depends(db.get_db), response: Response = None):
    """Refresh an access token.

    This endpoint reads the refresh token from an HttpOnly cookie named `refresh_token`. It does NOT accept Bearer tokens in the Authorization header. If the cookie is valid and the user exists, a new access token is returned and the refresh cookie is rotated.
    """
    if not refresh_token:
        raise HTTPException(status_code=401, detail="Missing refresh token cookie")
    payload = security.decode_access_token(refresh_token)
    if not payload:
        raise HTTPException(status_code=401, detail="Invalid or expired token")
    user_id = payload.get("sub")
    if not user_id:
        raise HTTPException(status_code=401, detail="Invalid token payload")
    user = crud.get_user_by_id(db, int(user_id))
    if not user:
        raise HTTPException(status_code=401, detail="User not found")
    new_token = security.create_access_token(str(user.id))
    # Optionally rotate the refresh token by issuing a new cookie
    new_refresh = security.create_refresh_token(str(user.id))
    if response is not None:
        response.set_cookie(key="refresh_token", value=new_refresh, httponly=True, samesite="Lax", secure=False, max_age=security.REFRESH_TOKEN_EXPIRE_MINUTES * 60)
    return {"access_token": new_token, "token_type": "bearer", "expires_in": 3600}


# Note: debug endpoints removed for security. If you need runtime inspection, use local REPL or logs.

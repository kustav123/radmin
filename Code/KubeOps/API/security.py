import os
from datetime import datetime, timedelta
from typing import Optional

from passlib.context import CryptContext
from jose import JWTError, jwt
import logging

PWD_CONTEXT = CryptContext(schemes=["argon2", "bcrypt"], default="argon2", deprecated="auto")
SECRET_KEY = os.getenv("JWT_SECRET", "change-me-in-prod")
ALGORITHM = "HS256"
ACCESS_TOKEN_EXPIRE_MINUTES = 60
REFRESH_TOKEN_EXPIRE_MINUTES = 60 * 24 * 7  # 7 days
logger = logging.getLogger(__name__)


def get_password_hash(password: str) -> str:
    if not isinstance(password, str):
        password = str(password)

    # Use passlib CryptContext (argon2 default). If passlib fails for any reason,
    # fall back to argon2-cffi's PasswordHasher, then finally bcrypt.
    try:
        return PWD_CONTEXT.hash(password)
    except Exception:
        # Try argon2-cffi directly
        try:
            from argon2 import PasswordHasher as _Ph

            ph = _Ph()
            return ph.hash(password)
        except Exception:
            try:
                import bcrypt as _bcrypt

                hashed = _bcrypt.hashpw(password.encode("utf-8"), _bcrypt.gensalt())
                return hashed.decode("utf-8")
            except Exception:
                raise


def verify_password(plain_password: str, hashed_password: str) -> bool:
    # Accept non-str inputs by coercing
    if not isinstance(plain_password, str):
        plain_password = str(plain_password)

    logger.debug("verify_password called for user (password censored)")

    # Try passlib first (handles argon2 and bcrypt transparently)
    try:
        logger.debug("Trying PWD_CONTEXT.verify")
        ok = PWD_CONTEXT.verify(plain_password, hashed_password)
        logger.debug("PWD_CONTEXT.verify returned: %s", ok)
        if ok:
            return True
    except Exception as e:
        logger.debug("PWD_CONTEXT.verify raised: %s: %s", type(e).__name__, e)

    # If the hash looks like an argon2 hash, try argon2-cffi directly
    try:
        if isinstance(hashed_password, str) and hashed_password.startswith("$argon2"):
            logger.debug("Trying argon2-cffi PasswordHasher")
            from argon2 import PasswordHasher as _Ph

            ph = _Ph()
            try:
                result = ph.verify(hashed_password, plain_password)
                logger.debug("argon2-cffi verify succeeded: %s", result)
                return True
            except Exception as e2:
                logger.debug("argon2-cffi verify raised: %s: %s", type(e2).__name__, e2)
                return False
    except Exception as e3:
        logger.debug("argon2-cffi block raised: %s: %s", type(e3).__name__, e3)

    # Fallback to bcrypt.checkpw for legacy bcrypt hashes
    try:
        logger.debug("Trying bcrypt.checkpw fallback")
        import bcrypt as _bcrypt

        result = _bcrypt.checkpw(plain_password.encode("utf-8"), hashed_password.encode("utf-8"))
        logger.debug("bcrypt.checkpw returned: %s", result)
        return result
    except Exception as e4:
        logger.debug("bcrypt.checkpw raised: %s: %s", type(e4).__name__, e4)
        return False


def create_access_token(subject: str, expires_delta: Optional[timedelta] = None):
    to_encode = {"sub": str(subject)}
    expire = datetime.utcnow() + (expires_delta or timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES))
    to_encode.update({"exp": expire})
    encoded = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)
    return encoded


def create_refresh_token(subject: str, expires_delta: Optional[timedelta] = None):
    to_encode = {"sub": str(subject)}
    expire = datetime.utcnow() + (expires_delta or timedelta(minutes=REFRESH_TOKEN_EXPIRE_MINUTES))
    to_encode.update({"exp": expire})
    encoded = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)
    return encoded


def decode_access_token(token: str):
    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        return payload
    except JWTError:
        return None

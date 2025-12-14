import os
from datetime import datetime, timedelta
from typing import Optional

from passlib.context import CryptContext
from jose import JWTError, jwt

PWD_CONTEXT = CryptContext(schemes=["argon2", "bcrypt"], default="argon2", deprecated="auto")
SECRET_KEY = os.getenv("JWT_SECRET", "change-me-in-prod")
ALGORITHM = "HS256"
ACCESS_TOKEN_EXPIRE_MINUTES = 60


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

    print(f"[SECURITY DEBUG] verify_password called")
    print(f"[SECURITY DEBUG]   plain_password: {plain_password}")
    print(f"[SECURITY DEBUG]   hashed_password: {hashed_password[:50]}...")

    # Try passlib first (handles argon2 and bcrypt transparently)
    try:
        print(f"[SECURITY DEBUG] Trying PWD_CONTEXT.verify...")
        ok = PWD_CONTEXT.verify(plain_password, hashed_password)
        print(f"[SECURITY DEBUG] PWD_CONTEXT.verify returned: {ok}")
        if ok:
            return True
    except Exception as e:
        print(f"[SECURITY DEBUG] PWD_CONTEXT.verify raised: {type(e).__name__}: {e}")

    # If the hash looks like an argon2 hash, try argon2-cffi directly
    try:
        if isinstance(hashed_password, str) and hashed_password.startswith("$argon2"):
            print(f"[SECURITY DEBUG] Trying argon2-cffi PasswordHasher...")
            from argon2 import PasswordHasher as _Ph

            ph = _Ph()
            try:
                result = ph.verify(hashed_password, plain_password)
                print(f"[SECURITY DEBUG] argon2-cffi verify succeeded: {result}")
                return True
            except Exception as e2:
                print(f"[SECURITY DEBUG] argon2-cffi verify raised: {type(e2).__name__}: {e2}")
                return False
    except Exception as e3:
        print(f"[SECURITY DEBUG] argon2-cffi block raised: {type(e3).__name__}: {e3}")

    # Fallback to bcrypt.checkpw for legacy bcrypt hashes
    try:
        print(f"[SECURITY DEBUG] Trying bcrypt.checkpw fallback...")
        import bcrypt as _bcrypt

        result = _bcrypt.checkpw(plain_password.encode("utf-8"), hashed_password.encode("utf-8"))
        print(f"[SECURITY DEBUG] bcrypt.checkpw returned: {result}")
        return result
    except Exception as e4:
        print(f"[SECURITY DEBUG] bcrypt.checkpw raised: {type(e4).__name__}: {e4}")
        return False


def create_access_token(subject: str, expires_delta: Optional[timedelta] = None):
    to_encode = {"sub": str(subject)}
    expire = datetime.utcnow() + (expires_delta or timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES))
    to_encode.update({"exp": expire})
    encoded = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)
    return encoded


def decode_access_token(token: str):
    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        return payload
    except JWTError:
        return None

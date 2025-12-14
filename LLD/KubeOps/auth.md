# 08. Authentication Module

The authentication module provides secure access control for the API server and UI. It supports JWT-based authentication with role-based access control (RBAC).

## 08.01 Features

- User registration and login
- JWT token generation and validation
- Role-based permissions
- Password hashing
- Token refresh mechanism
- Integration with React UI and Swagger UI

## 08.02 Database Schema

### User Table

| Column | Type | Description | Constraints |
|--------|------|-------------|-------------|
| id | INTEGER | Primary key | AUTO_INCREMENT, PRIMARY KEY |
| username | VARCHAR(100) | Unique username for login | NOT NULL, UNIQUE |
| email | VARCHAR(255) | User email address | NOT NULL, UNIQUE |
| password_hash | VARCHAR(255) | Hashed password | NOT NULL |
| role | VARCHAR(50) | User role | NOT NULL, DEFAULT 'user' |
| created_at | DATETIME | Creation timestamp | NOT NULL, DEFAULT CURRENT_TIMESTAMP |
| updated_at | DATETIME | Last update timestamp | NOT NULL, DEFAULT CURRENT_TIMESTAMP |

### Role Permissions

#### Admin Role
- Full access to all operations
- Can create, read, update, delete all resources
- Can manage users and roles
- Can access all cluster operations
- Can upload/download artifacts
- Can schedule health checks
- Can view all monitoring data

#### Operator Role
- Can manage jobs and workers (CRUD operations)
- Can execute and reconcile jobs
- Can upload/download artifacts for jobs
- Can view cluster status and resources
- Can schedule health checks
- Cannot manage users or system configuration

#### User Role
- Read-only access to view status
- Can view job status and execution logs
- Can view cluster health and basic metrics
- Can view worker information
- Cannot create, update, or delete any resources
- Cannot upload artifacts or execute jobs
- Cannot access user management or configuration

## 08.03 API Endpoints

### POST /auth/register
Register a new user (admin only or self-registration if enabled).

**Request Body:**
```json
{
  "username": "johndoe",
  "email": "user@example.com",
  "password": "securepassword",
  "role": "operator"
}
```

### POST /auth/login
Authenticate user and return JWT token.

**Request Body:**
```json
{
  "username": "johndoe",
  "password": "securepassword"
}
```

**Response:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "username": "johndoe",
    "email": "user@example.com",
    "role": "operator"
  }
}
```

### POST /auth/refresh
Refresh access token using refresh token.

### GET /auth/me
Get current user information.


### POST /auth/change-password
Change the authenticated user's password. Requires the current password and the new password.

**Request Body:**
```json
{
    "old_password": "currentPass",
    "new_password": "newSecurePassword123"
}
```

**Response:**
```json
{ "status": "ok", "message": "Password changed" }
```


### PATCH /auth/users/{user_id}/role
Admin-only endpoint to update another user's role.

**Request Body:**
```json
{ "role": "operator" }
```

**Response:**
```json
{ "id": 2, "username": "alice", "role": "operator" }
```

## 08.04 Implementation Details

### JWT Configuration
- Algorithm: HS256
- Access token expiry: 1 hour
- Refresh token expiry: 7 days
- Secret key: Environment variable

### Password Security
- bcrypt hashing with salt
- Minimum password requirements
- Password reset functionality (future)

### Middleware
FastAPI dependency injection for authentication:

```python
from fastapi import Depends, HTTPException
from fastapi.security import HTTPBearer, HTTPAuthorizationCredentials

security = HTTPBearer()

def get_current_user(credentials: HTTPAuthorizationCredentials = Depends(security)):
    token = credentials.credentials
    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=["HS256"])
        user_id = payload.get("sub")
        # Fetch user from database
        return user
    except:
        raise HTTPException(status_code=401, detail="Invalid token")

def require_role(required_role: str):
    def role_checker(current_user: User = Depends(get_current_user)):
        role_hierarchy = {
            "admin": 3,    # Full access
            "operator": 2, # Can manage resources
            "user": 1      # Read-only
        }
        
        user_level = role_hierarchy.get(current_user.role, 0)
        required_level = role_hierarchy.get(required_role, 999)
        
        if user_level < required_level:
            raise HTTPException(status_code=403, detail="Insufficient permissions")
        return current_user
    return role_checker

def require_admin(current_user: User = Depends(get_current_user)):
    if current_user.role != "admin":
        raise HTTPException(status_code=403, detail="Admin access required")
    return current_user
```

### Usage in Endpoints

```python
# Worker Management - Admin and Operator can manage, User can view
@app.get("/core/worker")
def get_workers(current_user: User = Depends(get_current_user)):
    # All authenticated users can view workers
    return get_all_workers()

@app.post("/core/worker")
def create_worker(worker_data: dict, current_user: User = Depends(require_role("operator"))):
    # Only operators and admins can create workers
    return create_new_worker(worker_data)

@app.patch("/core/worker/{id}")
def update_worker(worker_id: int, worker_data: dict, current_user: User = Depends(require_role("operator"))):
    # Only operators and admins can update workers
    return update_worker_data(worker_id, worker_data)

@app.delete("/core/worker/{id}")
def delete_worker(worker_id: int, current_user: User = Depends(require_role("operator"))):
    # Only operators and admins can delete workers
    return delete_worker_by_id(worker_id)

# Job Management - Admin and Operator can manage, User can view status
@app.get("/core/job")
def get_jobs(current_user: User = Depends(get_current_user)):
    # All authenticated users can view jobs
    return get_all_jobs()

@app.post("/core/job")
def create_job(job_data: dict, current_user: User = Depends(require_role("operator"))):
    # Only operators and admins can create jobs
    return create_new_job(job_data)

@app.post("/core/job/{id}/execute")
def execute_job(job_id: int, current_user: User = Depends(require_role("operator"))):
    # Only operators and admins can execute jobs
    return execute_job_by_id(job_id)

# User Management - Admin only
@app.get("/users")
def get_users(current_user: User = Depends(require_admin)):
    # Only admins can view all users
    return get_all_users()

@app.post("/users")
def create_user(user_data: dict, current_user: User = Depends(require_admin)):
    # Only admins can create users
    return create_new_user(user_data)

# Health Checks - Admin and Operator can configure, User can view
@app.get("/cluster/health/{job_id}/status")
def get_health_status(job_id: int, current_user: User = Depends(get_current_user)):
    # All authenticated users can view health status
    return get_job_health_status(job_id)

@app.post("/cluster/health/schedule")
def schedule_health_check(check_data: dict, current_user: User = Depends(require_role("operator"))):
    # Only operators and admins can schedule health checks
    return schedule_new_health_check(check_data)
```

## 08.05 Security Best Practices

- HTTPS only in production
- Secure cookie settings for refresh tokens
- Rate limiting on auth endpoints
- Audit logging for sensitive operations
- Password complexity requirements
- Account lockout after failed attempts

## 08.06 Integration with UI

The React UI handles:
- Login form submission
- Token storage in localStorage/httpOnly cookies
- Automatic token refresh
- Redirect to login on 401 responses
- Role-based UI element visibility

## 08.07 Swagger UI Integration

Swagger UI automatically includes authentication:
- Bearer token input field
- Try-it-out functionality with auth
- API documentation with auth requirements
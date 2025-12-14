# 09. Additional APIs

This document covers additional API endpoints for user management, health checks, monitoring, and other supporting functionalities.

## 09.01 User Management APIs

### GET /users

Get list of all users.

**Authorization:** Admin role only

**Response:**

```json
{
  "users": [
    {
      "id": 1,
      "username": "admin",
      "email": "admin@example.com",
      "role": "admin",
      "created_at": "2023-01-01T00:00:00Z"
    }
  ]
}
```

### POST /users

Create a new user.

**Authorization:** Admin role only

**Request Body:**

```json
{
  "username": "johndoe",
  "email": "john.doe@example.com",
  "password": "securepassword",
  "role": "operator"
}
```

### PATCH /users/

Update user information.

**Authorization:** Admin role only (users cannot modify their own roles)

### DELETE /users/

Delete a user.

**Authorization:** Admin role only

### POST /users/change-password

Change user password.

**Authorization:** Admin role or the user themselves

## 09.02 File Management

### File Storage

- Uploaded artifacts are stored on the server's filesystem in a dedicated uploads directory
- Files are organized by job ID: `/uploads/job_{id}/filename`
- File paths are stored in the database for reference
- Files are served via the `/files/` endpoint for downloads

### File Security

- Files are accessible only to authenticated users
- Download URLs include job ID for access control
- Files are cleaned up when jobs are deleted (optional)
- Maximum file size limits apply (configurable)

### Supported File Types

- YAML files (.yaml, .yml) for Kubernetes manifests and Helm values
- JSON files for configuration
- Text files for scripts and templates
- Other artifact types as needed

## 09.03 Health Check APIs

### GET /health

Basic health check endpoint.

**Response:**

```json
{
  "status": "healthy",
  "timestamp": "2023-01-01T00:00:00Z",
  "version": "1.0.0"
}
```

### GET /health/detailed

Detailed health check including database and Kubernetes connectivity.

**Response:**

```json
{
  "status": "healthy",
  "checks": {
    "database": "ok",
    "kubernetes_api": "ok",
    "workers": "5 active",
    "jobs": "12 total, 3 running"
  }
}
```

### GET /health/cluster

Kubernetes cluster health check.

**Response:**

```json
{
  "status": "healthy",
  "nodes": {
    "total": 3,
    "ready": 3
  },
  "pods": {
    "total": 45,
    "running": 42,
    "pending": 2,
    "failed": 1
  }
}
```

## 09.04 Monitoring APIs

### GET /metrics

Prometheus-compatible metrics endpoint.

**Response:**

```
# HELP kubeops_workers_total Total number of workers
# TYPE kubeops_workers_total gauge
kubeops_workers_total 5

# HELP kubeops_jobs_total Total number of jobs
# TYPE kubeops_jobs_total gauge
kubeops_jobs_total 12

# HELP kubeops_jobs_status Jobs by status
# TYPE kubeops_jobs_status gauge
kubeops_jobs_status{status="pending"} 3
kubeops_jobs_status{status="running"} 2
kubeops_jobs_status{status="completed"} 7
```

### GET /logs

Retrieve application logs.

**Query Parameters:**

- `level`: Log level (debug, info, warning, error)
- `since`: ISO timestamp
- `limit`: Maximum number of entries

### GET /audit

Audit log of user actions.

**Response:**

```json
{
  "entries": [
    {
      "timestamp": "2023-01-01T00:00:00Z",
      "user": "admin@example.com",
      "action": "CREATE_WORKER",
      "resource": "worker:helm-redis",
      "ip": "192.168.1.100"
    }
  ]
}
```

## 09.05 Configuration APIs

### GET /config

Get current application configuration.

**Authorization:** Admin role only

### PATCH /config

Update application configuration.

**Authorization:** Admin role only

**Supported settings:**

- Database connection
- Kubernetes config
- Authentication settings
- Logging levels

## 09.06 Notification APIs

### GET /notifications

Get user notifications.

### POST /notifications//read

Mark notification as read.

### Webhook endpoints for external integrations (future enhancement)

## 09.07 Backup and Restore APIs

### POST /backup

Create database backup.

**Authorization:** Admin role only

### GET /backup

List available backups.

**Authorization:** Admin role only

### POST /backup//restore

Restore from backup.

**Authorization:** Admin role only

## 09.08 API Versioning and Deprecation

- All endpoints are versioned under `/api/v1/`
- Deprecated endpoints include deprecation headers
- Breaking changes require new version

## 09.09 Rate Limiting

- Authentication endpoints: 5 requests per minute per IP
- General APIs: 100 requests per minute per user
- Admin APIs: 50 requests per minute per user

## 09.10 Error Responses

Standard error format:

```json
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Invalid input data",
    "details": {
      "field": "name",
      "reason": "required"
    }
  }
}
```

Common error codes:

- `VALIDATION_ERROR`: Input validation failed
- `AUTHENTICATION_ERROR`: Invalid credentials
- `AUTHORIZATION_ERROR`: Insufficient permissions
- `NOT_FOUND`: Resource not found
- `CONFLICT`: Resource conflict
- `INTERNAL_ERROR`: Server error

## 09.11 API Documentation

- Interactive Swagger UI at `/docs`
- OpenAPI 3.0 specification at `/openapi.json`
- Client SDK generation support

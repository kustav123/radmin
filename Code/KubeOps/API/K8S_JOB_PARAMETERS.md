# Kubernetes Job Parameters - API Documentation

## Overview
The Job API now supports all major Kubernetes Job and Pod template parameters, allowing full control over job execution in a Kubernetes cluster.

## Job Creation Endpoint

**POST** `/api/v1/core/job/`

### Required Parameters
- `name` (string): Job name
- `namespace` (string): Kubernetes namespace
- `worker_id` (integer): Worker/controller ID
- `arguments` (object): Worker-specific configuration

### Optional Kubernetes Job Spec Parameters

#### Job Completion & Parallelism
- `completions` (integer): Number of successful pod completions required
  - Default: null (run once)
  - Example: `5` (job completes after 5 successful pods)

- `parallelism` (integer): Maximum number of pods running simultaneously
  - Default: null (run 1 pod at a time)
  - Example: `3` (run up to 3 pods in parallel)

#### Job Failure Handling
- `backoff_limit` (integer): Number of retries before marking job as failed
  - Default: `6`
  - Example: `3` (retry up to 3 times)

- `active_deadline_seconds` (integer): Job timeout in seconds
  - Default: null (no timeout)
  - Example: `3600` (1 hour timeout)

#### Job Cleanup
- `ttl_seconds_after_finished` (integer): Seconds to keep completed/failed job before cleanup
  - Default: null (keep forever)
  - Example: `100` (delete 100 seconds after completion)

### Pod Template Parameters

#### Container Configuration
- `image` (string): Container image
  - Example: `"python:3.11-slim"`, `"nginx:latest"`, `"postgres:14"`

- `command` (array of strings): Container entrypoint
  - Example: `["/bin/bash", "-c"]`

- `args` (array of strings): Container arguments
  - Example: `["python app.py --mode production"]`

- `restart_policy` (string): Pod restart policy
  - Values: `"Never"` or `"OnFailure"`
  - Default: `"Never"`

#### Environment Variables
- `env_vars` (object): Environment variable key-value pairs
  ```json
  {
    "DATABASE_URL": "postgresql://localhost:5432/mydb",
    "API_KEY": "secret-key-123",
    "LOG_LEVEL": "INFO"
  }
  ```

#### Resource Limits
- `resources` (object): CPU and memory requests/limits
  ```json
  {
    "requests": {
      "cpu": "500m",
      "memory": "1Gi"
    },
    "limits": {
      "cpu": "2000m",
      "memory": "4Gi"
    }
  }
  ```

#### Storage & Volumes
- `volumes` (array of objects): Volume definitions
  ```json
  [
    {
      "name": "data-volume",
      "persistentVolumeClaim": {
        "claimName": "data-pvc"
      }
    },
    {
      "name": "config-volume",
      "configMap": {
        "name": "app-config"
      }
    }
  ]
  ```

- `volume_mounts` (array of objects): Volume mount points
  ```json
  [
    {
      "name": "data-volume",
      "mountPath": "/data"
    },
    {
      "name": "config-volume",
      "mountPath": "/config",
      "readOnly": true
    }
  ]
  ```

#### Image Pull Configuration
- `image_pull_secrets` (array of strings): Secret names for pulling private images
  - Example: `["docker-registry-secret", "gcr-secret"]`

- `service_account_id` (integer): Service account ID for pod authentication
  - Links to ServiceAccount table
  - Default: null

### Metadata

#### Labels
- `labels` (object): Kubernetes labels for organization and selection
  ```json
  {
    "app": "data-processor",
    "env": "production",
    "team": "data-engineering",
    "version": "2.0"
  }
  ```

#### Annotations
- `annotations` (object): Metadata for tools and documentation
  ```json
  {
    "description": "Data processing batch job",
    "owner": "data-team@company.com",
    "runbook": "https://wiki.company.com/runbook"
  }
  ```

## Complete Example

```json
{
  "name": "data-processing-job",
  "namespace": "production",
  "worker_id": 1,
  "service_account_id": 1,
  
  "completions": 5,
  "parallelism": 2,
  "backoff_limit": 3,
  "active_deadline_seconds": 3600,
  "ttl_seconds_after_finished": 100,
  
  "restart_policy": "OnFailure",
  "image": "python:3.11-slim",
  "command": ["/bin/bash", "-c"],
  "args": ["python process_data.py --input /data/input"],
  
  "env_vars": {
    "DATABASE_URL": "postgresql://localhost:5432/mydb",
    "LOG_LEVEL": "INFO"
  },
  
  "resources": {
    "requests": {
      "cpu": "500m",
      "memory": "1Gi"
    },
    "limits": {
      "cpu": "2000m",
      "memory": "4Gi"
    }
  },
  
  "volumes": [
    {
      "name": "data-volume",
      "persistentVolumeClaim": {
        "claimName": "data-pvc"
      }
    }
  ],
  
  "volume_mounts": [
    {
      "name": "data-volume",
      "mountPath": "/data"
    }
  ],
  
  "image_pull_secrets": ["docker-registry-secret"],
  
  "labels": {
    "app": "data-processor",
    "env": "production"
  },
  
  "annotations": {
    "description": "Data processing batch job"
  },
  
  "arguments": {
    "batch_size": 1000
  }
}
```

## Database Schema

All parameters are stored in the `job` table:

| Column | Type | Description |
|--------|------|-------------|
| `completions` | INTEGER | Number of successful completions needed |
| `parallelism` | INTEGER | Number of parallel pods |
| `backoff_limit` | INTEGER | Retry limit (default: 6) |
| `active_deadline_seconds` | INTEGER | Job timeout |
| `ttl_seconds_after_finished` | INTEGER | Cleanup timer |
| `restart_policy` | VARCHAR(50) | Pod restart policy (default: "Never") |
| `image` | VARCHAR(500) | Container image |
| `command` | JSON | Container command array |
| `args` | JSON | Container args array |
| `env_vars` | JSON | Environment variables object |
| `resources` | JSON | Resource requests/limits object |
| `volumes` | JSON | Volumes array |
| `volume_mounts` | JSON | Volume mounts array |
| `image_pull_secrets` | JSON | Image pull secrets array |
| `labels` | JSON | Kubernetes labels object |
| `annotations` | JSON | Kubernetes annotations object |

## Migration History

- **0005_add_k8s_job_params**: Adds all Kubernetes job parameters to job table

## Testing

Run the test script to verify all parameters:
```bash
python test_k8s_job_params.py
```

## Backward Compatibility

All new parameters are optional. Existing job creation code will continue to work:

```json
{
  "name": "simple-job",
  "namespace": "default",
  "worker_id": 1,
  "arguments": {"key": "value"}
}
```

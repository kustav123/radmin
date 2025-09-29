# Agent API Specification (FastAPI)

The Agent API provides high-performance endpoints for agent communication. Built with FastAPI, it handles agent registration, heartbeats, job distribution, and system information collection with minimal latency.

## Base Configuration

### API Base URL
- **Agent API**: `https://api.rmas.com/agent/`

### Authentication
- **Type**: Bearer Token (JWT)
- **Headers**: `Authorization: Bearer {agent_token}`
- **Device Registration**: Uses registration token from device creation

### Response Format
```json
{
    "success": true,
    "data": {
        // Response data
    },
    "message": "Operation completed successfully",
    "timestamp": "2025-01-16T12:00:00Z"
}
```

### Error Response Format
```json
{
    "success": false,
    "error": {
        "code": "INVALID_TOKEN",
        "message": "The provided token is invalid or expired",
        "details": {}
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

## Agent Lifecycle Endpoints

### Agent Registration

#### POST /agent/register
Register a new agent with the system using device registration token.

**Request Headers:**
```
Authorization: Bearer {registration_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "agent_version": "1.2.3",
    "platform": "windows",
    "architecture": "x64",
    "hostname": "DEV-LAPTOP-001",
    "system_info": {
        "os": {
            "name": "Windows 11",
            "version": "22H2",
            "build": "22621.1702"
        },
        "hardware": {
            "cpu": "Intel(R) Core(TM) i7-10700 CPU @ 2.90GHz",
            "memory_gb": 16,
            "disk_gb": 512
        },
        "network": {
            "mac_address": "00:1B:44:11:3A:B7",
            "ip_address": "192.168.1.100",
            "hostname": "DEV-LAPTOP-001"
        }
    }
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "agent_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "device_id": "550e8400-e29b-41d4-a716-446655440030",
        "organization_id": "550e8400-e29b-41d4-a716-446655440001",
        "configuration": {
            "heartbeat_interval": 60,
            "system_info_interval": 3600,
            "job_check_interval": 30,
            "max_concurrent_jobs": 3,
            "log_level": "INFO",
            "server_endpoints": {
                "heartbeat": "/agent/heartbeat",
                "jobs": "/agent/jobs",
                "system_info": "/agent/system-info",
                "file_upload": "/agent/files/upload"
            }
        },
        "device_info": {
            "name": "DEV-LAPTOP-001",
            "group": "Developer Laptops",
            "type": "Windows Desktop"
        }
    },
    "message": "Agent registered successfully",
    "timestamp": "2025-01-16T12:00:00Z"
}
```

**Error Responses:**
- `401` - Invalid or expired registration token
- `409` - Device already registered
- `422` - Invalid system information

### Agent Configuration

#### GET /agent/config
Get current agent configuration and settings.

**Request Headers:**
```
Authorization: Bearer {agent_token}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "configuration": {
            "heartbeat_interval": 60,
            "system_info_interval": 3600,
            "job_check_interval": 30,
            "max_concurrent_jobs": 3,
            "log_level": "INFO",
            "retry_settings": {
                "max_retries": 3,
                "retry_delay": 30,
                "backoff_multiplier": 2
            }
        },
        "capabilities": [
            "file_transfer",
            "remote_execution",
            "system_monitoring",
            "log_collection"
        ],
        "last_updated": "2025-01-16T11:00:00Z"
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

## Heartbeat and Monitoring

### Heartbeat

#### POST /agent/heartbeat
Send periodic heartbeat with current status and metrics.

**Request Headers:**
```
Authorization: Bearer {agent_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "status": "online",
    "metrics": {
        "cpu": {
            "usage_percent": 25.5,
            "load_average": [1.2, 1.5, 1.8],
            "process_count": 156
        },
        "memory": {
            "total_bytes": 17179869184,
            "used_bytes": 8858370048,
            "usage_percent": 51.5,
            "available_bytes": 8321499136
        },
        "disk": {
            "drives": [
                {
                    "path": "C:",
                    "total_bytes": 536870912000,
                    "used_bytes": 268435456000,
                    "usage_percent": 50.0,
                    "free_bytes": 268435456000
                }
            ]
        },
        "network": {
            "interfaces": [
                {
                    "name": "Ethernet",
                    "bytes_sent": 1048576000,
                    "bytes_received": 2097152000,
                    "packets_sent": 1000000,
                    "packets_received": 1500000,
                    "errors": 0
                }
            ]
        }
    },
    "running_jobs": [
        {
            "execution_id": "550e8400-e29b-41d4-a716-446655440050",
            "status": "running",
            "progress": 75,
            "started_at": "2025-01-16T11:30:00Z"
        }
    ],
    "agent_info": {
        "version": "1.2.3",
        "uptime_seconds": 86400,
        "last_restart": "2025-01-15T12:00:00Z"
    }
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "status": "acknowledged",
        "pending_jobs": [
            {
                "execution_id": "550e8400-e29b-41d4-a716-446655440051",
                "template_id": "550e8400-e29b-41d4-a716-446655440040",
                "priority": "normal",
                "scheduled_at": "2025-01-16T12:15:00Z"
            }
        ],
        "configuration_update": null,
        "next_heartbeat": "2025-01-16T12:01:00Z",
        "server_time": "2025-01-16T12:00:00Z"
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

### System Information

#### POST /agent/system-info
Send detailed system information (less frequent than heartbeat).

**Request Headers:**
```
Authorization: Bearer {agent_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "collected_at": "2025-01-16T12:00:00Z",
    "system_data": {
        "operating_system": {
            "name": "Windows 11 Pro",
            "version": "22H2",
            "build": "22621.1702",
            "architecture": "x64",
            "install_date": "2024-06-15T00:00:00Z",
            "last_boot": "2025-01-15T12:00:00Z"
        },
        "hardware": {
            "cpu": {
                "name": "Intel(R) Core(TM) i7-10700 CPU @ 2.90GHz",
                "manufacturer": "Intel",
                "architecture": "x64",
                "cores": 8,
                "threads": 16,
                "base_speed_ghz": 2.9,
                "max_speed_ghz": 4.8
            },
            "memory": {
                "total_bytes": 17179869184,
                "type": "DDR4",
                "speed_mhz": 3200,
                "modules": [
                    {
                        "size_gb": 8,
                        "manufacturer": "Samsung",
                        "part_number": "M378A1K43CB2-CTD"
                    },
                    {
                        "size_gb": 8,
                        "manufacturer": "Samsung",
                        "part_number": "M378A1K43CB2-CTD"
                    }
                ]
            },
            "storage": [
                {
                    "device": "C:",
                    "type": "SSD",
                    "interface": "NVMe",
                    "size_bytes": 536870912000,
                    "model": "Samsung SSD 980",
                    "serial": "S649NX0R123456",
                    "health": "Good"
                }
            ],
            "motherboard": {
                "manufacturer": "Dell Inc.",
                "model": "0KWVT8",
                "serial": "MB123456789"
            }
        },
        "network": {
            "hostname": "DEV-LAPTOP-001",
            "domain": "company.local",
            "workgroup": "WORKGROUP",
            "interfaces": [
                {
                    "name": "Ethernet",
                    "description": "Intel(R) Ethernet Connection",
                    "mac_address": "00:1B:44:11:3A:B7",
                    "ip_addresses": ["192.168.1.100"],
                    "subnet_mask": "255.255.255.0",
                    "gateway": "192.168.1.1",
                    "dns_servers": ["8.8.8.8", "8.8.4.4"],
                    "speed_mbps": 1000,
                    "status": "Up"
                }
            ]
        },
        "software": {
            "installed_programs": [
                {
                    "name": "Microsoft Office Professional Plus 2021",
                    "version": "16.0.15629.20156",
                    "publisher": "Microsoft Corporation",
                    "install_date": "2024-07-01T00:00:00Z",
                    "install_size_bytes": 4294967296
                }
            ],
            "windows_features": [
                {
                    "name": "IIS-WebServerRole",
                    "display_name": "Web Server (IIS)",
                    "state": "Enabled"
                }
            ],
            "running_services": [
                {
                    "name": "wuauserv",
                    "display_name": "Windows Update",
                    "status": "Running",
                    "startup_type": "Automatic (Delayed Start)",
                    "process_id": 1234
                }
            ],
            "startup_programs": [
                {
                    "name": "Microsoft Teams",
                    "command": "C:\\Users\\user\\AppData\\Local\\Microsoft\\Teams\\Update.exe --processStart Teams.exe",
                    "enabled": true
                }
            ]
        },
        "security": {
            "antivirus": {
                "product": "Windows Defender",
                "version": "4.18.2211.5",
                "status": "Enabled",
                "last_scan": "2025-01-16T02:00:00Z"
            },
            "firewall": {
                "domain_profile": "Enabled",
                "private_profile": "Enabled",
                "public_profile": "Enabled"
            },
            "windows_updates": {
                "last_check": "2025-01-15T18:00:00Z",
                "last_install": "2025-01-14T03:00:00Z",
                "pending_updates": 3,
                "reboot_required": false
            }
        }
    }
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "status": "received",
        "info_id": "550e8400-e29b-41d4-a716-446655440052",
        "next_collection": "2025-01-16T16:00:00Z"
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

## Job Management

### Get Pending Jobs

#### GET /agent/jobs/pending
Get list of pending jobs for the agent.

**Request Headers:**
```
Authorization: Bearer {agent_token}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "jobs": [
            {
                "execution_id": "550e8400-e29b-41d4-a716-446655440051",
                "template_id": "550e8400-e29b-41d4-a716-446655440040",
                "name": "System Cleanup",
                "priority": "normal",
                "timeout_seconds": 3600,
                "created_at": "2025-01-16T11:45:00Z",
                "scheduled_at": "2025-01-16T12:15:00Z"
            }
        ],
        "total_pending": 1
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

### Get Job Details

#### GET /agent/jobs/{execution_id}
Get detailed job template and parameters for execution.

**Request Headers:**
```
Authorization: Bearer {agent_token}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "execution_id": "550e8400-e29b-41d4-a716-446655440051",
        "template": {
            "id": "550e8400-e29b-41d4-a716-446655440040",
            "name": "System Cleanup",
            "description": "Clean temporary files and perform system maintenance",
            "type": "maintenance",
            "steps": [
                {
                    "id": 1,
                    "name": "Check disk space",
                    "type": "command",
                    "command": "Get-WmiObject -Class Win32_LogicalDisk | Select-Object Size,FreeSpace,DeviceID",
                    "shell": "powershell",
                    "timeout": 30,
                    "continue_on_error": false,
                    "expected_exit_codes": [0]
                },
                {
                    "id": 2,
                    "name": "Clean temporary files",
                    "type": "script",
                    "script_content": "Remove-Item -Path $env:TEMP\\* -Recurse -Force -ErrorAction SilentlyContinue",
                    "shell": "powershell",
                    "timeout": 300,
                    "continue_on_error": true
                },
                {
                    "id": 3,
                    "name": "Clear browser cache",
                    "type": "command",
                    "command": "RunDll32.exe InetCpl.cpl,ClearMyTracksByProcess 8",
                    "timeout": 120,
                    "continue_on_error": true
                }
            ],
            "requirements": {
                "min_agent_version": "1.0.0",
                "supported_platforms": ["windows"],
                "required_permissions": ["admin"],
                "min_free_space_mb": 100
            }
        },
        "parameters": {
            "cleanup_level": "standard",
            "preserve_downloads": true,
            "clear_recycle_bin": false
        },
        "timeout_seconds": 3600,
        "priority": "normal",
        "retry_config": {
            "max_retries": 2,
            "retry_delay": 300
        }
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

### Update Job Status

#### POST /agent/jobs/{execution_id}/status
Update job execution status and progress.

**Request Headers:**
```
Authorization: Bearer {agent_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "status": "running", // pending, running, completed, failed, cancelled
    "progress": 50,
    "current_step": 2,
    "step_results": [
        {
            "step_id": 1,
            "status": "completed",
            "exit_code": 0,
            "output": "C:    536870912000  268435456000  C:\n",
            "error": null,
            "started_at": "2025-01-16T12:15:00Z",
            "completed_at": "2025-01-16T12:15:15Z",
            "duration_seconds": 15
        }
    ],
    "logs": [
        {
            "timestamp": "2025-01-16T12:15:00Z",
            "level": "INFO",
            "message": "Starting disk space check"
        },
        {
            "timestamp": "2025-01-16T12:15:15Z",
            "level": "INFO",
            "message": "Disk space check completed successfully"
        }
    ]
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "status": "acknowledged",
        "continue": true
    },
    "timestamp": "2025-01-16T12:16:00Z"
}
```

### Complete Job

#### POST /agent/jobs/{execution_id}/complete
Mark job as completed with final results.

**Request Headers:**
```
Authorization: Bearer {agent_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "status": "completed", // completed, failed
    "results": {
        "summary": {
            "total_steps": 3,
            "completed_steps": 3,
            "failed_steps": 0,
            "duration_seconds": 450,
            "files_cleaned": 1247,
            "space_freed_mb": 2048
        },
        "step_results": [
            {
                "step_id": 1,
                "status": "completed",
                "exit_code": 0,
                "output": "C:    536870912000  268435456000  C:\n",
                "duration_seconds": 15
            },
            {
                "step_id": 2,
                "status": "completed",
                "exit_code": 0,
                "output": "Cleaned 1247 temporary files, freed 2048 MB",
                "duration_seconds": 420
            },
            {
                "step_id": 3,
                "status": "completed",
                "exit_code": 0,
                "output": "Browser cache cleared successfully",
                "duration_seconds": 15
            }
        ]
    },
    "logs": [
        {
            "timestamp": "2025-01-16T12:22:30Z",
            "level": "INFO",
            "message": "All cleanup tasks completed successfully"
        }
    ],
    "completed_at": "2025-01-16T12:22:30Z"
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "status": "acknowledged"
    },
    "timestamp": "2025-01-16T12:22:35Z"
}
```

## File Operations

### Upload File

#### POST /agent/files/upload
Upload file to server (logs, reports, etc.).

**Request Headers:**
```
Authorization: Bearer {agent_token}
Content-Type: multipart/form-data
```

**Request Body (multipart/form-data):**
```
file: [binary file data]
metadata: {
    "type": "log",
    "description": "Agent log file",
    "job_execution_id": "550e8400-e29b-41d4-a716-446655440051"
}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "file_id": "550e8400-e29b-41d4-a716-446655440060",
        "filename": "agent.log",
        "size_bytes": 1048576,
        "type": "log",
        "uploaded_at": "2025-01-16T12:30:00Z"
    },
    "timestamp": "2025-01-16T12:30:00Z"
}
```

### Download File

#### GET /agent/files/{file_id}
Download file from server (scripts, updates, etc.).

**Request Headers:**
```
Authorization: Bearer {agent_token}
```

**Response (200):**
```
Content-Type: application/octet-stream
Content-Disposition: attachment; filename="script.ps1"
Content-Length: 2048

[binary file data]
```

## Error Codes and Handling

### Common Error Codes

| Code | HTTP Status | Description |
|------|-------------|-------------|
| `INVALID_TOKEN` | 401 | Agent token is invalid or expired |
| `DEVICE_NOT_FOUND` | 404 | Device not found in system |
| `ORGANIZATION_INACTIVE` | 403 | Organization is inactive |
| `AGENT_VERSION_UNSUPPORTED` | 426 | Agent version not supported |
| `JOB_NOT_FOUND` | 404 | Job execution not found |
| `JOB_ALREADY_COMPLETED` | 409 | Job already completed |
| `INVALID_JOB_STATUS` | 422 | Invalid job status transition |
| `FILE_TOO_LARGE` | 413 | Uploaded file exceeds size limit |
| `RATE_LIMIT_EXCEEDED` | 429 | Too many requests |
| `MAINTENANCE_MODE` | 503 | Server in maintenance mode |

### Error Response Examples

#### Token Validation Error
```json
{
    "success": false,
    "error": {
        "code": "INVALID_TOKEN",
        "message": "The provided token is invalid or expired",
        "details": {
            "token_expired": true,
            "expires_at": "2025-01-15T12:00:00Z"
        }
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

#### Job Status Error
```json
{
    "success": false,
    "error": {
        "code": "INVALID_JOB_STATUS",
        "message": "Cannot transition from 'completed' to 'running'",
        "details": {
            "current_status": "completed",
            "requested_status": "running",
            "valid_transitions": ["pending", "running", "completed", "failed", "cancelled"]
        }
    },
    "timestamp": "2025-01-16T12:00:00Z"
}
```

## Rate Limiting

- **Registration**: 5 attempts per hour per device
- **Heartbeat**: 1 request per 30 seconds per device
- **Job operations**: 10 requests per minute per device
- **File upload**: 5 uploads per minute per device (max 10MB each)
- **System info**: 1 request per hour per device

## Security Features

### Token Management
- **Agent Token Rotation**: Automatic token refresh every 24 hours
- **Token Scope**: Tokens are scoped to specific device and organization
- **Token Validation**: Real-time validation with device status check

### Request Validation
- **Signature Verification**: Optional request signing for sensitive operations
- **Timestamp Validation**: Reject requests older than 5 minutes
- **IP Validation**: Optional IP whitelist per organization

### Audit Logging
All agent API requests are logged with:
- Device ID and organization ID
- Request endpoint and method
- Response status and timing
- Error details if applicable

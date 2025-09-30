# Admin API Specification (Laravel)

The Admin API provides RESTful endpoints for the manager and organization web interfaces. Built with Laravel, it handles authentication, authorization, and all administrative operations.

## Base Configuration

### API Base URLs
- **Manager API**: `https://api.rmas.com/manager/`
- **Organization API**: `https://api.rmas.com/org/{org_slug}/`

### Authentication
- **Type**: Laravel Sanctum (Token-based)
- **Headers**: `Authorization: Bearer {token}`
- **Session**: Cookie-based for web interface

### Response Format
```json
{
    "success": true,
## API Design Requirements

### Standard Response Format
- **Consistent Structure**: All API responses follow standardized JSON format
- **Status Indication**: Clear success/error indication with appropriate HTTP codes
- **Error Handling**: Comprehensive error messages with validation details
- **Pagination**: Standardized pagination for list endpoints
- **Meta Information**: Additional context data (totals, pages, etc.)

### Required Response Schema
```text
Standard API Response Format:
┌─────────────────────────────────────────────────────────────────┐
│ {                                                               │
│   "success": boolean,                                           │
│   "data": object | array,                                       │
│   "message": string,                                            │
│   "errors": object | null,                                      │
│   "meta": {                                                     │
│     "page": number,                                             │
│     "per_page": number,                                         │
│     "total": number,                                            │
│     "last_page": number                                         │
│   }                                                             │
│ }                                                               │
└─────────────────────────────────────────────────────────────────┘
```

## Manager API Requirements

### Authentication Requirements
- **Login/Logout**: Standard authentication flow with JWT tokens
- **Session Management**: Secure session handling with configurable expiration
- **Multi-Factor**: Support for MFA (future requirement)
- **Permission Checking**: Role-based access control integration

### Organization Management Requirements
- **CRUD Operations**: Complete organization lifecycle management
- **Multi-Tenant**: Organization isolation and data separation
- **Bulk Operations**: Efficient handling of multiple organizations
- **Status Management**: Active/inactive organization states

#### Required Organization Endpoints
```text
Organization Management API Requirements:
┌─────────────────────────────────────────────────────────────────┐
│ GET    /manager/organizations           → List all organizations │
│ POST   /manager/organizations           → Create new organization│
│ GET    /manager/organizations/{id}      → Get organization detail│
│ PUT    /manager/organizations/{id}      → Update organization    │
│ DELETE /manager/organizations/{id}      → Delete organization    │
│ POST   /manager/organizations/{id}/sync → Sync organization data │
└─────────────────────────────────────────────────────────────────┘
```

### Device Type Management Requirements
- **Global Templates**: System-wide device type definitions
- **Custom Fields**: Configurable fields per device type
- **Organization Sync**: Push device types to specific organizations
- **Version Control**: Track changes to device type templates
```json
{
    "name": "New Company Ltd",
    "slug": "new-company",
    "domain": "newcompany.com",
    "settings": {
        "agent": {
            "heartbeat_interval": 60,
            "system_info_interval": 3600
        },
        "notifications": {
            "email_enabled": true
        }
    },
    "admin_user": {
        "username": "admin",
        "email": "admin@newcompany.com",
        "first_name": "John",
        "last_name": "Doe",
        "password": "secure_password"
    }
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "organization": {
            "id": "550e8400-e29b-41d4-a716-446655440002",
            "name": "New Company Ltd",
            "slug": "new-company",
            "database_name": "rmas_org_new_company",
            "domain": "newcompany.com",
            "is_active": true,
            "created_at": "2025-01-16T10:00:00Z"
        },
        "admin_user": {
            "id": "550e8400-e29b-41d4-a716-446655440003",
            "username": "admin",
            "email": "admin@newcompany.com"
        },
        "database_status": "created",
        "initialization_status": "completed"
    },
    "message": "Organization created successfully"
}
```

#### GET /manager/organizations/{id}
Get organization details.

#### PUT /manager/organizations/{id}
Update organization.

#### DELETE /manager/organizations/{id}
Delete organization (soft delete).

### Device Type Management

#### GET /manager/device-types
List all device type templates.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": "550e8400-e29b-41d4-a716-446655440010",
            "name": "Windows Desktop",
            "slug": "windows-desktop",
            "configuration": {
                "platform": "windows",
                "architecture": ["x86", "x64"],
                "monitoring": {
                    "cpu": true,
                    "memory": true,
                    "disk": true
                }
            },
            "default_settings": {
                "heartbeat_interval": 60,
                "system_info_interval": 3600
            },
            "is_active": true,
            "organization_count": 12,
            "device_count": 450,
            "created_at": "2025-01-01T00:00:00Z"
        }
    ]
}
```

#### POST /manager/device-types
Create device type template.

#### PUT /manager/device-types/{id}
Update device type template.

#### POST /manager/device-types/{id}/sync
Sync device type to organizations.

**Request:**
```json
{
    "organizations": ["all"], // or specific org IDs
    "force_update": false,
    "update_existing": true
}
```

### Manager User Management

#### GET /manager/managers
List manager users.

#### POST /manager/managers
Create manager user.

#### PUT /manager/managers/{id}
Update manager user.

#### POST /manager/managers/{id}/permissions
Update manager permissions.

### System Analytics

#### GET /manager/analytics/overview
System overview analytics.

**Response:**
```json
{
    "success": true,
    "data": {
        "organizations": {
            "total": 25,
            "active": 23,
            "inactive": 2
        },
        "devices": {
            "total": 2450,
            "online": 2380,
            "offline": 70
        },
        "jobs": {
            "executed_today": 145,
            "failed_today": 3,
            "success_rate": 97.9
        },
        "storage": {
            "total_databases": 25,
            "total_size_gb": 156.7,
            "average_size_gb": 6.3
        }
    }
}
```

#### GET /manager/analytics/organizations
Organization-specific analytics.

## Organization API Endpoints

### Authentication

#### POST /org/{org_slug}/auth/login
Login organization user.

#### POST /org/{org_slug}/auth/logout
Logout organization user.

#### GET /org/{org_slug}/auth/me
Get current user details.

### User Management

#### GET /org/{org_slug}/users
List organization users.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": "550e8400-e29b-41d4-a716-446655440020",
            "username": "jdoe",
            "email": "john.doe@acme.com",
            "first_name": "John",
            "last_name": "Doe",
            "role": "admin",
            "permissions": {...},
            "is_active": true,
            "last_login": "2025-01-16T09:30:00Z",
            "created_at": "2025-01-01T00:00:00Z"
        }
    ]
}
```

#### POST /org/{org_slug}/users
Create organization user.

#### PUT /org/{org_slug}/users/{id}
Update organization user.

#### DELETE /org/{org_slug}/users/{id}
Delete organization user.

### Device Management

#### GET /org/{org_slug}/devices
List devices with filtering and search.

**Query Parameters:**
- `page`, `per_page`, `search`, `sort`, `order`
- `group_id` (uuid): Filter by device group
- `type_id` (uuid): Filter by device type
- `status` (string): active, offline, error, maintenance
- `last_seen_after` (datetime): Devices seen after date
- `last_seen_before` (datetime): Devices seen before date

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": "550e8400-e29b-41d4-a716-446655440030",
            "name": "DEV-LAPTOP-001",
            "asset_code": "AC-001234",
            "serial_number": "SN123456789",
            "mac_address": "00:1B:44:11:3A:B7",
            "ip_address": "192.168.1.100",
            "device_group": {
                "id": "550e8400-e29b-41d4-a716-446655440031",
                "name": "Developer Laptops"
            },
            "device_type": {
                "id": "550e8400-e29b-41d4-a716-446655440032",
                "name": "Windows Laptop"
            },
            "status": "active",
            "last_seen": "2025-01-16T10:45:00Z",
            "properties": {
                "hardware": {
                    "manufacturer": "Dell",
                    "model": "Latitude 7420"
                },
                "location": {
                    "building": "Main Office",
                    "floor": "3"
                }
            },
            "agent_version": "1.2.3",
            "created_at": "2025-01-10T00:00:00Z"
        }
    ]
}
```

#### POST /org/{org_slug}/devices
Create new device.

**Request:**
```json
{
    "name": "NEW-LAPTOP-001",
    "asset_code": "AC-001235",
    "serial_number": "SN123456790",
    "mac_address": "00:1B:44:11:3A:B8",
    "device_group_id": "550e8400-e29b-41d4-a716-446655440031",
    "properties": {
        "hardware": {
            "manufacturer": "Dell",
            "model": "Latitude 7420"
        },
        "assignment": {
            "user": "jane.smith",
            "department": "Engineering"
        }
    }
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "device": {
            "id": "550e8400-e29b-41d4-a716-446655440033",
            "name": "NEW-LAPTOP-001",
            "status": "pending",
            "created_at": "2025-01-16T11:00:00Z"
        },
        "registration_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_expires_at": "2025-01-23T11:00:00Z"
    },
    "message": "Device created successfully. Use the registration token to setup the agent."
}
```

#### GET /org/{org_slug}/devices/{id}
Get device details including recent heartbeats and system info.

#### PUT /org/{org_slug}/devices/{id}
Update device details.

#### DELETE /org/{org_slug}/devices/{id}
Delete device.

#### POST /org/{org_slug}/devices/{id}/regenerate-token
Regenerate device registration token.

### Device Group Management

#### GET /org/{org_slug}/device-groups
List device groups.

#### POST /org/{org_slug}/device-groups
Create device group.

#### PUT /org/{org_slug}/device-groups/{id}
Update device group.

#### DELETE /org/{org_slug}/device-groups/{id}
Delete device group.

### Device Type Management

#### GET /org/{org_slug}/device-types
List organization device types.

#### PUT /org/{org_slug}/device-types/{id}
Update device type settings (customize from template).

#### POST /org/{org_slug}/device-types/{id}/enable
Enable device type.

#### POST /org/{org_slug}/device-types/{id}/disable
Disable device type.

### Job Template Management

#### GET /org/{org_slug}/job-templates
List job templates.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": "550e8400-e29b-41d4-a716-446655440040",
            "name": "System Cleanup",
            "description": "Clean temporary files and update system",
            "type": "maintenance",
            "template_data": {
                "steps": [
                    {
                        "id": 1,
                        "name": "Clean temp files",
                        "type": "command",
                        "command": "cleanmgr /sagerun:1"
                    }
                ]
            },
            "parameters": {
                "cleanup_level": "basic"
            },
            "is_active": true,
            "execution_count": 45,
            "success_rate": 97.8,
            "created_at": "2025-01-05T00:00:00Z"
        }
    ]
}
```

#### POST /org/{org_slug}/job-templates
Create job template.

#### PUT /org/{org_slug}/job-templates/{id}
Update job template.

#### DELETE /org/{org_slug}/job-templates/{id}
Delete job template.

#### POST /org/{org_slug}/job-templates/{id}/test
Test job template on specific device.

### Job Management

#### GET /org/{org_slug}/jobs
List job assignments and executions.

#### POST /org/{org_slug}/jobs/assign
Assign job template to device group.

**Request:**
```json
{
    "job_template_id": "550e8400-e29b-41d4-a716-446655440040",
    "device_group_id": "550e8400-e29b-41d4-a716-446655440031",
    "parameters": {
        "cleanup_level": "deep"
    },
    "schedule_type": "manual", // manual, immediate, scheduled, recurring
    "schedule_config": {
        // Schedule-specific configuration
    }
}
```

#### GET /org/{org_slug}/jobs/executions
List job executions with filtering.

#### GET /org/{org_slug}/jobs/executions/{id}
Get detailed job execution results.

#### POST /org/{org_slug}/jobs/executions/{id}/retry
Retry failed job execution.

#### DELETE /org/{org_slug}/jobs/executions/{id}
Cancel pending job execution.

### Monitoring and Analytics

#### GET /org/{org_slug}/dashboard
Organization dashboard data.

**Response:**
```json
{
    "success": true,
    "data": {
        "devices": {
            "total": 150,
            "online": 145,
            "offline": 5,
            "by_group": [
                {
                    "group_name": "Developer Laptops",
                    "total": 50,
                    "online": 48
                }
            ]
        },
        "jobs": {
            "executed_today": 25,
            "pending": 3,
            "failed_today": 1,
            "success_rate": 96.0
        },
        "alerts": [
            {
                "type": "device_offline",
                "message": "DEV-LAPTOP-005 has been offline for 2 hours",
                "created_at": "2025-01-16T08:30:00Z"
            }
        ],
        "recent_activity": [
            {
                "type": "device_registered",
                "message": "NEW-LAPTOP-001 registered successfully",
                "created_at": "2025-01-16T11:00:00Z"
            }
        ]
    }
}
```

#### GET /org/{org_slug}/reports/devices
Device reports and metrics.

#### GET /org/{org_slug}/reports/jobs
Job execution reports.

#### GET /org/{org_slug}/reports/system-info
Aggregated system information reports.

## Error Handling

### Standard Error Responses

#### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

#### Authentication Error (401)
```json
{
    "success": false,
    "message": "Unauthorized",
    "errors": {
        "auth": ["Invalid credentials"]
    }
}
```

#### Authorization Error (403)
```json
{
    "success": false,
    "message": "Forbidden",
    "errors": {
        "permission": ["Insufficient permissions for this action"]
    }
}
```

#### Not Found Error (404)
```json
{
    "success": false,
    "message": "Resource not found",
    "errors": {
        "resource": ["The requested resource was not found"]
    }
}
```

#### Server Error (500)
```json
{
    "success": false,
    "message": "Internal server error",
    "errors": {
        "server": ["An unexpected error occurred"]
    }
}
```

## Rate Limiting

- **Authentication endpoints**: 5 requests per minute per IP
- **General API endpoints**: 100 requests per minute per user
- **Bulk operations**: 10 requests per minute per user
- **File uploads**: 5 requests per minute per user

## Caching Strategy

- **Organization data**: Cache for 5 minutes
- **Device types**: Cache for 30 minutes
- **User permissions**: Cache for 15 minutes
- **Device status**: Cache for 1 minute
- **Job templates**: Cache for 10 minutes

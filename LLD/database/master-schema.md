# Master Database Schema

The master database contains global system data and organization metadata. This database is shared across the entire system and maintains organization information, global managers, and system-wide configurations.

## Database: `rmas_master`

### Tables Overview

```mermaid
erDiagram
    managers ||--o{ manager_organization_access : has
    organizations ||--o{ manager_organization_access : grants_access_to
    organizations ||--o{ organization_databases : has
    device_types ||--o{ organization_device_types : synced_to
    organizations ||--o{ organization_device_types : contains
    
    managers {
        uuid id PK
        string username UK
        string email UK
        string password_hash
        string first_name
        string last_name
        boolean is_super_admin
        json permissions
        timestamp email_verified_at
        timestamp created_at
        timestamp updated_at
    }
    
    organizations {
        uuid id PK
        string name
        string slug UK
        string database_name UK
        string domain
        json settings
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }
    
    manager_organization_access {
        uuid id PK
        uuid manager_id FK
        uuid organization_id FK
        json permissions
        timestamp created_at
        timestamp updated_at
    }
    
    device_types {
        uuid id PK
        string name UK
        string slug UK
        json configuration
        json default_settings
        string icon
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }
    
    organization_databases {
        uuid id PK
        uuid organization_id FK
        string database_name UK
        string connection_string
        string status
        timestamp last_backup
        timestamp created_at
        timestamp updated_at
    }
    
    organization_device_types {
        uuid id PK
        uuid organization_id FK
        uuid device_type_id FK
        boolean is_enabled
        json custom_settings
        timestamp last_synced
        timestamp created_at
        timestamp updated_at
    }
```

## Detailed Table Schemas

### 1. managers
Stores global system managers who can access and manage organizations.

```sql
CREATE TABLE managers (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    is_super_admin BOOLEAN DEFAULT FALSE,
    permissions JSONB DEFAULT '{}',
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes
CREATE INDEX idx_managers_email ON managers(email);
CREATE INDEX idx_managers_username ON managers(username);
CREATE INDEX idx_managers_is_super_admin ON managers(is_super_admin);
```

**Permissions Structure:**
```json
{
    "organizations": {
        "create": true,
        "read": true,
        "update": true,
        "delete": false
    },
    "device_types": {
        "create": true,
        "read": true,
        "update": true,
        "delete": true,
        "sync": true
    },
    "system": {
        "manage_managers": true,
        "system_settings": true,
        "view_analytics": true
    }
}
```

### 2. organizations
Stores organization metadata and configuration.

```sql
CREATE TABLE organizations (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    database_name VARCHAR(100) UNIQUE NOT NULL,
    domain VARCHAR(255) NULL,
    settings JSONB DEFAULT '{}',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes
CREATE INDEX idx_organizations_slug ON organizations(slug);
CREATE INDEX idx_organizations_database_name ON organizations(database_name);
CREATE INDEX idx_organizations_is_active ON organizations(is_active);
```

**Settings Structure:**
```json
{
    "agent": {
        "heartbeat_interval": 60,
        "system_info_interval": 3600,
        "token_expiry_days": 30
    },
    "notifications": {
        "email_enabled": true,
        "device_offline_threshold": 300,
        "job_failure_notifications": true
    },
    "security": {
        "require_2fa": false,
        "session_timeout": 3600,
        "max_failed_attempts": 5
    }
}
```

### 3. manager_organization_access
Defines which managers can access which organizations and their permissions.

```sql
CREATE TABLE manager_organization_access (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    manager_id UUID NOT NULL REFERENCES managers(id) ON DELETE CASCADE,
    organization_id UUID NOT NULL REFERENCES organizations(id) ON DELETE CASCADE,
    permissions JSONB DEFAULT '{}',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(manager_id, organization_id)
);

-- Indexes
CREATE INDEX idx_manager_org_access_manager_id ON manager_organization_access(manager_id);
CREATE INDEX idx_manager_org_access_org_id ON manager_organization_access(organization_id);
```

**Permissions Structure:**
```json
{
    "devices": {
        "read": true,
        "create": true,
        "update": true,
        "delete": false
    },
    "users": {
        "read": true,
        "create": true,
        "update": false,
        "delete": false
    },
    "jobs": {
        "read": true,
        "create": true,
        "update": true,
        "delete": true
    }
}
```

### 4. device_types
Global device type templates that can be synced to organizations.

```sql
CREATE TABLE device_types (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(100) UNIQUE NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    configuration JSONB DEFAULT '{}',
    default_settings JSONB DEFAULT '{}',
    icon VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes
CREATE INDEX idx_device_types_slug ON device_types(slug);
CREATE INDEX idx_device_types_is_active ON device_types(is_active);
```

**Configuration Structure:**
```json
{
    "platform": "windows",
    "architecture": ["x86", "x64"],
    "required_agent_version": "1.0.0",
    "supported_protocols": ["http", "https"],
    "monitoring": {
        "cpu": true,
        "memory": true,
        "disk": true,
        "network": true,
        "processes": true
    },
    "capabilities": [
        "file_transfer",
        "remote_execution",
        "system_info",
        "log_collection"
    ]
}
```

### 5. organization_databases
Tracks organization database connections and status.

```sql
CREATE TABLE organization_databases (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL REFERENCES organizations(id) ON DELETE CASCADE,
    database_name VARCHAR(100) UNIQUE NOT NULL,
    connection_string TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'active',
    last_backup TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes
CREATE INDEX idx_org_databases_org_id ON organization_databases(organization_id);
CREATE INDEX idx_org_databases_status ON organization_databases(status);
```

### 6. organization_device_types
Tracks which device types are enabled for each organization and their customizations.

```sql
CREATE TABLE organization_device_types (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL REFERENCES organizations(id) ON DELETE CASCADE,
    device_type_id UUID NOT NULL REFERENCES device_types(id) ON DELETE CASCADE,
    is_enabled BOOLEAN DEFAULT TRUE,
    custom_settings JSONB DEFAULT '{}',
    last_synced TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(organization_id, device_type_id)
);

-- Indexes
CREATE INDEX idx_org_device_types_org_id ON organization_device_types(organization_id);
CREATE INDEX idx_org_device_types_device_type_id ON organization_device_types(device_type_id);
CREATE INDEX idx_org_device_types_enabled ON organization_device_types(is_enabled);
```

## System Tables

### 7. system_settings
Global system configuration and settings.

```sql
CREATE TABLE system_settings (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    key VARCHAR(100) UNIQUE NOT NULL,
    value JSONB NOT NULL,
    description TEXT NULL,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes
CREATE INDEX idx_system_settings_key ON system_settings(key);
CREATE INDEX idx_system_settings_is_public ON system_settings(is_public);
```

### 8. audit_logs
System-wide audit logging for security and compliance.

```sql
CREATE TABLE audit_logs (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    manager_id UUID NULL REFERENCES managers(id) ON DELETE SET NULL,
    organization_id UUID NULL REFERENCES organizations(id) ON DELETE SET NULL,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(100) NOT NULL,
    entity_id UUID NULL,
    old_values JSONB NULL,
    new_values JSONB NULL,
    ip_address INET NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes
CREATE INDEX idx_audit_logs_manager_id ON audit_logs(manager_id);
CREATE INDEX idx_audit_logs_organization_id ON audit_logs(organization_id);
CREATE INDEX idx_audit_logs_action ON audit_logs(action);
CREATE INDEX idx_audit_logs_entity_type ON audit_logs(entity_type);
CREATE INDEX idx_audit_logs_created_at ON audit_logs(created_at);

-- Partition by month for performance
CREATE TABLE audit_logs_y2025m01 PARTITION OF audit_logs
FOR VALUES FROM ('2025-01-01') TO ('2025-02-01');
```

## Database Triggers and Functions

### Update Timestamp Trigger
```sql
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Apply to all tables with updated_at column
CREATE TRIGGER update_managers_updated_at BEFORE UPDATE ON managers
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_organizations_updated_at BEFORE UPDATE ON organizations
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- Apply to other tables as needed...
```

### Organization Database Creation Function
```sql
CREATE OR REPLACE FUNCTION create_organization_database(org_id UUID, org_slug VARCHAR)
RETURNS VARCHAR AS $$
DECLARE
    db_name VARCHAR;
BEGIN
    db_name := 'rmas_org_' || org_slug;
    
    -- Create organization database entry
    INSERT INTO organization_databases (organization_id, database_name, connection_string, status)
    VALUES (org_id, db_name, 'postgresql://user:pass@localhost/' || db_name, 'creating');
    
    RETURN db_name;
END;
$$ LANGUAGE plpgsql;
```

## Data Relationships and Constraints

### Foreign Key Constraints
- `manager_organization_access.manager_id` → `managers.id`
- `manager_organization_access.organization_id` → `organizations.id`
- `organization_databases.organization_id` → `organizations.id`
- `organization_device_types.organization_id` → `organizations.id`
- `organization_device_types.device_type_id` → `device_types.id`

### Unique Constraints
- `managers.username` - Unique username across all managers
- `managers.email` - Unique email across all managers
- `organizations.slug` - Unique organization identifier
- `organizations.database_name` - Unique database name
- `device_types.name` - Unique device type name
- `device_types.slug` - Unique device type identifier

### Check Constraints
```sql
-- Ensure organization slug format
ALTER TABLE organizations ADD CONSTRAINT chk_slug_format 
CHECK (slug ~ '^[a-z0-9_-]+$');

-- Ensure database name format
ALTER TABLE organizations ADD CONSTRAINT chk_database_name_format 
CHECK (database_name ~ '^rmas_org_[a-z0-9_-]+$');

-- Ensure valid status values
ALTER TABLE organization_databases ADD CONSTRAINT chk_status_values 
CHECK (status IN ('active', 'inactive', 'creating', 'migrating', 'backup'));
```

# RMAS UI Flow Structure

This document explains the proper hierarchical flow structure for the RMAS system UI, clarifying the relationship between Manager UI and Organization UI components.

## UI Documentation Structure

### Overview Files
- **[Manager UI Overview](manager-ui-overview.md)** - Login, dashboard, and navigation overview
- **[Organization UI Overview](organization-ui-overview.md)** - Tenant-specific interface overview

### Detailed Module Documentation
- **Manager UI Modules**:
  - [Device Types Management](modules/manager-device-types.md)
  - [Organizations Management](modules/manager-organizations.md)
  - [Users Management](modules/manager-users.md)

- **Organization UI Modules**:
  - [Device Groups Management](modules/organization-device-groups.md)
  - [Job Templates Management](modules/organization-job-templates.md)
  - [Device Management](modules/organization-device-management.md) *(coming soon)*
  - [SNMP Management](modules/organization-snmp-management.md) *(coming soon)*
  - [Alert Management](modules/organization-alert-management.md) *(coming soon)*

## UI Hierarchy Overview

### 1. Manager UI (System-wide Administration)
**Access Level**: System administrators only
**Purpose**: Manage organizations and define global templates

#### Device Type Management
- **Location**: Manager UI → Device Types
- **Purpose**: Define device type templates with custom fields
- **Features**:
  - Create device type templates (Windows Desktop, Linux Server, etc.)
  - Define custom fields for each device type
  - Configure agent/SNMP settings per device type
  - Sync templates to all organizations

#### Organization Management
- **Location**: Manager UI → Organizations
- **Purpose**: Create and manage tenant organizations
- **Features**:
  - Create new organizations
  - Monitor organization health
  - Database management
  - Global analytics

### 2. Organization UI (Tenant-specific Management)
**Access Level**: Organization users (based on roles)
**Purpose**: Manage devices within specific organization

#### Device Group Management
- **Location**: Organization UI → Groups
- **Purpose**: Create groups that reference device types from Manager UI
- **Features**:
  - Create device groups (IT Servers, HR Workstations, etc.)
  - Reference device types defined in Manager UI
  - Assign job templates to groups
  - Configure group-level settings

#### Job Template Management
- **Location**: Organization UI → Jobs → Templates
- **Purpose**: Create organization-specific job templates
- **Features**:
  - Create custom job templates with CLI commands or scripts
  - Define script paths and arguments
  - Configure scheduling and execution settings
  - Assign to device groups

#### Device Management
- **Location**: Organization UI → Devices
- **Purpose**: Register and manage individual devices
- **Features**:
  - Create devices that reference device groups
  - Inherit custom fields from device type (via group)
  - Fill in custom field values (agent-collected, SNMP, or manual)
  - Monitor device status and performance

## Detailed Flow Structure

### 1. Manager UI - Device Type Creation Flow

```
Manager UI → Device Types → [+ Create Device Type]
└── Basic Information
    ├── Type Name: "Windows Desktop"
    ├── Platform: Windows
    ├── Connection Type: Agent/SNMP/Both
    └── Description
└── Agent Configuration (if Agent selected)
    ├── Enable system monitoring modules
    ├── Collection intervals
    └── Performance settings
└── SNMP Configuration (if SNMP selected)
    ├── Default SNMP version
    ├── Default community/port
    └── Polling intervals
└── Custom Fields Definition [THIS IS KEY]
    ├── Hardware Specifications
    │   ├── CPU Cores (Integer) - Agent Collection
    │   ├── RAM (GB) (Integer) - Agent Collection
    │   └── Graphics Card (Text) - Manual Entry
    ├── Business Information
    │   ├── Department (Select) - Manual Entry *Required
    │   ├── Asset Tag (Text) - Manual Entry *Required
    │   └── Purchase Date (Date) - Manual Entry
    └── Location Information
        ├── Building (Select) - Manual Entry *Required
        ├── Floor (Text) - Manual Entry
        └── Room (Text) - Manual Entry
```

### 2. Organization UI - Device Group Creation Flow

```
Organization UI → Groups → [+ Create Group]
└── Basic Information
    ├── Group Name: "IT Servers"
    ├── Device Type: [Linux Server ▼] ← References Manager UI device types
    ├── Description
    └── Icon/Priority
└── Group Settings
    ├── Auto-assign devices
    ├── Enable monitoring
    └── Default job templates
└── Access Control
    ├── Group owner
    ├── Allowed users
    └── Permissions
```

### 3. Organization UI - Job Template Creation Flow

```
Organization UI → Jobs → Templates → [+ Create Template]
└── Template Information
    ├── Template Name: "System Health Check"
    ├── Description
    └── Category
└── Execution Configuration
    ├── Job Type: ◉ Script File ○ CLI Command
    ├── Script Path: /scripts/health_check.sh [Browse]
    ├── Arguments: --full --output-json
    ├── Working Directory: /tmp
    └── Run As User: root
└── CLI Command Configuration (alternative)
    ├── Command: systemctl status
    ├── Arguments: --no-pager --full
    └── Shell: bash
└── Scheduling & Execution
    ├── Execution Mode: Manual/Scheduled/Event-based
    ├── Schedule: Daily at 02:00 AM
    ├── Timeout: 30 minutes
    └── Retry Count: 3 attempts
└── Target Device Groups
    ├── Compatible Device Types (from template)
    └── Target Groups: [IT Servers], [Production Servers]
└── Notifications & Alerts
    ├── Notify on success/failure
    └── Notification channels
```

### 4. Organization UI - Device Creation Flow

```
Organization UI → Devices → [+ Create Device]
└── Basic Device Information
    ├── Device Name: "WIN-SRV-001"
    ├── Device Group: [IT Servers ▼] ← References organization groups
    ├── Device Type: "Windows Server" ← Inherited from group
    ├── Owner: "John Doe"
    └── Serial Number/Description
└── Connection Information
    ├── Connection Type: ◉ Agent ☑️ SNMP ← From device type
    ├── IP Address: 192.168.1.10
    ├── Agent Port/Key
    └── SNMP Community/Version/Port
└── Custom Fields ← INHERITED FROM DEVICE TYPE via Group
    ├── Hardware Specifications (Agent Collection)
    │   ├── CPU Cores: [auto-filled by agent]
    │   ├── RAM (GB): [auto-filled by agent]
    │   └── Graphics Card: [manual entry]
    ├── Business Information (Manual Entry)
    │   ├── Department: [IT ▼] *Required
    │   ├── Asset Tag: [ACME-SRV-001] *Required
    │   └── Purchase Date: [2022-08-15]
    └── Location Information (Manual Entry)
        ├── Building: [Main Office ▼] *Required
        ├── Floor: [Basement]
        └── Room: [Server Room A]
└── Device Settings
    ├── Enable monitoring
    ├── Enable custom field collection
    └── Inherit job templates from group
```

## Key Points

### Custom Fields Flow
1. **Manager UI**: Define custom fields in device types
2. **Organization UI**: Device groups reference device types (inherit custom fields)
3. **Organization UI**: Devices reference device groups (inherit custom fields from device type)
4. **Data Collection**: Agent/SNMP/Manual collection fills custom field values

### Job Templates Flow
1. **Organization UI**: Create job templates with CLI commands or script paths
2. **Organization UI**: Assign job templates to device groups
3. **Organization UI**: Devices inherit job templates from their groups
4. **Execution**: Jobs run on devices based on group assignments

### Data Inheritance Chain
```
Manager UI Device Type → Organization Device Group → Organization Device
    ↓                           ↓                         ↓
Custom Fields Definition → Custom Fields Inheritance → Custom Fields Values
Agent/SNMP Config       → Group Settings            → Device Settings
```

### UI Navigation Structure

#### Manager UI
```
Manager Portal
├── Dashboard (System overview)
├── Organizations (Tenant management)
├── Device Types (Global templates with custom fields) ← KEY
├── System Analytics
└── System Health
```

#### Organization UI
```
Organization Portal
├── Dashboard (Organization overview)
├── Devices (Device inventory and management)
├── Groups (Device groups referencing device types) ← KEY
├── Jobs (Templates and execution) ← KEY
├── SNMP (Device discovery and monitoring)
├── Alerts (Alert rules and notifications)
└── Settings (Organization configuration)
```

## Benefits of This Structure

1. **Separation of Concerns**: Manager UI handles global templates, Organization UI handles tenant-specific implementations
2. **Consistency**: Device types with custom fields are centrally defined but customizable per organization
3. **Flexibility**: Organizations can create their own groups and job templates while inheriting global structure
4. **Scalability**: New organizations automatically get access to all device types and can customize as needed
5. **Maintainability**: Global updates to device types propagate to all organizations automatically

This structure ensures proper data flow from global templates to tenant-specific implementations while maintaining flexibility and consistency across the RMAS platform.

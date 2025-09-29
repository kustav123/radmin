# Organization UI Overview

This document provides an overview and design specifications for the Organization UI interface, which is used by organization administrators and users to manage devices, groups, jobs, and monitoring within their tenant organization.

## Organization UI Overview

The Organization UI is a tenant-specific web application accessible via `/org/{org_slug}/` routes, providing comprehensive device management, SNMP monitoring, custom field configuration, and advanced alerting capabilities.

### Design Principles

- **Organization Branding**: Support for custom organization colors/logos
- **Role-based Access**: Different views for admins vs. users  
- **Real-time Monitoring**: Live device status and custom metrics
- **SNMP Integration**: Native MIB management and device discovery
- **Custom Fields**: Dynamic device field configuration and data entry
- **Mobile Responsive**: Full mobile support for field technicians
- **Colorful Interface**: Intuitive color-coded status indicators

### Module Documentation
For detailed UI mockups and field specifications, see the individual module documentation:

- **[Device Groups Management](modules/organization-device-groups.md)** - Logical device groupings with dynamic rules
- **[Job Templates Management](modules/organization-job-templates.md)** - Automation job templates and execution monitoring
- **[Device Management](modules/organization-device-management.md)** - Device registration, monitoring, and custom field collection *(coming soon)*
- **[SNMP Management](modules/organization-snmp-management.md)** - SNMP configuration, discovery, and monitoring *(coming soon)*
- **[Alert Management](modules/organization-alert-management.md)** - Alert rules, notifications, and escalation *(coming soon)*

## Enhanced Navigation Menu

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 🏢 Acme Corporation                                    👤 John Doe     [⚙️] │
├─────────────────────────────────────────────────────────────────────────────┤
│ 📊 Dashboard     📱 Devices     👥 Groups     📋 Jobs     🌐 SNMP     🚨 Alerts│
│                                                                             │
│ 📊 Dashboard                                                                │
│ ├─ 📈 Real-time Monitoring                                                 │
│ ├─ 📊 Performance Metrics                                                  │
│ ├─ 🔍 Device Overview                                                      │
│ └─ 📋 Quick Actions                                                        │
│                                                                             │
│ 📱 Device Management                                                        │
│ ├─ 🖥️ Device Inventory                                                    │
│ ├─ 📱 Register Device                                                      │
│ ├─ 🔍 Device Search                                                        │
│ └─ 📈 Device Monitoring                                                    │
│                                                                             │
│ 👥 Device Groups                                                            │
│ ├─ 📋 Group List                                                           │
│ ├─ ➕ Create Group                                                         │
│ ├─ ⚙️ Group Settings                                                       │
│ └─ 📊 Group Analytics                                                      │
│                                                                             │
│ 📋 Job Management                                                           │
│ ├─ 📋 Job Templates                                                        │
│ ├─ ➕ Create Template                                                      │
│ ├─ 🔄 Active Jobs                                                          │
│ ├─ 📊 Job History                                                          │
│ └─ ⚙️ Job Settings                                                         │
│                                                                             │
│ 🌐 SNMP Management                                                          │
│ ├─ 🖧 Device Discovery                                                     │
│ ├─ 📊 MIB Management                                                       │
│ ├─ ⚙️ SNMP Configuration                                                   │
│ └─ 📈 SNMP Monitoring                                                      │
│                                                                             │
│ 🚨 Alert Management                                                         │
│ ├─ 🚨 Alert Rules                                                          │
│ ├─ 📧 Notifications                                                        │
│ ├─ 📊 Alert History                                                        │
│ └─ ⚙️ Alert Settings                                                       │
└─────────────────────────────────────────────────────────────────────────────┘
```

## Dashboard Overview

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corporation                                           john.doe ▼   ║
╠══════════════════════════════════════════════════════════════════════════════╣
║ 📊 Dashboard    📱 Devices    👥 Groups    📋 Jobs    🌐 SNMP    🚨 Alerts   ║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ ┌─────────────────────────────────┐ ┌─────────────────────────────────────┐ ║
║ │          Device Overview        │ │         Recent Activity             │ ║
║ │                                 │ │                                     │ ║
║ │ 📱 Total Devices: 150           │ │ 🕐 Last 24 Hours                   │ ║
║ │ 🟢 Online: 149 (99.3%)          │ │                                     │ ║
║ │ 🔴 Offline: 1 (0.7%)            │ │ • 🔧 Job "Health Check" completed  │ ║
║ │ 🟡 Warning: 0 (0%)              │ │   on 150 devices (100% success)    │ ║
║ │                                 │ │   2 hours ago                       │ ║
║ │ 👥 Device Groups: 8             │ │                                     │ ║
║ │ 📋 Job Templates: 12            │ │ • 📱 Device "WORK-PC-067" added    │ ║
║ │ 🚨 Active Alerts: 0             │ │   to "HR Workstations" group       │ ║
║ │                                 │ │   4 hours ago                       │ ║
║ │           [View All]            │ │                                     │ ║
║ │                                 │ │ • 🔄 Custom fields collected       │ ║
║ │                                 │ │   from 89 devices                  │ ║
║ │                                 │ │   6 hours ago                       │ ║
║ │                                 │ │                                     │ ║
║ │                                 │ │           [View All]               │ ║
║ └─────────────────────────────────┘ └─────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │                           Device Groups Status                           │ ║
║ │                                                                          │ ║
║ │ Group Name             Type           Devices   Status    Last Activity  │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️ IT Servers          Linux Server     12     🟢 Active  2 hours ago   │ ║
║ │ 💻 HR Workstations     Windows Desktop  25     🟢 Active  4 hours ago   │ ║
║ │ 🌐 Network Devices     Network Device    8     🟢 Active  1 day ago     │ ║
║ │ 📱 Mobile Devices      Mobile Device    16     🟢 Active  2 days ago    │ ║
║ │ 💻 Dev Workstations    Linux Desktop    23     🟢 Active  6 hours ago   │ ║
║ │                                                                          │ ║
║ │                               [View All Groups]                         │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Data Flow Architecture

The Organization UI follows a hierarchical data inheritance model:

```
Manager UI (Device Types) 
    ↓ (inherits device types + custom fields)
Organization UI (Device Groups)
    ↓ (inherits from device types)
Organization UI (Devices)
    ↓ (inherits from groups + device types)
Job Templates → Devices
```

### Key Relationships:
1. **Device Types** (defined in Manager UI) provide the template and custom field definitions
2. **Device Groups** use device types to create logical collections with dynamic rules
3. **Devices** inherit custom fields from their device type and can be members of multiple groups
4. **Job Templates** can target device groups or specific devices for execution
5. **Alerts** can be configured at device, group, or organization level

## Custom Field Inheritance

Custom fields flow through the system as follows:

1. **Manager UI**: Define custom field templates for device types
2. **Organization UI**: Device groups inherit available custom fields from device types
3. **Device Registration**: New devices inherit custom fields based on their device type
4. **Field Collection**: Custom field values are collected via agent scripts or manual entry
5. **Reporting**: Custom field data is available for filtering, grouping, and reporting

## Module Integration

The Organization UI modules work together seamlessly:

- **Device Groups** → **Job Templates**: Groups can be selected as job targets
- **Job Templates** → **Devices**: Jobs execute against devices in selected groups
- **Devices** → **SNMP**: SNMP-enabled devices provide additional monitoring data
- **SNMP** → **Alerts**: SNMP metrics can trigger alert rules
- **Alerts** → **Notifications**: Alert rules send notifications via multiple channels

## Design System

### Organization Branding
Each organization can customize:
- Primary color scheme
- Logo/branding elements
- Custom CSS styling
- Theme preferences (light/dark)

### Status Color Coding
- 🟢 **Healthy/Online/Success**: #4CAF50
- 🟡 **Warning/Attention**: #FF9800
- 🔴 **Critical/Error/Offline**: #F44336
- 🔵 **Info/Processing**: #2196F3
- ⚪ **Unknown/Pending**: #9E9E9E

### Responsive Design
- **Desktop**: Full feature set with expanded layouts
- **Tablet**: Condensed layouts with touch-friendly controls
- **Mobile**: Essential features with streamlined navigation
- **Field Technician Mode**: Optimized for device registration and field data collection

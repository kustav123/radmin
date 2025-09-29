# Organization UI - Device Groups Module

This document provides comprehensive UI mockups and field specifications for the Device Groups management module in the Organization UI.

## Module Overview

**Module**: Device Groups Management
**Access Level**: Organization Administrators/Managers
**Purpose**: Create and manage logical groupings of devices
**Location**: Organization UI → Device Groups

## Device Groups List Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corporation  > Device Groups                              john.doe ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Device Groups Management                              [+ Create Device Group] ║
║                                                                              ║
║ ┌─ Search & Filters ───────────────────────────────────────────────────────┐ ║
║ │ Search: [                            ] [🔍]  Type: [All ▼]              │ ║
║ │ Status: [All ▼]  Devices: [Any ▼]  Created: [All Time ▼]  [🔄 Refresh]   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Quick Stats: Total: 8 │ Active: 7 │ Monitoring: 6 │ Devices: 150 │ Jobs: 47│ ║
║ │ Online: 149 (99.3%) │ Offline: 1 │ Alerts: 3 │ Last Job: 5 min ago       │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Group Name            Type           Devices Status  Last Updated  Actions│ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️ IT Servers                                                             │ ║
║ │   IT-SERVERS          Linux Server     12   🟢 Active  2 days ago   [👁️][✏️][🔧]│ ║
║ │   Description: Production and development servers                        │ ║
║ │   Rules: hostname contains 'srv' AND os_type = 'Linux'                 │ ║
║ │   Custom Fields: 12/15 completed | Alerts: 0 active | Jobs: 5 scheduled │ ║
║ │   Last Job: System Health Check (100% success) | SNMP: Enabled         │ ║
║ │                                                                          │ ║
║ │ 💻 HR Workstations                                                       │ ║
║ │   HR-WORKSTATIONS     Windows Desktop  25   🟢 Active  1 week ago   [👁️][✏️][🔧]│ ║
║ │   Description: Human Resources department workstations                  │ ║
║ │   Rules: department = 'HR' AND device_type = 'Windows Desktop'         │ ║
║ │   Custom Fields: 25/25 completed | Alerts: 1 warning | Jobs: 8 scheduled│ ║
║ │   Last Job: Software Inventory (96% success) | SNMP: Disabled          │ ║
║ │                                                                          │ ║
║ │ 🌐 Network Devices                                                       │ ║
║ │   NETWORK-DEVICES     Network Device    8   🟢 Active  3 days ago   [👁️][✏️][🔧]│ ║
║ │   Description: Switches, routers, and network infrastructure           │ ║
║ │   Rules: device_category = 'Network' OR device_type contains 'Switch'  │ ║
║ │   Custom Fields: 8/10 completed | Alerts: 0 active | Jobs: 3 scheduled │ ║
║ │   Last Job: Network Health Scan (100% success) | SNMP: Enabled         │ ║
║ │                                                                          │ ║
║ │ 🖨️ Office Printers                                                       │ ║
║ │   OFFICE-PRINTERS     Network Printer   6   🟡 Warning 1 month ago [👁️][✏️][🔧]│ ║
║ │   Description: Office printers and multifunction devices               │ ║
║ │   Rules: device_type = 'Network Printer' AND location contains 'Office'│ ║
║ │   Custom Fields: 4/8 completed | Alerts: 2 warnings | Jobs: 2 scheduled│ ║
║ │   Last Job: Printer Status Check (83% success) | SNMP: Enabled         │ ║
║ │                                                                          │ ║
║ │ 📱 Mobile Devices                                                        │ ║
║ │   MOBILE-DEVICES      Mobile Device    16   🟢 Active  5 days ago   [👁️][✏️][🔧]│ ║
║ │   Description: Company mobile phones and tablets                       │ ║
║ │   Rules: device_category = 'Mobile' AND managed_status = 'Active'      │ ║
║ │   Custom Fields: 12/16 completed | Alerts: 0 active | Jobs: 6 scheduled│ ║
║ │   Last Job: Mobile Security Check (100% success) | SNMP: N/A           │ ║
║ │                                                                          │ ║
║ │ 💻 Dev Workstations                                                      │ ║
║ │   DEV-WORKSTATIONS    Linux Desktop    23   🟢 Active  2 days ago   [👁️][✏️][🔧]│ ║
║ │   Description: Development team workstations and laptops               │ ║
║ │   Rules: department = 'Engineering' AND os_type = 'Linux'              │ ║
║ │   Custom Fields: 20/23 completed | Alerts: 1 info | Jobs: 12 scheduled │ ║
║ │   Last Job: Development Tools Check (95% success) | SNMP: Disabled     │ ║
║ │                                                                          │ ║
║ │ 🖥️ Production Servers                                                    │ ║
║ │   PROD-SERVERS        Linux Server     45   🟢 Active  1 day ago    [👁️][✏️][🔧]│ ║
║ │   Description: Critical production application servers                  │ ║
║ │   Rules: environment = 'Production' AND device_role = 'Application'    │ ║
║ │   Custom Fields: 45/45 completed | Alerts: 0 active | Jobs: 15 scheduled│ ║
║ │   Last Job: Production Health Monitor (100% success) | SNMP: Enabled   │ ║
║ │                                                                          │ ║
║ │ 🔧 Infrastructure                                                        │ ║
║ │   INFRASTRUCTURE      Various          15   🟢 Active  6 days ago   [👁️][✏️][🔧]│ ║
║ │   Description: DNS, DHCP, monitoring, and support systems              │ ║
║ │   Rules: device_role = 'Infrastructure' OR service_tier = 'Critical'   │ ║
║ │   Custom Fields: 13/15 completed | Alerts: 1 info | Jobs: 8 scheduled  │ ║
║ │   Last Job: Infrastructure Monitoring (100% success) | SNMP: Enabled   │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Bulk Actions ───────────────────────────────────────────────────────────┐ ║
║ │ ☐ Select All [🔧 Run Job] [📊 Generate Report] [🚨 Test Alerts] [📤 Export]│ ║
║ │ [🔄 Refresh Membership] [⚙️ Update Fields] [📋 Clone Groups]              │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Create Device Group Form

```
╔══════════════════════════════════════════════════════════════════════════════╗
║                     ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░          ║
║   ░░░ ┌──────────────────────────────────────────────────────────────┐ ░░░  ║
║   ░░░ │                   Create Device Group                        │ ░░░  ║
║   ░░░ ├──────────────────────────────────────────────────────────────┤ ░░░  ║
║   ░░░ │                                                              │ ░░░  ║
║   ░░░ │ 📋 Basic Information                                         │ ░░░  ║
║   ░░░ │ ┌────────────────────────────────────────────────────────┐   │ ░░░  ║
║   ░░░ │ │ Group Name:         [IT Development Servers] *Required │   │ ░░░  ║
║   ░░░ │ │ Group ID:           [IT-DEV-SERVERS        ] (auto)    │   │ ░░░  ║
║   ░░░ │ │ Description:        [Development and testing servers   │   │ ░░░  ║
║   ░░░ │ │                      for the IT department            ]│   │ ░░░  ║
║   ░░░ │ │ Device Type:        [Linux Server ▼        ]          │   │ ░░░  ║
║   ░░░ │ │ Category:           [Servers ▼             ]          │   │ ░░░  ║
║   ░░░ │ │ Priority:           [Medium ▼              ]          │   │ ░░░  ║
║   ░░░ │ │ Department:         [Information Technology]          │   │ ░░░  ║
║   ░░░ │ │ Location:           [Data Center A         ]          │   │ ░░░  ║
║   ░░░ │ │ Environment:        [Development ▼         ]          │   │ ░░░  ║
║   ░░░ │ │ Service Tier:       [Standard ▼            ]          │   │ ░░░  ║
║   ░░░ │ └────────────────────────────────────────────────────────┘   │ ░░░  ║
║   ░░░ │                                                              │ ░░░  ║
║   ░░░ │ 🎯 Membership Rules                                          │ ░░░  ║
║   ░░░ │ ┌────────────────────────────────────────────────────────┐   │ ░░░  ║
║   ░░░ │ │ Rule Type:          ◉ Dynamic (automatic membership)   │   │ ░░░  ║
║   ░░░ │ │                     ○ Static (manual assignment)      │   │ ░░░  ║
║   ░░░ │ │                     ○ Mixed (both automatic & manual) │   │ ░░░  ║
║   ░░░ │ │                                                        │   │ ░░░  ║
║   ░░░ │ │ Dynamic Rules Builder:                                 │   │ ░░░  ║
║   ░░░ │ │ ┌──────────────────────────────────────────────────┐   │   │ ░░░  ║
║   ░░░ │ │ │ Field       Operator    Value            Logic │   │   │ ░░░  ║
║   ░░░ │ │ │ ──────────────────────────────────────────────── │   │   │ ░░░  ║
║   ░░░ │ │ │ device_type  equals     Linux Server      -    │   │   │ ░░░  ║
║   ░░░ │ │ │ AND                                              │   │   │ ░░░  ║
║   ░░░ │ │ │ department   equals     IT               [❌]   │   │   │ ░░░  ║
║   ░░░ │ │ │ AND                                              │   │   │ ░░░  ║
║   ░░░ │ │ │ environment  equals     Development      [❌]   │   │   │ ░░░  ║
║   ░░░ │ │ │ [+ Add Rule] [🧪 Test Rules] [📋 Preview]        │   │   │ ░░░  ║
║   ░░░ │ │ └──────────────────────────────────────────────────┘   │   │ ░░░  ║
║   ░░░ │ │                                                        │   │ ░░░  ║
║   ░░░ │ │ Available Fields:                                      │   │ ░░░  ║
║   ░░░ │ │ 🖥️ device_type, hostname, ip_address, mac_address     │   │ ░░░  ║
║   ░░░ │ │ 🏢 department, location, environment, service_tier    │   │ ░░░  ║
║   ░░░ │ │ ⚙️ os_type, os_version, cpu_count, memory_gb          │   │ ░░░  ║
║   ░░░ │ │ 📊 managed_status, monitoring_enabled, snmp_enabled   │   │ ░░░  ║
║   ░░░ │ │ 📅 created_date, last_seen, last_inventory_date       │   │ ░░░  ║
║   ░░░ │ │ + Any custom fields defined for this device type      │   │ ░░░  ║
║   ░░░ │ └────────────────────────────────────────────────────────┘   │ ░░░  ║
║   ░░░ │                                                              │ ░░░  ║
║   ░░░ │ 📊 Preview Results (8 devices match)                        │ ░░░  ║
║   ░░░ │ ┌────────────────────────────────────────────────────────┐   │ ░░░  ║
║   ░░░ │ │ Matching Devices:                                      │   │ ░░░  ║
║   ░░░ │ │ • DEV-SRV-001 (192.168.10.101) - Ubuntu 22.04         │   │ ░░░  ║
║   ░░░ │ │ • DEV-SRV-002 (192.168.10.102) - Ubuntu 22.04         │   │ ░░░  ║
║   ░░░ │ │ • DEV-SRV-003 (192.168.10.103) - CentOS 8             │   │ ░░░  ║
║   ░░░ │ │ • DEV-SRV-004 (192.168.10.104) - Ubuntu 20.04         │   │ ░░░  ║
║   ░░░ │ │ • TEST-DB-001 (192.168.10.201) - PostgreSQL Server    │   │ ░░░  ║
║   ░░░ │ │ • TEST-WEB-001 (192.168.10.301) - Nginx Proxy         │   │ ░░░  ║
║   ░░░ │ │ • DEV-BUILD-001 (192.168.10.401) - Jenkins Build      │   │ ░░░  ║
║   ░░░ │ │ • DEV-LOG-001 (192.168.10.501) - ElasticSearch        │   │ ░░░  ║
║   ░░░ │ │                                              [View All]│   │ ░░░  ║
║   ░░░ │ └────────────────────────────────────────────────────────┘   │ ░░░  ║
║   ░░░ │                                                              │ ░░░  ║
║   ░░░ │ ⚙️ Configuration Options                                     │ ░░░  ║
║   ░░░ │ ┌────────────────────────────────────────────────────────┐   │ ░░░  ║
║   ░░░ │ │ ☑️ Enable automatic device discovery for this group   │   │ ░░░  ║
║   ░░░ │ │ ☑️ Apply group-specific monitoring settings           │   │ ░░░  ║
║   ░░░ │ │ ☑️ Inherit custom fields from device type            │   │ ░░░  ║
║   ░░️ │ │ ☑️ Enable SNMP monitoring                             │   │ ░░░  ║
║   ░░░ │ │ ☑️ Create default alert rules                         │   │ ░░░  ║
║   ░░░ │ │ ☐ Require approval for membership changes            │   │ ░░░  ║
║   ░░░ │ │                                                        │   │ ░░░  ║
║   ░░░ │ │ Monitoring Interval:    [5            ] minutes        │   │ ░░░  ║
║   ░░░ │ │ Data Retention:         [90           ] days           │   │ ░░░  ║
║   ░░░ │ │ Collection Schedule:    [Every hour ▼ ]               │   │ ░░░  ║
║   ░░░ │ │ Backup Priority:        [Medium ▼     ]               │   │ ░░░  ║
║   ░░░ │ └────────────────────────────────────────────────────────┘   │ ░░░  ║
║   ░░░ │                                                              │ ░░░  ║
║   ░░░ │ 👥 Permissions & Access                                      │ ░░░  ║
║   ░░░ │ ┌────────────────────────────────────────────────────────┐   │ ░░░  ║
║   ░░░ │ │ Group Owner:            [john.doe@acme.com ▼]          │   │ ░░░  ║
║   ░░░ │ │ Manager Users:          [+ Add Manager]                │   │ ░░░  ║
║   ░░░ │ │ • jane.smith@acme.com (can edit devices & run jobs)    │   │ ░░░  ║
║   ░░░ │ │ • mike.wilson@acme.com (can view devices only)         │   │ ░░░  ║
║   ░░░ │ │                                                        │   │ ░░░  ║
║   ░░░ │ │ Read-Only Users:        [+ Add Viewer]                 │   │ ░░░  ║
║   ░░░ │ │ • support@acme.com (can view device status & logs)     │   │ ░░░  ║
║   ░░░ │ │                                                        │   │ ░░░  ║
║   ░░░ │ │ Visibility:             ◉ All organization users       │   │ ░░░  ║
║   ░░░ │ │                         ○ Specified users only        │   │ ░░░  ║
║   ░░░ │ │                         ○ Owner and managers only     │   │ ░░░  ║
║   ░░░ │ └────────────────────────────────────────────────────────┘   │ ░░░  ║
║   ░░░ │                                                              │ ░░░  ║
║   ░░░ │ 🔔 Notification Settings                                     │ ░░░  ║
║   ░░░ │ ┌────────────────────────────────────────────────────────┐   │ ░░░  ║
║   ░░░ │ │ ☑️ Notify on device additions/removals                 │   │ ░░░  ║
║   ░░️ │ │ ☑️ Notify on device status changes                     │   │ ░░░  ║
║   ░░░ │ │ ☑️ Notify on alert rule triggers                       │   │ ░░░  ║
║   ░░░ │ │ ☑️ Send daily group summary                            │   │ ░░░  ║
║   ░░░ │ │ ☐ Notify on custom field completion changes           │   │ ░░░  ║
║   ░░░ │ │                                                        │   │ ░░░  ║
║   ░░░ │ │ Notification Recipients:                               │   │ ░░░  ║
║   ░░░ │ │ ☑️ Group owner        ☑️ Group managers                │   │ ░░░  ║
║   ░░░ │ │ ☐ All users           ☐ Custom email list             │   │ ░░░  ║
║   ░░░ │ └────────────────────────────────────────────────────────┘   │ ░░░  ║
║   ░░░ │                                                              │ ░░░  ║
║   ░░░ │        [❌ Cancel] [🧪 Test Rules] [💾 Create Group]          │ ░░░  ║
║   ░░░ └──────────────────────────────────────────────────────────────┘ ░░░  ║
║                     ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░          ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Device Group Details View

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corporation  > Device Groups > IT Servers                john.doe ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Device Group: IT Servers                     [✏️ Edit] [🔧 Run Job] [📊] [⚠️]║
║                                                                              ║
║ ┌─ Group Overview ─────────────────────────────────────────────────────────┐ ║
║ │ Group ID: IT-SERVERS                       Type: Linux Server            │ ║
║ │ Description: Production and development servers for IT operations        │ ║
║ │ Created: 2024-01-15 by john.doe            Last Updated: 2 days ago      │ ║
║ │ Owner: john.doe@acme.com                   Department: Information Tech.  │ ║
║ │ Environment: Mixed                         Service Tier: Critical         │ ║
║ │ Status: 🟢 Active | Monitoring: ✅ Enabled | SNMP: ✅ Enabled            │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Device Statistics ──────────────────────────────────────────────────────┐ ║
║ │                                                                          │ ║
║ │ 📱 Total Devices: 12                                                     │ ║
║ │ ├─ Online: 12 (100%) ████████████████████████████████████████████████   │ ║
║ │ ├─ Offline: 0 (0%)   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░   │ ║
║ │ └─ Warning: 0 (0%)   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░   │ ║
║ │                                                                          │ ║
║ │ 💾 Custom Fields Completion: 189/195 (97%) ████████████████████████░░   │ ║
║ │ ├─ Hardware Info: 12/12 (100%)      ├─ Business Info: 11/12 (92%)      │ ║
║ │ ├─ Location Info: 12/12 (100%)      ├─ Network Info: 12/12 (100%)      │ ║
║ │ └─ Service Info: 12/12 (100%)       └─ Security Info: 11/12 (92%)      │ ║
║ │                                                                          │ ║
║ │ 🔄 Last Activities:                                                      │ ║
║ │ ├─ Last Job: System Health Check (2 hours ago) - 100% success           │ ║
║ │ ├─ Last Collection: Custom fields (30 minutes ago) - 97% completion     │ ║
║ │ ├─ Last Discovery: SNMP scan (1 day ago) - Found 0 new devices          │ ║
║ │ └─ Last Alert: None                                                      │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Membership Rules ───────────────────────────────────────────────────────┐ ║
║ │ Rule Type: Dynamic (automatic membership)                                │ ║
║ │                                                                          │ ║
║ │ Active Rules:                                                            │ ║
║ │ • device_type = 'Linux Server'                                           │ ║
║ │ • AND hostname contains 'srv'                                            │ ║
║ │ • AND department = 'IT'                                                  │ ║
║ │                                                                          │ ║
║ │ Last Evaluation: 2024-09-30 14:00 (12 devices matched)                  │ ║
║ │ Next Evaluation: 2024-09-30 15:00 (automatic every hour)                │ ║
║ │                                                [🧪 Test] [✏️ Edit Rules] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Devices in Group (12) ──────────────────────────────────────────────────┐ ║
║ │ Search: [               ] [🔍] Status: [All ▼] [🔄 Refresh] [+ Add Device]│ ║
║ │                                                                          │ ║
║ │ Device Name          IP Address      Status      Custom Fields  Actions │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️ PROD-SRV-001                                                          │ ║
║ │   prod-srv-001.local  192.168.1.101  🟢 Online    15/15 (100%)   [👁️][⚙️]│ ║
║ │   Ubuntu 22.04 | CPU: 8 cores | RAM: 32GB | Role: Database Server      │ ║
║ │   Last Seen: 2 min ago | SNMP: ✅ | Alerts: 0 | Jobs: 3 scheduled       │ ║
║ │                                                                          │ ║
║ │ 🖥️ PROD-SRV-002                                                          │ ║
║ │   prod-srv-002.local  192.168.1.102  🟢 Online    15/15 (100%)   [👁️][⚙️]│ ║
║ │   Ubuntu 22.04 | CPU: 16 cores | RAM: 64GB | Role: Application Server  │ ║
║ │   Last Seen: 1 min ago | SNMP: ✅ | Alerts: 0 | Jobs: 5 scheduled       │ ║
║ │                                                                          │ ║
║ │ 🖥️ DEV-SRV-001                                                           │ ║
║ │   dev-srv-001.local   192.168.10.101 🟢 Online    13/15 (87%)    [👁️][⚙️]│ ║
║ │   Ubuntu 20.04 | CPU: 4 cores | RAM: 16GB | Role: Development Server   │ ║
║ │   Last Seen: 3 min ago | SNMP: ✅ | Alerts: 0 | Jobs: 2 scheduled       │ ║
║ │                                                                          │ ║
║ │ 🖥️ TEST-SRV-001                                                          │ ║
║ │   test-srv-001.local  192.168.20.101 🟢 Online    14/15 (93%)    [👁️][⚙️]│ ║
║ │   CentOS 8 | CPU: 8 cores | RAM: 32GB | Role: Testing Server           │ ║
║ │   Last Seen: 5 min ago | SNMP: ✅ | Alerts: 0 | Jobs: 1 scheduled       │ ║
║ │                                                                          │ ║
║ │ [Show 8 more devices...]                              [📋 View All (12)] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Recent Jobs (5) ────────────────────────────────────────────────────────┐ ║
║ │ Job Name                    Started      Status      Devices  Duration   │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ System Health Check         12:00        ✅ Success   12/12    4.2 min    │ ║
║ │ Security Updates           Yesterday     ✅ Success   12/12    23.8 min   │ ║
║ │ Disk Space Monitor         2 days ago    ✅ Success   12/12    1.5 min    │ ║
║ │ Log Rotation               3 days ago    ✅ Success   12/12    2.1 min    │ ║
║ │ Database Backup            1 week ago    ✅ Success   3/3      15.4 min   │ ║
║ │                                                          [📋 View All →] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Custom Field Progress ──────────────────────────────────────────────────┐ ║
║ │ Field Category               Completion    Missing Fields                 │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🔧 Hardware Information     12/12 (100%)  ████████████████████████████    │ ║
║ │ 🏢 Business Information     11/12 (92%)   ████████████████████████░░░     │ ║
║ │ 📍 Location Information     12/12 (100%)  ████████████████████████████    │ ║
║ │ 🌐 Network Information      12/12 (100%)  ████████████████████████████    │ ║
║ │ ⚙️ Service Information      12/12 (100%)  ████████████████████████████    │ ║
║ │ 🔒 Security Information     11/12 (92%)   ████████████████████████░░░     │ ║
║ │                                                                          │ ║
║ │ Devices Missing Fields:                                                  │ ║
║ │ • DEV-SRV-001: Business Contact, Security Compliance                    │ ║
║ │ • TEST-SRV-001: Business Contact                                        │ ║
║ │                                        [🔄 Collect Missing] [📋 Report] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Quick Actions ──────────────────────────────────────────────────────────┐ ║
║ │ [🔧 Run Job] [📊 Generate Report] [🚨 Create Alert] [🔄 Refresh Data]     │ ║
║ │ [📤 Export List] [👥 Manage Users] [⚙️ Group Settings] [📋 Clone Group]   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Module Field Specifications

### Basic Information Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `group_name` | String | ✅ | - | Max 100 chars, unique within org |
| `group_id` | String | ✅ | auto-generated | Uppercase, hyphenated, unique |
| `description` | Text | ❌ | - | Max 500 chars |
| `device_type` | String | ✅ | - | Must match existing device type |
| `category` | Enum | ❌ | - | Servers, Workstations, Network, Mobile, Other |
| `priority` | Enum | ✅ | Medium | Low, Medium, High, Critical |
| `department` | String | ❌ | - | Max 100 chars |
| `location` | String | ❌ | - | Max 100 chars |
| `environment` | Enum | ❌ | - | Production, Development, Testing, Staging |
| `service_tier` | Enum | ❌ | Standard | Basic, Standard, Premium, Critical |

### Membership Rules Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `rule_type` | Enum | ✅ | Dynamic | Dynamic, Static, Mixed |
| `dynamic_rules` | JSON | ❌ | [] | Array of rule objects |
| `static_devices` | JSON | ❌ | [] | Array of device IDs |
| `rule_logic` | Enum | ✅ | AND | AND, OR |
| `auto_discovery` | Boolean | ✅ | true | - |
| `approval_required` | Boolean | ✅ | false | - |
| `evaluation_schedule` | String | ✅ | "0 * * * *" | Cron expression |
| `last_evaluation` | DateTime | ❌ | null | Auto-updated |

### Configuration Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `monitoring_enabled` | Boolean | ✅ | true | - |
| `monitoring_interval` | Integer | ✅ | 5 | Minutes, 1-60 |
| `snmp_enabled` | Boolean | ✅ | false | - |
| `inherit_custom_fields` | Boolean | ✅ | true | - |
| `create_alert_rules` | Boolean | ✅ | true | - |
| `data_retention_days` | Integer | ✅ | 90 | Days, 7-365 |
| `collection_schedule` | String | ✅ | "0 * * * *" | Cron expression |
| `backup_priority` | Enum | ✅ | Medium | Low, Medium, High |

### Permissions Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `owner_id` | UUID | ✅ | current_user | Valid user ID |
| `manager_users` | JSON | ❌ | [] | Array of user IDs |
| `readonly_users` | JSON | ❌ | [] | Array of user IDs |
| `visibility` | Enum | ✅ | All | All, Specified, Owners |
| `created_by` | UUID | ✅ | current_user | Valid user ID |
| `last_modified_by` | UUID | ✅ | current_user | Valid user ID |

### Notification Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `notify_additions` | Boolean | ✅ | true | - |
| `notify_status_changes` | Boolean | ✅ | true | - |
| `notify_alerts` | Boolean | ✅ | true | - |
| `daily_summary` | Boolean | ✅ | false | - |
| `notify_field_changes` | Boolean | ✅ | false | - |
| `notification_recipients` | JSON | ✅ | ["owner"] | Array of recipient types |

### Status Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `status` | Enum | ✅ | Active | Active, Inactive, Archived |
| `device_count` | Integer | ✅ | 0 | Auto-calculated |
| `online_count` | Integer | ✅ | 0 | Auto-calculated |
| `custom_field_completion` | Float | ✅ | 0.0 | Percentage, 0-100 |
| `last_activity` | DateTime | ❌ | null | Auto-updated |
| `created_date` | DateTime | ✅ | now() | Auto-set |
| `last_modified` | DateTime | ✅ | now() | Auto-updated |

### Dynamic Rule Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `field` | String | ✅ | - | Valid device field name |
| `operator` | Enum | ✅ | equals | equals, not_equals, contains, not_contains, starts_with, ends_with, greater_than, less_than, in, not_in |
| `value` | String | ✅ | - | Value to compare against |
| `logic` | Enum | ✅ | AND | AND, OR |
| `case_sensitive` | Boolean | ✅ | false | - |

### Menu Structure
```
Device Groups
├── Device Groups List
│   ├── Search & Filters
│   ├── Create Device Group
│   ├── Bulk Actions
│   └── Quick Stats
├── Create Device Group
│   ├── Basic Information
│   ├── Membership Rules
│   │   ├── Dynamic Rules Builder
│   │   └── Preview Results
│   ├── Configuration Options
│   ├── Permissions & Access
│   └── Notification Settings
├── Device Group Details
│   ├── Group Overview
│   ├── Device Statistics
│   ├── Membership Rules
│   ├── Devices in Group
│   ├── Recent Jobs
│   ├── Custom Field Progress
│   └── Quick Actions
└── Group Management
    ├── Edit Group Settings
    ├── Manage Permissions
    ├── View Activity Log
    └── Export Group Data
```

This module provides comprehensive device group management capabilities, allowing organization users to create logical groupings of devices with dynamic rules, monitor group health, and manage device collections efficiently.

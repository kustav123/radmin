# Manager U## Device Types List Page

```text
╔══════════════════════════════════════════════════════════════════════════════╗Device Types Module

This document provides comprehensive UI mockups and field specifications for the Device Types management module in the Manager UI.

## Module Overview

**Module**: Device Types Management
**Access Level**: System Administrators
**Purpose**: Define global device type templates with custom fields
**Location**: Manager UI → Device Types

## Main Device Types List Page

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Device Types                                       Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Device Type Templates                                   [+ Create Device Type] ║
║                                                                              ║
║ ┌─ Search & Filters ───────────────────────────────────────────────────────┐ ║
║ │ Search: [                            ] [🔍]  Platform: [All ▼]          │ ║
║ │ Connection: [All ▼]  Status: [All ▼]  Sort: [Name ▼]  [🔄 Refresh]     │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Templates are synchronized to all organizations automatically            │ ║
║ │ Organizations inherit these templates but can customize settings         │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Name               Platform   Conn    Fields  Orgs  Devices   Actions    │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️ Windows Desktop                                                        │ ║
║ │   windows-desktop   Windows   Agent    12     25    1,240   [👁️][✏️][🔄] │ ║
║ │   Description: Standard Windows desktop/workstation computers           │ ║
║ │   Created: 2024-01-10 | Updated: 2024-09-15 | Status: 🟢 Active        │ ║
║ │   Custom Fields: Hardware(4), Business(5), Location(3)                  │ ║
║ │                                                                          │ ║
║ │ 🐧 Linux Server                                                          │ ║
║ │   linux-server      Linux    Agent     8     23     890    [👁️][✏️][🔄] │ ║
║ │   Description: Linux-based server systems and infrastructure            │ ║
║ │   Created: 2024-01-08 | Updated: 2024-09-12 | Status: 🟢 Active        │ ║
║ │   Custom Fields: Hardware(3), Business(3), Location(2)                  │ ║
║ │                                                                          │ ║
║ │ 🍎 macOS Workstation                                                     │ ║
║ │   macos-workstation macOS     Agent    10     12     320    [👁️][✏️][🔄] │ ║
║ │   Description: Apple macOS workstations and laptops                     │ ║
║ │   Created: 2024-01-05 | Updated: 2024-09-10 | Status: 🟢 Active        │ ║
║ │   Custom Fields: Hardware(4), Business(4), Location(2)                  │ ║
║ │                                                                          │ ║
║ │ 📡 Network Device                                                        │ ║
║ │   network-device    Generic   SNMP     6      8      45    [👁️][✏️][🔄] │ ║
║ │   Description: Network equipment monitored via SNMP                     │ ║
║ │   Created: 2024-01-12 | Updated: 2024-09-08 | Status: 🟢 Active        │ ║
║ │   Custom Fields: Hardware(2), Business(2), Location(2)                  │ ║
║ │                                                                          │ ║
║ │ 🖨️ Network Printer                                                       │ ║
║ │   network-printer   Generic   SNMP     5      6      28    [👁️][✏️][🔄] │ ║
║ │   Description: Network printers and multifunction devices               │ ║
║ │   Created: 2024-02-01 | Updated: 2024-09-05 | Status: 🟡 Draft         │ ║
║ │   Custom Fields: Hardware(2), Business(2), Location(1)                  │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ 📊 Statistics                                                               ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Total Templates: 5  │  Active: 4  │  Total Devices: 2,503  │  Avg Fields: 8│ ║
║ │ Organizations: 25   │  Draft: 1   │  Last Sync: 2024-09-15 │  Sync Pending: 0│ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ Legend: [👁️] View Details  [✏️] Edit  [🔄] Sync to Organizations            ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Create Device Type Form

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║                      ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░     ║
║   ░░░ ┌──────────────────────────────────────────────────────────────┐ ░░░   ║
║   ░░░ │                 Create Device Type Template                  │ ░░░   ║
║   ░░░ ├──────────────────────────────────────────────────────────────┤ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 📋 Basic Information                                         │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────────┐ │ ░░░   ║
║   ░░░ │ │ Type Name:      [Windows Desktop        ] *Required      │ │ ░░░   ║
║   ░░░ │ │ Slug:           [windows-desktop        ] (auto-generated)│ │ ░░░   ║
║   ░░░ │ │ Platform:       [Windows ▼              ]               │ │ ░░░   ║
║   ░░░ │ │                 ├─ Windows                               │ │ ░░░   ║
║   ░░░ │ │                 ├─ Linux                                 │ │ ░░░   ║
║   ░░░ │ │                 ├─ macOS                                 │ │ ░░░   ║
║   ░░░ │ │                 ├─ Generic                               │ │ ░░░   ║
║   ░░░ │ │                 └─ Other                                 │ │ ░░░   ║
║   ░░░ │ │ Connection Type: ◉ Agent  ○ SNMP  ○ Both                │ │ ░░░   ║
║   ░░░ │ │ Icon:           [🖥️ ▼                   ]               │ │ ░░░   ║
║   ░░░ │ │ Description:    [Standard Windows desktop computers...] │ │ ░░░   ║
║   ░░░ │ │ Status:         ◉ Active  ○ Draft                       │ │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────────┘ │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 🔧 Agent Configuration (when Agent selected)                │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────────┐ │ ░░░   ║
║   ░░░ │ │ Default Agent Port:    [8080              ]              │ │ ░░░   ║
║   ░░░ │ │ Agent Capabilities:                                      │ │ ░░░   ║
║   ░░░ │ │ ☑️ System Information Collection                         │ │ ░░░   ║
║   ░░░ │ │ ☑️ Performance Monitoring                                │ │ ░░░   ║
║   ░░░ │ │ ☑️ File System Monitoring                                │ │ ░░░   ║
║   ░░░ │ │ ☑️ Process Monitoring                                    │ │ ░░░   ║
║   ░░░ │ │ ☑️ Registry Access (Windows only)                        │ │ ░░░   ║
║   ░░░ │ │ ☑️ Software Inventory                                    │ │ ░░░   ║
║   ░░░ │ │ ☑️ Event Log Collection                                  │ │ ░░░   ║
║   ░░░ │ │ Collection Interval:   [5        ] minutes               │ │ ░░░   ║
║   ░░░ │ │ Heartbeat Interval:    [30       ] seconds               │ │ ░░░   ║
║   ░░░ │ │ Max Offline Duration:  [300      ] seconds               │ │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────────┘ │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 📡 SNMP Configuration (when SNMP selected)                  │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────────┐ │ ░░░   ║
║   ░░░ │ │ Default SNMP Version:  [v2c ▼               ]            │ │ ░░░   ║
║   ░░░ │ │ Default Community:     [public              ]            │ │ ░░░   ║
║   ░░░ │ │ Default Port:          [161                 ]            │ │ ░░░   ║
║   ░░░ │ │ Poll Interval:         [30       ] seconds               │ │ ░░░   ║
║   ░░░ │ │ Timeout:               [5        ] seconds               │ │ ░░░   ║
║   ░░░ │ │ Retries:               [3        ] attempts              │ │ ░░░   ║
║   ░░░ │ │ Supported MIBs:        [+ Add MIB]                       │ │ ░░░   ║
║   ░░░ │ │ ├─ SNMPv2-MIB (System information)                       │ │ ░░░   ║
║   ░░░ │ │ ├─ IF-MIB (Interface statistics)                         │ │ ░░░   ║
║   ░░░ │ │ └─ HOST-RESOURCES-MIB (Hardware info)                    │ │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────────┘ │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │                        [Continue →]                         │ ░░░   ║
║   ░░░ └──────────────────────────────────────────────────────────────┘ ░░░   ║
║                      ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░     ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Custom Fields Configuration Step

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║                      ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░     ║
║   ░░░ ┌──────────────────────────────────────────────────────────────┐ ░░░   ║
║   ░░░ │               Custom Fields Configuration                    │ ░░░   ║
║   ░░░ ├──────────────────────────────────────────────────────────────┤ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 🏷️ Custom Fields for: Windows Desktop                       │ ░░░   ║
║   ░░░ │                                         [+ Add Field]        │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 🔧 Hardware Specifications Category                          │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────────┐ │ ░░░   ║
║   ░░░ │ │ ├─ CPU Cores (Integer)           Agent    Required  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Source: system_info.hardware.cpu.cores             │ │ ░░░   ║
║   ░░░ │ │ │  Range: 1-128, Default: 4                           │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ RAM Total (Integer)           Agent    Required  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Source: system_info.hardware.memory.total_gb       │ │ ░░░   ║
║   ░░░ │ │ │  Unit: GB, Range: 1-1024, Default: 8                │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Storage Type (Select)         Agent    Optional  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Source: system_info.storage.primary.type           │ │ ░░░   ║
║   ░░░ │ │ │  Options: HDD, SSD, NVMe, Hybrid                    │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Graphics Card (Text)          Manual   Optional  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Max Length: 100, Pattern: [A-Za-z0-9\s\-]+         │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────────┘ │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 🏢 Business Information Category                             │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────────┐ │ ░░░   ║
║   ░░░ │ │ ├─ Department (Select)           Manual   Required  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Options: IT, HR, Finance, Sales, Marketing, Ops    │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Cost Center (Text)            Manual   Optional  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Max Length: 50, Pattern: [A-Z]{2,3}-[0-9]{4}       │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Asset Tag (Text)              Manual   Required  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Max Length: 20, Unique: Yes                        │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Purchase Date (Date)          Manual   Optional  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Format: YYYY-MM-DD, Range: 2020-2030               │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Warranty Expiry (Date)       Manual   Optional  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Format: YYYY-MM-DD, Auto-calc from Purchase       │ │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────────┘ │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 📍 Location Information Category                             │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────────┐ │ ░░░   ║
║   ░░░ │ │ ├─ Building (Select)             Manual   Required  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Options: Main Office, Branch A, Branch B, Remote   │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Floor (Text)                  Manual   Optional  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Max Length: 20, Example: "2nd Floor", "Basement"   │ │ ░░░   ║
║   ░░░ │ │                                                          │ │ ░░░   ║
║   ░░░ │ │ ├─ Room (Text)                   Manual   Optional  [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Max Length: 50, Example: "Conference Room A"       │ │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────────┘ │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │ 📊 Calculated Fields Category                                │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────────┐ │ ░░░   ║
║   ░░░ │ │ ├─ Performance Index (Integer)   Calculated Auto    [✏️][❌]│ │ ░░░   ║
║   ░░░ │ │ │  Formula: (CPU_Score + RAM_Score + Storage_Score)/3 │ │ ░░░   ║
║   ░░░ │ │ │  Range: 0-100, Update: Every 5 minutes             │ │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────────┘ │ ░░░   ║
║   ░░░ │                                                              │ ░░░   ║
║   ░░░ │         [← Back] [🧪 Validate] [💾 Save Template]          │ ░░░   ║
║   ░░░ └──────────────────────────────────────────────────────────────┘ ░░░   ║
║                      ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░     ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Add Custom Field Modal

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║                         ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░         ║
║     ░░░ ┌───────────────────────────────────────────────────────────┐ ░░░   ║
║     ░░░ │                 Add Custom Field                          │ ░░░   ║
║     ░░░ ├───────────────────────────────────────────────────────────┤ ░░░   ║
║     ░░░ │                                                           │ ░░░   ║
║     ░░░ │ 📋 Field Definition                                       │ ░░░   ║
║     ░░░ │ ┌─────────────────────────────────────────────────────┐   │ ░░░   ║
║     ░░░ │ │ Field Name:     [CPU Cores              ] *Required │   │ ░░░   ║
║     ░░░ │ │ Display Name:   [Number of CPU Cores    ]           │   │ ░░░   ║
║     ░░░ │ │ Field Type:     [Integer ▼              ]           │   │ ░░░   ║
║     ░░░ │ │                 ├─ Text                             │   │ ░░░   ║
║     ░░░ │ │                 ├─ Integer                          │   │ ░░░   ║
║     ░░░ │ │                 ├─ Decimal                          │   │ ░░░   ║
║     ░░░ │ │                 ├─ Boolean                          │   │ ░░░   ║
║     ░░░ │ │                 ├─ Date                             │   │ ░░░   ║
║     ░░░ │ │                 ├─ DateTime                         │   │ ░░░   ║
║     ░░░ │ │                 ├─ Select (Dropdown)                │   │ ░░░   ║
║     ░░░ │ │                 ├─ Multi-Select                     │   │ ░░░   ║
║     ░░░ │ │                 └─ JSON                             │   │ ░░░   ║
║     ░░░ │ │ Category:       [Hardware Specifications ▼]        │   │ ░░░   ║
║     ░░░ │ │                 ├─ Hardware Specifications          │   │ ░░░   ║
║     ░░░ │ │                 ├─ Business Information             │   │ ░░░   ║
║     ░░░ │ │                 ├─ Location Information             │   │ ░░░   ║
║     ░░░ │ │                 ├─ Performance Metrics              │   │ ░░░   ║
║     ░░░ │ │                 └─ [+ Create New Category]          │   │ ░░░   ║
║     ░░░ │ │ Unit:           [cores                  ]           │   │ ░░░   ║
║     ░░░ │ │ Description:    [Total CPU cores in system...]    │   │ ░░░   ║
║     ░░░ │ │ Required:       ☑️ This field is required          │   │ ░░░   ║
║     ░░░ │ └─────────────────────────────────────────────────────┘   │ ░░░   ║
║     ░░░ │                                                           │ ░░░   ║
║     ░░░ │ 🔄 Data Collection                                        │ ░░░   ║
║     ░░░ │ ┌─────────────────────────────────────────────────────┐   │ ░░░   ║
║     ░░░ │ │ Method: ◉ Agent  ○ SNMP  ○ Manual  ○ Calculated    │   │ ░░░   ║
║     ░░░ │ │                                                     │   │ ░░░   ║
║     ░░░ │ │ Agent Configuration:                                │   │ ░░░   ║
║     ░░░ │ │ Source Path:   [system_info.hardware.cpu.cores]    │   │ ░░░   ║
║     ░░░ │ │ Collection Frequency: [Every 24 hours ▼]           │   │ ░░░   ║
║     ░░░ │ │ Transform:     [value                     ] (JS)    │   │ ░░░   ║
║     ░░░ │ │                                                     │   │ ░░░   ║
║     ░░░ │ │ SNMP Configuration: (disabled when Agent selected) │   │ ░░░   ║
║     ░░░ │ │ OID:           [1.3.6.1.4.1.2021.11.9.0  ]         │   │ ░░░   ║
║     ░░░ │ │ Transform:     [value / 100               ] (JS)    │   │ ░░░   ║
║     ░░░ │ │                                                     │   │ ░░░   ║
║     ░░░ │ │ Calculated Configuration: (when Calculated)        │   │ ░░░   ║
║     ░░░ │ │ Formula:       [(cpu_score + ram_score)/2 ] (JS)   │   │ ░░░   ║
║     ░░░ │ │ Dependencies:  [cpu_cores, ram_total      ]        │   │ ░░░   ║
║     ░░░ │ └─────────────────────────────────────────────────────┘   │ ░░░   ║
║     ░░░ │                                                           │ ░░░   ║
║     ░░░ │ ✅ Validation                                             │ ░░░   ║
║     ░░░ │ ┌─────────────────────────────────────────────────────┐   │ ░░░   ║
║     ░░░ │ │ Minimum Value: [1              ] (numeric types)    │   │ ░░░   ║
║     ░░░ │ │ Maximum Value: [128            ]                    │   │ ░░░   ║
║     ░░░ │ │ Default Value: [4              ]                    │   │ ░░░   ║
║     ░░░ │ │ Regex Pattern: [^[0-9]+$       ] (text types)       │   │ ░░░   ║
║     ░░░ │ │ Max Length:    [               ] (text types)       │   │ ░░░   ║
║     ░░░ │ │ Unique:        ☐ Values must be unique             │   │ ░░░   ║
║     ░░░ │ │                                                     │   │ ░░░   ║
║     ░░░ │ │ Select Options: (for Select/Multi-Select types)    │   │ ░░░   ║
║     ░░░ │ │ [1 Core  ] [2 Cores] [4 Cores] [8 Cores] [+ Add]  │   │ ░░░   ║
║     ░░░ │ └─────────────────────────────────────────────────────┘   │ ░░░   ║
║     ░░░ │                                                           │ ░░░   ║
║     ░░░ │ 👁️ Display Settings                                       │ ░░░   ║
║     ░░░ │ ┌─────────────────────────────────────────────────────┐   │ ░░░   ║
║     ░░░ │ │ Display Order: [1              ]                    │   │ ░░░   ║
║     ░░░ │ │ ☑️ Show in Device List                              │   │ ░░░   ║
║     ░░░ │ │ ☑️ Show in Dashboard                                │   │ ░░░   ║
║     ░░░ │ │ ☑️ Searchable Field                                 │   │ ░░░   ║
║     ░░░ │ │ ☑️ Filterable Field                                 │   │ ░░░   ║
║     ░░░ │ │ ☐ Administrative Only                               │   │ ░░░   ║
║     ░░░ │ │ Column Width:  [120           ] pixels              │   │ ░░░   ║
║     ░░░ │ └─────────────────────────────────────────────────────┘   │ ░░░   ║
║     ░░░ │                                                           │ ░░░   ║
║     ░░░ │       [❌ Cancel] [🧪 Test] [💾 Add Field]               │ ░░░   ║
║     ░░░ └───────────────────────────────────────────────────────────┘ ░░░   ║
║                         ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░         ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Device Type Details View

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Device Types > Windows Desktop                     Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Device Type: Windows Desktop                          [✏️ Edit] [🔄 Sync]    ║
║                                                                              ║
║ ┌─ Basic Information ──────────────────────────────────────────────────────┐ ║
║ │ Name: Windows Desktop              Slug: windows-desktop                 │ ║
║ │ Platform: Windows                  Connection: Agent                     │ ║
║ │ Status: 🟢 Active                  Icon: 🖥️                             │ ║
║ │ Created: 2024-01-10 by Admin       Updated: 2024-09-15 by Admin         │ ║
║ │ Description: Standard Windows desktop/workstation computers             │ ║
║ │ Organizations: 25                  Devices: 1,240                       │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Agent Configuration ────────────────────────────────────────────────────┐ ║
║ │ Default Port: 8080                 Collection Interval: 5 minutes        │ ║
║ │ Heartbeat: 30 seconds              Max Offline: 300 seconds             │ ║
║ │                                                                          │ ║
║ │ Enabled Capabilities:                                                    │ ║
║ │ ✅ System Information  ✅ Performance Monitoring  ✅ File System        │ ║
║ │ ✅ Process Monitoring  ✅ Registry Access         ✅ Software Inventory │ ║
║ │ ✅ Event Log Collection                                                  │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Custom Fields (12 fields) ──────────────────────────────────────────────┐ ║
║ │                                                                          │ ║
║ │ 🔧 Hardware Specifications (4 fields)                    [+ Add Field]   │ ║
║ │ ├─ CPU Cores (Integer)           Agent    Required  ✅ Show in List      │ ║
║ │ │  Source: system_info.hardware.cpu.cores                               │ ║
║ │ │  Range: 1-128, Default: 4, Collection: Every 24 hours                │ ║
║ │ │                                                                        │ ║
║ │ ├─ RAM Total (Integer)           Agent    Required  ✅ Show in List      │ ║
║ │ │  Source: system_info.hardware.memory.total_gb                         │ ║
║ │ │  Unit: GB, Range: 1-1024, Default: 8                                  │ ║
║ │ │                                                                        │ ║
║ │ ├─ Storage Type (Select)         Agent    Optional  ✅ Show in List      │ ║
║ │ │  Source: system_info.storage.primary.type                             │ ║
║ │ │  Options: HDD, SSD, NVMe, Hybrid                                      │ ║
║ │ │                                                                        │ ║
║ │ └─ Graphics Card (Text)          Manual   Optional  ❌ Hidden           │ ║
║ │    Max Length: 100, Pattern: [A-Za-z0-9\s\-]+                          │ ║
║ │                                                                          │ ║
║ │ 🏢 Business Information (5 fields)                       [+ Add Field]   │ ║
║ │ ├─ Department (Select)           Manual   Required  ✅ Show in List      │ ║
║ │ │  Options: IT, HR, Finance, Sales, Marketing, Operations               │ ║
║ │ │                                                                        │ ║
║ │ ├─ Cost Center (Text)            Manual   Optional  ❌ Hidden           │ ║
║ │ │  Max Length: 50, Pattern: [A-Z]{2,3}-[0-9]{4}                        │ ║
║ │ │                                                                        │ ║
║ │ ├─ Asset Tag (Text)              Manual   Required  ✅ Show in List      │ ║
║ │ │  Max Length: 20, Unique: Yes                                          │ ║
║ │ │                                                                        │ ║
║ │ ├─ Purchase Date (Date)          Manual   Optional  ❌ Hidden           │ ║
║ │ │  Format: YYYY-MM-DD, Range: 2020-2030                                 │ ║
║ │ │                                                                        │ ║
║ │ └─ Warranty Expiry (Date)       Manual   Optional  ❌ Hidden           │ ║
║ │    Format: YYYY-MM-DD, Auto-calculated from Purchase Date              │ ║
║ │                                                                          │ ║
║ │ 📍 Location Information (3 fields)                       [+ Add Field]   │ ║
║ │ ├─ Building (Select)             Manual   Required  ✅ Show in List      │ ║
║ │ │  Options: Main Office, Branch A, Branch B, Remote                     │ ║
║ │ │                                                                        │ ║
║ │ ├─ Floor (Text)                  Manual   Optional  ❌ Hidden           │ ║
║ │ │  Max Length: 20, Examples: "2nd Floor", "Basement"                    │ ║
║ │ │                                                                        │ ║
║ │ └─ Room (Text)                   Manual   Optional  ❌ Hidden           │ ║
║ │    Max Length: 50, Examples: "Conference Room A", "Cubicle 25"         │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Usage Statistics ───────────────────────────────────────────────────────┐ ║
║ │ Organizations Using This Type: 25/25 (100%)                             │ ║
║ │ Total Devices: 1,240                                                    │ ║
║ │ └─ Acme Corp: 150 devices      └─ TechCorp: 89 devices                  │ ║
║ │ └─ BuildCo: 45 devices         └─ Others: 956 devices                   │ ║
║ │                                                                          │ ║
║ │ Field Completion Rates:                                                  │ ║
║ │ ├─ Required Fields: 98.5% (1,221/1,240)                                │ ║
║ │ ├─ Optional Fields: 67.3% (835/1,240)                                   │ ║
║ │ └─ Agent Collection: 99.2% (1,230/1,240)                               │ ║
║ │                                                                          │ ║
║ │ Last Sync: 2024-09-15 14:30 UTC                                        │ ║
║ │ Pending Changes: None                                                    │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Module Field Specifications

### Core Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `name` | String | ✅ | - | Max 100 chars, alphanumeric + spaces |
| `slug` | String | ✅ | auto-generated | Unique, lowercase, hyphenated |
| `platform` | Enum | ✅ | - | Windows, Linux, macOS, Generic, Other |
| `connection_type` | Enum | ✅ | Agent | Agent, SNMP, Both |
| `icon` | String | ❌ | 🖥️ | Unicode emoji or icon class |
| `description` | Text | ❌ | - | Max 500 chars |
| `status` | Enum | ✅ | Active | Active, Draft, Deprecated |

### Agent Configuration Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `agent_port` | Integer | ❌ | 8080 | 1024-65535 |
| `collection_interval` | Integer | ❌ | 5 | 1-1440 minutes |
| `heartbeat_interval` | Integer | ❌ | 30 | 10-300 seconds |
| `max_offline_duration` | Integer | ❌ | 300 | 60-3600 seconds |
| `capabilities` | JSON | ❌ | {} | Predefined capability set |

### SNMP Configuration Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `snmp_version` | Enum | ❌ | v2c | v1, v2c, v3 |
| `default_community` | String | ❌ | public | Max 50 chars |
| `default_port` | Integer | ❌ | 161 | 1-65535 |
| `poll_interval` | Integer | ❌ | 30 | 10-3600 seconds |
| `timeout` | Integer | ❌ | 5 | 1-60 seconds |
| `retries` | Integer | ❌ | 3 | 0-10 |

### Custom Field Definition Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `field_name` | String | ✅ | - | Max 50 chars, snake_case |
| `display_name` | String | ❌ | field_name | Max 100 chars |
| `field_type` | Enum | ✅ | - | text, integer, decimal, boolean, date, datetime, select, multi_select, json |
| `category` | String | ✅ | - | Predefined or custom category |
| `unit` | String | ❌ | - | Max 20 chars |
| `description` | Text | ❌ | - | Max 200 chars |
| `required` | Boolean | ❌ | false | - |
| `collection_method` | Enum | ✅ | - | agent, snmp, manual, calculated |
| `agent_source` | String | ❌ | - | JSON path notation |
| `snmp_oid` | String | ❌ | - | Valid OID format |
| `transform_script` | Text | ❌ | - | JavaScript code |
| `validation_rules` | JSON | ❌ | {} | Type-specific validation |
| `display_settings` | JSON | ❌ | {} | UI display preferences |

### Menu Structure
```
Device Types
├── List View
│   ├── Search & Filters
│   ├── Create New Device Type
│   ├── Bulk Actions
│   └── Statistics
├── Create/Edit Device Type
│   ├── Basic Information
│   ├── Agent Configuration
│   ├── SNMP Configuration
│   └── Custom Fields
│       ├── Field Categories
│       ├── Add Field
│       ├── Edit Field
│       └── Field Ordering
├── Device Type Details
│   ├── Overview
│   ├── Configuration
│   ├── Custom Fields List
│   ├── Usage Statistics
│   └── Sync Status
└── Field Management
    ├── Field Categories
    ├── Field Types
    ├── Validation Rules
    └── Collection Methods
```

This module provides comprehensive device type management with extensive custom field capabilities, enabling organizations to define exactly what information they need to collect for each type of device in their infrastructure.

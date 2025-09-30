# Manager UI - Organizations Module

This document provides comprehensive UI mockups and field specifications for the Organizations management module in the Manager UI.

## Module Overview

**Module**: Organizations Management
**Access Level**: System Administrators
**Purpose**: Create and manage tenant organizations
**Location**: Manager UI → Organizations

## Main Organizations List Page

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Organizations                                       Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Organizations Management                                  [+ Create New Org] ║
║                                                                              ║
║ ┌─ Search & Filters ───────────────────────────────────────────────────────┐ ║
║ │ Search: [                            ] [🔍]  Status: [All ▼]            │ ║
║ │ Devices: [Any ▼]  Users: [Any ▼]  Created: [All Time ▼]  [🔄 Refresh]  │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Quick Stats:  Total: 25  │  Active: 22  │  Warning: 2  │  Error: 1       │ ║
║ │ Devices: 2,503  │  Users: 187  │  Storage: 1.2TB  │  Daily Jobs: 1,247   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Name                Status   Devices Users  Storage  Created     Actions │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🏢 Acme Corporation                                                      │ ║
║ │   acme-corp          🟢 Active   150    25   156.7MB  2024-01-15 [👁️][✏️][⚙️]│ ║
║ │   Database: rmas_org_acme_corp                                           │ ║
║ │   Domain: acme.com | Last Activity: 2 minutes ago                       │ ║
║ │   Admin: john.doe@acme.com | Device Groups: 8 | Job Templates: 12       │ ║
║ │                                                                          │ ║
║ │ 🏭 TechCorp Inc                                                          │ ║
║ │   techcorp-inc       🟢 Active    89    12    89.2MB  2024-02-01 [👁️][✏️][⚙️]│ ║
║ │   Database: rmas_org_techcorp_inc                                        │ ║
║ │   Domain: techcorp.com | Last Activity: 5 minutes ago                   │ ║
║ │   Admin: admin@techcorp.com | Device Groups: 5 | Job Templates: 8       │ ║
║ │                                                                          │ ║
║ │ 🏗️ BuildCo Ltd                                                           │ ║
║ │   buildco-ltd        🟡 Warning   45     8    45.8MB  2024-01-20 [👁️][✏️][⚙️]│ ║
║ │   Database: rmas_org_buildco_ltd                                         │ ║
║ │   Domain: buildco.net | ⚠️ No activity for 2 hours                       │ ║
║ │   Admin: it@buildco.net | Device Groups: 3 | Job Templates: 4           │ ║
║ │                                                                          │ ║
║ │ 🏪 RetailMax                                                             │ ║
║ │   retailmax          🟢 Active    67    15    67.3MB  2024-03-10 [👁️][✏️][⚙️]│ ║
║ │   Database: rmas_org_retailmax                                           │ ║
║ │   Domain: retailmax.com | Last Activity: 1 minute ago                   │ ║
║ │   Admin: sysadmin@retailmax.com | Device Groups: 6 | Job Templates: 9   │ ║
║ │                                                                          │ ║
║ │ 🏦 FinanceFirst                                                          │ ║
║ │   financefirst       🔴 Error      0     3     0.1MB  2024-03-01 [👁️][✏️][⚙️]│ ║
║ │   Database: rmas_org_financefirst                                        │ ║
║ │   Domain: financefirst.org | ❌ Database connection failed               │ ║
║ │   Admin: admin@financefirst.org | Device Groups: 0 | Job Templates: 0   │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Bulk Actions ───────────────────────────────────────────────────────────┐ ║
║ │ ☐ Select All  [📧 Email All Admins] [🔄 Sync Device Types] [📊 Export]   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ Showing 5 of 25 organizations                           « Previous | Next » ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Create Organization Form

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║                        ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░           ║
║     ░░░ ┌──────────────────────────────────────────────────────────┐ ░░░     ║
║     ░░░ │                   Create Organization                    │ ░░░     ║
║     ░░░ ├──────────────────────────────────────────────────────────┤ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 🏢 Organization Information                              │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ Organization Name:  [Acme Corporation     ] *Required│   │ ░░░     ║
║     ░░░ │ │ Display Name:       [Acme Corp           ]          │   │ ░░░     ║
║     ░░░ │ │ Slug:               [acme-corp           ] (auto)   │   │ ░░░     ║
║     ░░░ │ │ Domain:             [acme.com            ]          │   │ ░░░     ║
║     ░░░ │ │ Website:            [https://acme.com    ]          │   │ ░░░     ║
║     ░░░ │ │ Industry:           [Technology ▼        ]          │   │ ░░░     ║
║     ░░░ │ │ Size:               [Medium (50-500) ▼   ]          │   │ ░░░     ║
║     ░░░ │ │ Country:            [United States ▼     ]          │   │ ░░░     ║
║     ░░░ │ │ Timezone:           [America/New_York ▼  ]          │   │ ░░░     ║
║     ░░░ │ │ Language:           [English ▼           ]          │   │ ░░░     ║
║     ░░░ │ │ Currency:           [USD ▼               ]          │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 📞 Contact Information                                   │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ Primary Contact:    [John Doe            ]          │   │ ░░░     ║
║     ░░░ │ │ Contact Email:      [contact@acme.com    ]          │   │ ░░░     ║
║     ░░░ │ │ Support Email:      [support@acme.com    ]          │   │ ░░░     ║
║     ░░░ │ │ Phone:              [+1-555-123-4567     ]          │   │ ░░░     ║
║     ░░░ │ │ Address Line 1:     [123 Business Street ]          │   │ ░░░     ║
║     ░░░ │ │ Address Line 2:     [Suite 100           ]          │   │ ░░░     ║
║     ░░░ │ │ City:               [New York            ]          │   │ ░░░     ║
║     ░░░ │ │ State/Province:     [New York            ]          │   │ ░░░     ║
║     ░░░ │ │ Postal Code:        [10001               ]          │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 👤 Default Admin User                                    │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ Username:           [john.doe            ] *Required│   │ ░░░     ║
║     ░░░ │ │ Email:              [john.doe@acme.com   ] *Required│   │ ░░️     ║
║     ░░░ │ │ First Name:         [John                ]          │   │ ░░░     ║
║     ░░░ │ │ Last Name:          [Doe                 ]          │   │ ░░░     ║
║     ░░░ │ │ Job Title:          [IT Manager          ]          │   │ ░░░     ║
║     ░░░ │ │ Phone:              [+1-555-123-4568     ]          │   │ ░░░     ║
║     ░░░ │ │ Password:           [••••••••••••••••••••] (generated)│   │ ░░░     ║
║     ░░░ │ │ ☑️ Send welcome email with login details           │   │ ░░░     ║
║     ░░░ │ │ ☑️ Require password change on first login          │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ ⚙️ Configuration Options                                 │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ ☑️ Copy device types from default template         │   │ ░░░     ║
║     ░░░ │ │ ☑️ Create default device groups                    │   │ ░░░     ║
║     ░░░ │ │ ☑️ Setup default job templates                     │   │ ░░░     ║
║     ░░░ │ │ ☑️ Enable all monitoring features                  │   │ ░░░     ║
║     ░░░ │ │ ☑️ Setup default alert rules                       │   │ ░░░     ║
║     ░░░ │ │ ☐ Enable trial mode (30 days)                     │   │ ░░░     ║
║     ░░░ │ │                                                    │   │ ░░░     ║
║     ░░░ │ │ Database Name:      [rmas_org_acme_corp  ] (auto)  │   │ ░░░     ║
║     ░░░ │ │ Storage Limit:      [1 GB ▼             ]          │   │ ░░░     ║
║     ░░░ │ │ Device Limit:       [500 ▼              ]          │   │ ░░░     ║
║     ░░░ │ │ User Limit:         [50 ▼               ]          │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 📅 Billing Information                                   │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ Plan:               [Professional ▼     ]          │   │ ░░░     ║
║     ░░░ │ │ Billing Email:      [billing@acme.com   ]          │   │ ░░░     ║
║     ░░░ │ │ Billing Address:    ☑️ Same as organization       │   │ ░░░     ║
║     ░░░ │ │ Payment Terms:      [Net 30 ▼           ]          │   │ ░░░     ║
║     ░░░ │ │ Contract Start:     [2024-10-01 📅       ]          │   │ ░░░     ║
║     ░░░ │ │ Contract End:       [2025-09-30 📅       ]          │   │ ░░░     ║
║     ░░░ │ │ Auto-renew:         ☑️ Automatically renew         │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │          [❌ Cancel] [🧪 Validate] [💾 Create]          │ ░░░     ║
║     ░░░ └──────────────────────────────────────────────────────────┘ ░░░     ║
║                        ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░           ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Organization Details View

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Organizations > Acme Corporation               Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Organization: Acme Corporation                     [✏️ Edit] [🔄 Sync] [⚠️]  ║
║                                                                              ║
║ ┌─ Overview ───────────────────────────────────────────────────────────────┐ ║
║ │ Status: 🟢 Active                  Last Activity: 2 minutes ago           │ ║
║ │ Created: 2024-01-15 by Admin       Database: rmas_org_acme_corp           │ ║
║ │ Domain: acme.com                   Slug: acme-corp                        │ ║
║ │ Timezone: America/New_York         Language: English                     │ ║
║ │                                                                          │ ║
║ │ Contact: John Doe (john.doe@acme.com)                                    │ ║
║ │ Address: 123 Business Street, Suite 100, New York, NY 10001             │ ║
║ │ Phone: +1-555-123-4567            Industry: Technology                   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Resource Usage ─────────────────────────────────────────────────────────┐ ║
║ │                                                                          │ ║
║ │ 📱 Devices: 150/500 (30%) ████████░░░░░░░░░░                           │ ║
║ │ ├─ Online: 149 (99.3%)      ├─ Windows: 89       ├─ Servers: 12         │ ║
║ │ ├─ Offline: 1 (0.7%)        ├─ Linux: 45         ├─ Workstations: 67    │ ║
║ │ └─ Warning: 0 (0%)          └─ macOS: 16         └─ Network: 71          │ ║
║ │                                                                          │ ║
║ │ 👥 Users: 25/50 (50%) ████████████░░░░░░░░░░                            │ ║
║ │ ├─ Admins: 3               ├─ Active: 23         ├─ Last 7 days: 21     │ ║
║ │ ├─ Managers: 8             ├─ Inactive: 2        ├─ Last 30 days: 25    │ ║
║ │ └─ Users: 14               └─ Locked: 0          └─ Never: 0             │ ║
║ │                                                                          │ ║
║ │ 💾 Storage: 156.7MB/1GB (15.3%) ███░░░░░░░░░░░░░░░░░                     │ ║
║ │ ├─ Database: 89.2MB         ├─ Logs: 45.8MB      ├─ Growth: +2.3MB/day  │ ║
║ │ ├─ Files: 12.4MB           ├─ Backups: 9.3MB    ├─ Est. Full: 18 months │ ║
║ │ └─ Cache: 0.8MB            └─ Other: 0.2MB      └─ Last Cleanup: Today  │ ║
║ │                                                                          │ ║
║ │ 🔧 Jobs: 1,247 executed (last 30 days)                                  │ ║
║ │ ├─ Success: 1,221 (98.0%)   ├─ Templates: 12     ├─ Avg Duration: 3.2m  │ ║
║ │ ├─ Failed: 18 (1.4%)        ├─ Scheduled: 156    ├─ Peak Hours: 14-16   │ ║
║ │ └─ Timeout: 8 (0.6%)        └─ Manual: 1,091     └─ Daily Avg: 41.6     │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Device Groups (8) ──────────────────────────────────────────────────────┐ ║
║ │ Group Name           Type              Devices  Status    Last Updated   │ ║
║ │ ──────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️ IT Servers        Linux Server        12    🟢 Active  2 days ago     │ ║
║ │ 💻 HR Workstations   Windows Desktop     25    🟢 Active  1 week ago     │ ║
║ │ 🌐 Network Devices   Network Device       8    🟢 Active  3 days ago     │ ║
║ │ 🖨️ Office Printers   Network Printer     6    🟡 Warning 1 month ago    │ ║
║ │ 📱 Mobile Devices    Mobile Device       16    🟢 Active  5 days ago     │ ║
║ │ 💻 Dev Workstations  Linux Desktop       23    🟢 Active  2 days ago     │ ║
║ │ 🖥️ Prod Servers      Linux Server        45    🟢 Active  1 day ago      │ ║
║ │ 🔧 Infrastructure    Various              15    🟢 Active  6 days ago     │ ║
║ │                                                           [View All →]   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Recent Activity ────────────────────────────────────────────────────────┐ ║
║ │ 14:32  🖥️ Device WIN-SRV-001 status changed to Online                   │ ║
║ │ 14:30  🔧 Job "System Health Check" completed on 12 devices (100% success)│ ║
║ │ 14:25  👤 User jane.smith logged in from 192.168.1.50                   │ ║
║ │ 14:20  📊 Custom field collection completed for 89 devices              │ ║
║ │ 14:15  🚨 Alert "High CPU Usage" resolved on SERVER-03                  │ ║
║ │ 14:10  🔄 SNMP discovery found 2 new network devices                    │ ║
║ │ 14:05  💾 Automatic database backup completed (89.2MB)                  │ ║
║ │ 14:00  📋 Job template "Security Updates" scheduled for Sunday 03:00    │ ║
║ │                                                           [View All →]   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ System Health ──────────────────────────────────────────────────────────┐ ║
║ │ Overall Status: 🟢 Healthy                                               │ ║
║ │                                                                          │ ║
║ │ Database Performance:   🟢 Good (45ms avg query time)                   │ ║
║ │ API Response Time:      🟢 Excellent (89ms avg)                         │ ║
║ │ Background Jobs:        🟢 Processing normally (3 queued)               │ ║
║ │ Disk I/O:              🟢 Normal (12% utilization)                      │ ║
║ │ Memory Usage:           🟢 Optimal (67% used)                           │ ║
║ │ Active Connections:     🟢 Normal (23/100 database, 45/200 agent)       │ ║
║ │                                                                          │ ║
║ │ Last Health Check: 2024-09-30 14:32 UTC                                │ ║
║ │ Next Scheduled Check: 2024-09-30 15:32 UTC                             │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Quick Actions ──────────────────────────────────────────────────────────┐ ║
║ │ [🔄 Sync Device Types] [📊 Generate Report] [💾 Backup Now] [🚨 Test Alerts]│ ║
║ │ [👤 Add User] [🖥️ View Devices] [📋 View Jobs] [⚙️ Organization Settings] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Organization Settings Form

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║                    ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░         ║
║   ░░░ ┌────────────────────────────────────────────────────────────┐ ░░░   ║
║   ░░░ │                Organization Settings                       │ ░░░   ║
║   ░░░ ├────────────────────────────────────────────────────────────┤ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 📋 Navigation                                              │ ░░░   ║
║   ░░░ │ [🏢 General] [📞 Contact] [👤 Admin] [⚙️ Config] [💾 Backup] │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 🏢 General Information                                     │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Organization Name:  [Acme Corporation     ]          │   │ ░░░   ║
║   ░░░ │ │ Display Name:       [Acme Corp           ]          │   │ ░░░   ║
║   ░░░ │ │ Slug:               [acme-corp           ] (readonly)│   │ ░░░   ║
║   ░░░ │ │ Domain:             [acme.com            ]          │   │ ░░░   ║
║   ░░░ │ │ Website:            [https://acme.com    ]          │   │ ░░░   ║
║   ░░░ │ │ Industry:           [Technology ▼        ]          │   │ ░░░   ║
║   ░░░ │ │ Size:               [Medium (50-500) ▼   ]          │   │ ░░░   ║
║   ░░░ │ │ Country:            [United States ▼     ]          │   │ ░░░   ║
║   ░░░ │ │ Timezone:           [America/New_York ▼  ]          │   │ ░░░   ║
║   ░░░ │ │ Language:           [English ▼           ]          │   │ ░░░   ║
║   ░░░ │ │ Currency:           [USD ▼               ]          │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 🎨 Branding                                                │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Logo:               [Choose File...] [Preview]       │   │ ░░░   ║
║   ░░░ │ │ Primary Color:      [#1976D2] ███                   │   │ ░░░   ║
║   ░░░ │ │ Secondary Color:    [#424242] ███                   │   │ ░░░   ║
║   ░░░ │ │ Accent Color:       [#FF9800] ███                   │   │ ░░░   ║
║   ░░░ │ │ Custom CSS:         [Advanced styling options...]   │   │ ░░░   ║
║   ░░░ │ │ Theme:              ◉ Light  ○ Dark  ○ Auto        │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 📈 Limits & Quotas                                         │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Device Limit:       [500              ] (current: 150)│   │ ░░░   ║
║   ░░░ │ │ User Limit:         [50               ] (current: 25) │   │ ░░░   ║
║   ░░░ │ │ Storage Limit:      [1 GB             ] (used: 156MB)│   │ ░░░   ║
║   ░░░ │ │ API Rate Limit:     [1000             ] requests/min │   │ ░░░   ║
║   ░░░ │ │ Job Concurrency:    [10               ] parallel jobs│   │ ░░░   ║
║   ░░░ │ │ Retention Period:   [90               ] days         │   │ ░░░   ║
║   ░░░ │ │ ☑️ Enforce limits strictly                          │   │ ░░░   ║
║   ░░░ │ │ ☑️ Send warnings at 80% capacity                   │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 🔐 Security Settings                                       │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ ☑️ Require MFA for admins                           │   │ ░░░   ║
║   ░░░ │ │ ☑️ Enable audit logging                             │   │ ░░░   ║
║   ░░░ │ │ ☑️ Force HTTPS                                      │   │ ░░░   ║
║   ░░░ │ │ ☐ Allow API access                                  │   │ ░░░   ║
║   ░░░ │ │ ☑️ IP whitelist restrictions                        │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Session Timeout:    [240             ] minutes       │   │ ░░░   ║
║   ░░░ │ │ Password Policy:    [Strong ▼        ]              │   │ ░░░   ║
║   ░░░ │ │ Login Attempts:     [5               ] max failures │   │ ░░░   ║
║   ░░░ │ │ Account Lockout:    [30              ] minutes      │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 📧 Notifications                                           │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ SMTP Server:        [smtp.acme.com   ]              │   │ ░░️   ║
║   ░░░ │ │ SMTP Port:          [587             ]              │   │ ░░░   ║
║   ░░░ │ │ SMTP Username:      [noreply@acme.com]              │   │ ░░░   ║
║   ░░░ │ │ SMTP Password:      [••••••••••••••••]              │   │ ░░░   ║
║   ░░░ │ │ From Name:          [RMAS - Acme Corp]              │   │ ░░░   ║
║   ░░░ │ │ From Email:         [noreply@acme.com]              │   │ ░░░   ║
║   ░░░ │ │ ☑️ Enable email notifications                       │   │ ░░░   ║
║   ░░░ │ │ ☑️ Send system alerts                               │   │ ░░░   ║
║   ░░░ │ │ [🧪 Test Email Connection]                          │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │        [❌ Cancel] [🔄 Reset] [💾 Save Changes]            │ ░░░   ║
║   ░░░ └────────────────────────────────────────────────────────────┘ ░░░   ║
║                    ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░         ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Database Management Panel

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ Database Management: rmas_org_acme_corp                           [✕ Close] ║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ 💾 Database Status                                                           ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Status: 🟢 Online                  Connection: Active (23 connections)    │ ║
║ │ Size: 89.2 MB                      Tables: 47                            │ ║
║ │ Last Backup: 2024-09-30 02:00      Last Vacuum: 2024-09-29 03:00        │ ║
║ │ Query Performance: 45ms avg        Slow Queries: 2 (last 24h)           │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ 📊 Storage Breakdown                                                         ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Table Name                    Size      Rows       Growth (30d)  Indexes │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ devices                      15.2 MB      150      +2.1 MB         7    │ ║
║ │ device_custom_fields         12.8 MB    1,247      +1.8 MB         4    │ ║
║ │ jobs                         11.5 MB    3,456      +3.2 MB         5    │ ║
║ │ job_executions               9.7 MB     8,234      +2.8 MB         6    │ ║
║ │ agent_data                   8.4 MB    12,567      +4.1 MB         3    │ ║
║ │ snmp_data                    6.8 MB     5,432      +1.5 MB         4    │ ║
║ │ alerts                       5.2 MB     2,134      +0.9 MB         3    │ ║
║ │ users                        3.1 MB        25      +0.1 MB         2    │ ║
║ │ device_groups                2.3 MB         8      +0.0 MB         2    │ ║
║ │ Other tables                14.2 MB     8,945      +1.3 MB        28    │ ║
║ │                                                                          │ ║
║ │ Total Data: 89.2 MB         Total Indexes: 24.1 MB   Growth: +17.8 MB   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ 🔧 Maintenance Operations                                                    ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ [💾 Backup Now]     [🗜️ Vacuum]       [📊 Analyze]      [🔍 Check]       │ ║
║ │ [♻️ Cleanup Logs]   [📈 Reindex]      [🧹 Purge Old]   [📋 Query Log]    │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ 📈 Performance Metrics (Last 24 Hours)                                      ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Queries per Hour:                                                        │ ║
║ │ 1000 ┼─────────────────────────────────────────────────────────────      │ ║
║ │      │         ╭─╮                              ╭─╮                      │ ║
║ │  800 ┼─────────│ │──────────────────────────────│ │──────────────────    │ ║
║ │      │       ╭─╯ ╰─╮                          ╭─╯ ╰─╮                    │ ║
║ │  600 ┼───────╯     ╰─────────────────────────╯     ╰────────────────    │ ║
║ │      │                                                                  │ ║
║ │  400 ┼──────────────────────────────────────────────────────────────    │ ║
║ │      └───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬─      │ ║
║ │         00  02  04  06  08  10  12  14  16  18  20  22  24  02  04       │ ║
║ │                                                                          │ ║
║ │ Peak Hours: 09:00-10:00 (987 queries)  │  Slow Queries: 14:32, 16:45    │ ║
║ │ Avg Response: 45ms                      │  Lock Waits: 3 (total 2.1s)   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ⚠️ Recommendations                                                           ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ • Consider adding index on device_custom_fields.collection_timestamp     │ ║
║ │ • Schedule vacuum for jobs table (fragmentation: 23%)                   │ ║
║ │ • Archive job_executions older than 90 days (currently 1,234 rows)      │ ║
║ │ • Monitor agent_data growth rate (projected full in 8 months)           │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Module Field Specifications

### Core Organization Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `name` | String | ✅ | - | Max 100 chars, unique |
| `display_name` | String | ❌ | name | Max 100 chars |
| `slug` | String | ✅ | auto-generated | Unique, lowercase, hyphenated |
| `domain` | String | ❌ | - | Valid domain format |
| `website` | URL | ❌ | - | Valid URL format |
| `industry` | Enum | ❌ | - | Predefined industry list |
| `size` | Enum | ❌ | - | Small, Medium, Large, Enterprise |
| `country` | String | ❌ | - | ISO country code |
| `timezone` | String | ❌ | UTC | Valid timezone identifier |
| `language` | String | ❌ | English | ISO language code |
| `currency` | String | ❌ | USD | ISO currency code |
| `status` | Enum | ✅ | Active | Active, Suspended, Deleted |

### Contact Information Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `primary_contact` | String | ❌ | - | Max 100 chars |
| `contact_email` | Email | ❌ | - | Valid email format |
| `support_email` | Email | ❌ | - | Valid email format |
| `phone` | String | ❌ | - | International phone format |
| `address_line_1` | String | ❌ | - | Max 100 chars |
| `address_line_2` | String | ❌ | - | Max 100 chars |
| `city` | String | ❌ | - | Max 50 chars |
| `state` | String | ❌ | - | Max 50 chars |
| `postal_code` | String | ❌ | - | Max 20 chars |

### Admin User Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `username` | String | ✅ | - | Max 50 chars, unique within org |
| `email` | Email | ✅ | - | Valid email, unique globally |
| `first_name` | String | ❌ | - | Max 50 chars |
| `last_name` | String | ❌ | - | Max 50 chars |
| `job_title` | String | ❌ | - | Max 100 chars |
| `phone` | String | ❌ | - | International phone format |
| `password` | String | ✅ | auto-generated | Min 12 chars, complex |

### Configuration Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `device_limit` | Integer | ✅ | 100 | 1-10000 |
| `user_limit` | Integer | ✅ | 20 | 1-1000 |
| `storage_limit` | Integer | ✅ | 1024 | MB, 100-100000 |
| `api_rate_limit` | Integer | ✅ | 1000 | Requests per minute |
| `job_concurrency` | Integer | ✅ | 5 | 1-50 |
| `retention_period` | Integer | ✅ | 90 | Days, 7-365 |
| `database_name` | String | ✅ | auto-generated | Valid DB name format |

### Security Settings Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `require_mfa` | Boolean | ✅ | true | - |
| `audit_logging` | Boolean | ✅ | true | - |
| `force_https` | Boolean | ✅ | true | - |
| `api_access` | Boolean | ✅ | false | - |
| `ip_whitelist` | Boolean | ✅ | false | - |
| `session_timeout` | Integer | ✅ | 240 | Minutes, 30-1440 |
| `password_policy` | Enum | ✅ | Strong | Weak, Medium, Strong |
| `login_attempts` | Integer | ✅ | 5 | 3-10 |
| `lockout_duration` | Integer | ✅ | 30 | Minutes, 5-120 |

### Menu Structure
```
Organizations
├── List View
│   ├── Search & Filters
│   ├── Create Organization
│   ├── Bulk Actions
│   └── Quick Stats
├── Create Organization
│   ├── Organization Information
│   ├── Contact Information  
│   ├── Default Admin User
│   ├── Configuration Options
│   └── Billing Information
├── Organization Details
│   ├── Overview
│   ├── Resource Usage
│   ├── Device Groups
│   ├── Recent Activity
│   ├── System Health
│   └── Quick Actions
├── Organization Settings
│   ├── General Information
│   ├── Branding
│   ├── Limits & Quotas
│   ├── Security Settings
│   └── Notifications
└── Database Management
    ├── Database Status
    ├── Storage Breakdown
    ├── Maintenance Operations
    ├── Performance Metrics
    └── Recommendations
```

This module provides comprehensive organization management capabilities, allowing system administrators to create, configure, and monitor tenant organizations with detailed resource tracking and health monitoring.

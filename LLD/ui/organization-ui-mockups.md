# Organization UI Mockups

This document provides detailed mockups and design specifications for the Organization UI interface, which is used by organization administrators and users to manage their devices and monitor their systems.

## Organization UI Overview

The Organization UI is a tenant-specific web application accessible via `/org/{org_slug}/` routes, providing organization-scoped functionality for device management, monitoring, and reporting.

### Design Principles

- **Organization Branding**: Support for custom organization colors/logos
- **Role-based Access**: Different views for admins vs. users
- **Real-time Monitoring**: Live device status and job execution
- **Mobile Responsive**: Full mobile support for field technicians
- **Intuitive Workflow**: Task-oriented interface design

## Organization Login Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║                                                                              ║
║                            [ORG LOGO] Acme Corporation                       ║
║                                  RMAS Portal                                 ║
║                                                                              ║
║    ┌─────────────────────────────────────────────────────────────────────┐   ║
║    │                                                                     │   ║
║    │                         🔐 Sign In                                 │   ║
║    │                                                                     │   ║
║    │    ┌─────────────────────────────────────────────────────────────┐  │   ║
║    │    │ Username                                                    │  │   ║
║    │    │ [john.doe                                            ]      │  │   ║
║    │    └─────────────────────────────────────────────────────────────┘  │   ║
║    │                                                                     │   ║
║    │    ┌─────────────────────────────────────────────────────────────┐  │   ║
║    │    │ Password                                                    │  │   ║
║    │    │ [••••••••••••••••••••••••••••••••••••••••••••••••••]      │  │   ║
║    │    └─────────────────────────────────────────────────────────────┘  │   ║
║    │                                                                     │   ║
║    │    ☐ Remember me for 30 days                                       │   ║
║    │                                                                     │   ║
║    │                      [    Sign In    ]                             │   ║
║    │                                                                     │   ║
║    │                    Forgot Password?                                 │   ║
║    │                                                                     │   ║
║    └─────────────────────────────────────────────────────────────────────┘   ║
║                                                                              ║
║                    Need help? Contact your system administrator              ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Organization Dashboard

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corp    Dashboard    Devices    Jobs    Reports    Settings    John ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║                              Device Overview                                 ║
║                                                                              ║
║ ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐ ┌───────────────┐ ║
║ │ Total Devices   │ │ Online Now      │ │ Jobs Today      │ │ Alerts        │ ║
║ │      150        │ │      149        │ │       45        │ │       2       │ ║
║ │  🖥️💻📱🖨️        │ │   ✅ 99.3%      │ │   ✅ 44 done    │ │   ⚠️ 2 warn   │ ║
║ └─────────────────┘ └─────────────────┘ └─────────────────┘ └───────────────┘ ║
║                                                                              ║
║ ┌────────────────────────────────────┐ ┌─────────────────────────────────────┐ ║
║ │            Recent Activity          │ │              Quick Actions         │ ║
║ │                                    │ │                                     │ ║
║ │ 🔧 Job "System Update" completed   │ │ ┌─────────────────────────────────┐ │ ║
║ │    on WIN-DESKTOP-001              │ │ │  [📤 Deploy Software]           │ │ ║
║ │    5 minutes ago                   │ │ │  [🔍 Run Diagnostics]          │ │ ║
║ │                                    │ │ │  [📊 Generate Report]          │ │ ║
║ │ 🟢 Device LIN-SERVER-045 came     │ │ │  [⚙️  Bulk Configuration]       │ │ ║
║ │    online after maintenance        │ │ └─────────────────────────────────┘ │ ║
║ │    15 minutes ago                  │ │                                     │ ║
║ │                                    │ │ ┌─────────────────────────────────┐ │ ║
║ │ ⚠️  High CPU usage detected on     │ │ │     🎯 Device Groups            │ │ ║
║ │    MAC-LAPTOP-007                  │ │ │                                 │ ║
║ │    1 hour ago                      │ │ │ 🖥️  Servers (45)               │ ║
║ │                                    │ │ │ 💻 Workstations (67)           │ ║
║ │          [View All Activity]       │ │ │ 📱 Mobile (23)                 │ ║
║ │                                    │ │ │ 🖨️  Printers (15)              │ ║
║ └────────────────────────────────────┘ └─────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │                          Device Status Map                               │ ║
║ │                                                                          │ ║
║ │  🏢 Headquarters                  🏭 Manufacturing Plant                  │ ║
║ │  ├── 🖥️  WIN-SRV-001 ✅          ├── 🖥️  LIN-PROD-001 ✅                │ ║
║ │  ├── 🖥️  WIN-SRV-002 ✅          ├── 🖥️  LIN-PROD-002 ⚠️                │ ║
║ │  ├── 💻 Workstations (45) ✅      ├── 🔧 PLC-CTRL-001 ✅                │ ║
║ │  └── 🖨️  Printers (8) ✅          └── 📊 HMI-STATION-001 ✅              │ ║
║ │                                                                          │ ║
║ │  🏪 Retail Store A                🏪 Retail Store B                      │ ║
║ │  ├── 🖥️  POS-TERMINAL-01 ✅       ├── 🖥️  POS-TERMINAL-05 ❌             │ ║
║ │  ├── 🖥️  POS-TERMINAL-02 ✅       ├── 🖥️  POS-TERMINAL-06 ✅             │ ║
║ │  └── 🖨️  RECEIPT-PRINTER ✅       └── 🖨️  RECEIPT-PRINTER ✅             │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Device Management Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corp  > Devices                                               John ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Device Management                                         [+ Register Device] ║
║                                                                              ║
║ ┌─ Filters & Search ───────────────────────────────────────────────────────┐ ║
║ │ Status: [All ▼] Type: [All ▼] Location: [All ▼] Search: [        🔍]    │ ║
║ │ ☐ Show offline only    ☐ Show with alerts    🔄 Auto-refresh: ON        │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Device Name          Type      Status   Location     Last Seen   Actions  │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️  WIN-SRV-001                                                          │ ║
║ │    Domain Controller  Windows   🟢 Online  HQ-Datacenter  2 min   [👁️][⚙️] │ ║
║ │    IP: 192.168.1.10 │ Agent: v2.1.3 │ Jobs: 15 pending               │ ║
║ │    CPU: 15% │ RAM: 8.2GB/16GB │ Disk: 245GB/500GB                    │ ║
║ │                                                                          │ ║
║ │ 🖥️  LIN-PROD-002                                                         │ ║
║ │    Production Server  Linux     ⚠️  Warning  Manufacturing  5 min  [👁️][⚙️] │ ║
║ │    IP: 10.0.1.25 │ Agent: v2.1.3 │ ⚠️  High CPU (85%)                │ ║
║ │    CPU: 85% │ RAM: 7.8GB/8GB │ Disk: 180GB/200GB                     │ ║
║ │                                                                          │ ║
║ │ 💻 MAC-LAPTOP-007                                                        │ ║
║ │    Employee Laptop    macOS     🟢 Online  Remote        1 min    [👁️][⚙️] │ ║
║ │    IP: 203.0.113.45 │ Agent: v2.1.2 │ VPN Connected                  │ ║
║ │    CPU: 45% │ RAM: 4.1GB/8GB │ Disk: 125GB/256GB                     │ ║
║ │                                                                          │ ║
║ │ 🖥️  POS-TERMINAL-05                                                      │ ║
║ │    Point of Sale      Windows   ❌ Offline  Store-B      2 hours  [👁️][⚙️] │ ║
║ │    IP: 192.168.50.15 │ Agent: v2.0.8 │ ❌ Connection lost             │ ║
║ │    Last: CPU: 25% │ RAM: 2.1GB/4GB │ Disk: 89GB/120GB                │ ║
║ │                                                                          │ ║
║ │ 🖨️  PRINTER-MAIN                                                         │ ║
║ │    Network Printer    SNMP      🟢 Online  HQ-Floor2     30 sec   [👁️][⚙️] │ ║
║ │    IP: 192.168.1.50 │ SNMP v2c │ Toner: 45% │ Paper: OK             │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ Showing 5 of 150 devices                              « Previous | Next »   ║
║                                                                              ║
║ Bulk Actions: [📤 Deploy Job] [⚙️ Update Settings] [📊 Export Selected]        ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Device Details Modal

```
╔══════════════════════════════════════════════════════════════════════════════╗
║                                    ░░░░░░░                                   ║
║           ░░░ ┌───────────────────────────────────────────────────┐ ░░░      ║
║           ░░░ │  🖥️  WIN-SRV-001 - Domain Controller        [✕]  │ ░░░      ║
║           ░░░ │ ─────────────────────────────────────────────────── │ ░░░    ║
║           ░░░ │                                                   │ ░░░      ║
║           ░░░ │ 📊 System Information                             │ ░░░      ║
║           ░░░ │ Status:     🟢 Online (2 minutes ago)             │ ░░░      ║
║           ░░░ │ IP Address: 192.168.1.10                          │ ░░░      ║
║           ░░░ │ Agent:      v2.1.3 (Up to date)                   │ ░░░      ║
║           ░░░ │ OS:         Windows Server 2022                   │ ░░░      ║
║           ░░░ │ Hostname:   WIN-SRV-001.acme.local                │ ░░░      ║
║           ░░░ │ Location:   HQ-Datacenter                         │ ░░░      ║
║           ░░░ │                                                   │ ░░░      ║
║           ░░░ │ ⚡ Performance                                     │ ░░░     ║
║           ░░░ │ CPU Usage:   ████░░░░░░ 15% (4 cores)             │ ░░░      ║
║           ░░░ │ Memory:      ████████░░ 8.2GB / 16GB (51%)        │ ░░░      ║
║           ░░░ │ Disk Space:  ████████░░ 245GB / 500GB (49%)       │ ░░░      ║
║           ░░░ │ Network:     📤 15 MB/s  📥 8 MB/s                │ ░░░     ║
║           ░░░ │                                                   │ ░░░      ║
║           ░░░ │ 🔧 Recent Jobs                                    │ ░░░      ║
║           ░░░ │ • Windows Updates         ✅ Completed  2h ago     │ ░░░     ║
║           ░░░ │ • Security Scan           ✅ Completed  6h ago     │ ░░░     ║
║           ░░░ │ • Backup Verification     ⏳ Running    now       │ ░░░      ║
║           ░░░ │                                                   │ ░░░       ║
║           ░░░ │ 📝 Configuration                                  │ ░░░      ║
║           ░░░ │ Device Type: Windows Server                       │ ░░░       ║
║           ░░░ │ Auto-update: ✅ Enabled                           │ ░░░      ║
║           ░░░ │ Monitoring:  ✅ Full monitoring                   │ ░░░      ║
║           ░░░ │                                                   │ ░░░      ║
║           ░░░ │     [📊 View Logs] [⚙️ Configure] [🔧 Run Job]    │ ░░░      ║
║           ░░░ └───────────────────────────────────────────────────┘ ░░░      ║
║                                    ░░░░░░░                                   ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Job Management Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corp  > Jobs                                                  John ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Job Management & Execution                             [+ Create New Job]    ║
║                                                                              ║
║ ┌─ Job Queue Status ───────────────────────────────────────────────────────┐ ║
║ │ ⏳ Pending: 8    🔄 Running: 3    ✅ Completed: 45    ❌ Failed: 2         │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Filters ────────────────────────────────────────────────────────────────┐ ║
║ │ Status: [All ▼] Type: [All ▼] Device: [All ▼] Date: [Today ▼] [🔍]      │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Job Name             Type         Target      Status     Started    Actions│ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🔄 Windows Updates                                                       │ ║
║ │    Security patches   Update       WIN-SRV-*   🔄 Running   2h ago [⏸️][👁️]│ ║
║ │    Progress: 15/23 devices completed │ ETA: 45 minutes                  │ ║
║ │                                                                          │ ║
║ │ 📊 System Diagnostics                                                   │ ║
║ │    Health check      Diagnostic    All Linux   ⏳ Pending  1h ago [▶️][👁️]│ ║
║ │    Scheduled for: 14:30 │ Estimated duration: 20 minutes              │ ║
║ │                                                                          │ ║
║ │ 🛡️  Antivirus Scan                                                       │ ║
║ │    Full system scan   Security     MAC-*       ✅ Complete  3h ago [📋][👁️]│ ║
║ │    Result: 0 threats found │ Scanned: 1,245,678 files                 │ ║
║ │                                                                          │ ║
║ │ 📦 Software Deploy                                                      │ ║
║ │    Install Office 365  Software    Workstations ❌ Failed   4h ago [🔄][👁️]│ ║
║ │    Error: Insufficient disk space on 3 devices                          │ ║
║ │                                                                          │ ║
║ │ 🔧 Registry Cleanup                                                      │ ║
║ │    System cleanup     Maintenance  WIN-DESKTOP* ✅ Complete  5h ago [📋][👁️]│ ║
║ │    Cleaned: 245 MB freed │ Performance improvement: 12%                 │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Quick Job Templates ────────────────────────────────────────────────────┐ ║
║ │ [🔍 System Scan] [🔄 Update All] [🛡️ Security Check] [📊 Generate Report]  │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Reports Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corp  > Reports                                               John ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Reports & Analytics                                     📅 Last 30 days [🔽] ║
║                                                                              ║
║ ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐ ┌───────────────┐ ║
║ │ Device Uptime   │ │ Job Success     │ │ Security Score  │ │ Compliance    │ ║
║ │     99.3%       │ │     97.8%       │ │      92%        │ │     88%       │ ║
║ │   📈 +0.5%      │ │   📈 +2.1%      │ │   📈 +5%        │ │   📉 -2%      │ ║
║ └─────────────────┘ └─────────────────┘ └─────────────────┘ └───────────────┘ ║
║                                                                              ║
║ ┌────────────────────────────────────┐ ┌─────────────────────────────────────┐ ║
║ │          Device Availability        │ │        Job Execution Trends        │ ║
║ │                                    │ │                                     │ ║
║ │ Location       Devices   Uptime    │ │ ┌─ Daily Job Volume ─────────────┐ │ ║
║ │ ──────────────────────────────────  │ │ │    📊                          │ │ ║
║ │ 🏢 Headquarters   78      99.8%    │ │ │  80 ┼──────────╭─╮──────────     │ ║
║ │ 🏭 Manufacturing  45      98.9%    │ │ │     │        ╭─╯ ╰─╮            │ ║
║ │ 🏪 Store A        12      99.1%    │ │ │  60 ┼────────╯     ╰─────       │ ║
║ │ 🏪 Store B        15      96.2%    │ │ │     │                           │ ║
║ │ 🏠 Remote         23      97.5%    │ │ │  40 ┼─────────────────────       │ ║
║ │                                    │ │ │     └─┬──┬──┬──┬──┬──┬──┬─      │ ║
║ │ Lowest: POS-TERMINAL-05 (Store B)  │ │ │      M  T  W  T  F  S  S       │ ║
║ │ Reason: Network connectivity       │ │ └─────────────────────────────────┘ │ ║
║ └────────────────────────────────────┘ └─────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │                          Security & Compliance                          │ ║
║ │                                                                          │ ║
║ │ Category          Status     Last Check   Issues   Trend                 │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🛡️  Antivirus       92% ✅     2 hours       3      📈 Improving         │ ║
║ │ 🔒 OS Updates       88% ⚠️     Daily         18     📈 Improving         │ ║
║ │ 🔐 Password Policy  95% ✅     Weekly         2      📊 Stable           │ ║
║ │ 🔥 Firewall         98% ✅     Daily          1      📊 Stable           │ ║
║ │ 📁 Data Backup      85% ⚠️     Daily         12     📉 Needs Attention  │ ║
║ │ 🚫 USB Restrictions 90% ✅     Weekly         8      📈 Improving         │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Report Actions ─────────────────────────────────────────────────────────┐ ║
║ │ [📊 Export PDF] [📋 Export CSV] [📧 Email Report] [📅 Schedule Report]    │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Organization Settings Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corp  > Settings                                              John ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Organization Settings                                                        ║
║                                                                              ║
║ ┌─ Navigation ─────────────────────────────────────────────────────────────┐ ║
║ │ [🏢 General] [👥 Users] [🔧 Device Types] [🛡️ Security] [🔔 Notifications] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ General Settings ───────────────────────────────────────────────────────┐ ║
║ │                                                                          │ ║
║ │ Organization Information                                                 │ ║
║ │ ──────────────────────────                                              │ ║
║ │ Name:          [Acme Corporation                                    ]    │ ║
║ │ Display Name:  [Acme Corp                                          ]    │ ║
║ │ Domain:        [acme.com                                           ]    │ ║
║ │ Time Zone:     [America/New_York                           ▼]           │ ║
║ │                                                                          │ ║
║ │ Branding                                                                 │ ║
║ │ ────────                                                                 │ ║
║ │ Logo:          [Choose File...] [Preview]                                │ ║
║ │ Primary Color: [#1976D2] ███                                            │ ║
║ │ Custom CSS:    [Advanced styling options...]                            │ ║
║ │                                                                          │ ║
║ │ Contact Information                                                      │ ║
║ │ ──────────────────                                                      │ ║
║ │ Admin Email:   [admin@acme.com                                     ]    │ ║
║ │ Support Phone: [+1-555-123-4567                                   ]    │ ║
║ │ Address:       [123 Business Street                                ]    │ ║
║ │                [New York, NY 10001                                 ]    │ ║
║ │                                                                          │ ║
║ │                                              [Cancel] [Save Changes]    │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## User Management Subpage

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corp  > Settings > Users                                      John ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ User Management                                           [+ Invite User]   ║
║                                                                              ║
║ ┌─ User Roles ─────────────────────────────────────────────────────────────┐ ║
║ │ 👑 Admin: Full access to all features and settings                       │ ║
║ │ 👨‍💼 Manager: Device management, job execution, reporting                  │ ║
║ │ 👤 User: View devices and reports, limited job execution                │ ║
║ │ 👁️  Viewer: Read-only access to devices and reports                      │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Name               Email              Role      Status    Last Login      │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 👤 John Doe                                                              │ ║
║ │    john.doe        john@acme.com     👑 Admin   🟢 Active  2 hours ago    │ ║
║ │    Created: 2024-01-15 │ Login count: 245                [✏️] [🔒]      │ ║
║ │                                                                          │ ║
║ │ 👤 Jane Smith                                                            │ ║
║ │    jane.smith      jane@acme.com     👨‍💼 Manager 🟢 Active  1 day ago      │ ║
║ │    Created: 2024-02-01 │ Login count: 89                 [✏️] [🔒]      │ ║
║ │                                                                          │ ║
║ │ 👤 Bob Wilson                                                            │ ║
║ │    bob.wilson      bob@acme.com      👤 User    🟡 Inactive 1 week ago   │ ║
║ │    Created: 2024-01-20 │ Login count: 34                 [✏️] [🔒]      │ ║
║ │                                                                          │ ║
║ │ 👤 Sarah Johnson                                                         │ ║
║ │    sarah.johnson   sarah@acme.com    👁️ Viewer  🟢 Active  3 hours ago   │ ║
║ │    Created: 2024-03-01 │ Login count: 12                 [✏️] [🔒]      │ ║
║ │                                                                          │ ║
║ │ 👤 Mike Davis                                                            │ ║
║ │    mike.davis      mike@acme.com     👤 User    🔴 Locked  1 month ago   │ ║
║ │    Created: 2023-12-15 │ ❌ Account locked due to failed attempts [🔓]  │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ Active Sessions: 3 │ Total Users: 25 │ Pending Invitations: 2              ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Mobile Responsive Design

### Mobile Dashboard View

```
╔══════════════════════════════════════╗
║ ☰ Acme Corp              John ▼      ║
╠══════════════════════════════════════╣
║                                      ║
║ ┌──────────────────────────────────┐ ║
║ │ Total Devices    Online Now      │ ║
║ │      150           149           │ ║
║ │  🖥️💻📱🖨️         ✅ 99.3%        │ ║
║ └──────────────────────────────────┘ ║
║                                      ║
║ ┌──────────────────────────────────┐ ║
║ │ Jobs Today      Alerts           │ ║
║ │      45           2              │ ║
║ │   ✅ 44 done    ⚠️ 2 warn         │ ║
║ └──────────────────────────────────┘ ║
║                                      ║
║ 🔔 Recent Activity                   ║
║ • Job completed on WIN-001  5m       ║
║ • LIN-045 came online      15m       ║
║ • High CPU on MAC-007       1h       ║
║                                      ║
║ 🎯 Quick Actions                     ║
║ [📤 Deploy] [🔍 Diagnostics]        ║
║ [📊 Report] [⚙️ Configure]           ║
║                                      ║
║ 📱 Device Groups                     ║
║ 🖥️ Servers (45)     [View]          ║
║ 💻 Workstations (67) [View]          ║
║ 📱 Mobile (23)       [View]          ║
║ 🖨️ Printers (15)     [View]          ║
║                                      ║
╚══════════════════════════════════════╝
```

## Color Scheme and Theming

### Organization Color Customization

```
Primary Theme (Default):
- Primary:     #1976D2 (Blue)
- Secondary:   #424242 (Dark Gray)
- Accent:      #FF9800 (Orange)

Custom Organization Themes:
- Acme Corp:   #2E7D32 (Green) + #FFC107 (Yellow)
- TechCorp:    #7B1FA2 (Purple) + #E91E63 (Pink)
- BuildCo:     #D84315 (Red-Orange) + #37474F (Blue-Gray)
```

### Dark Mode Support

```
Dark Theme Colors:
- Background:  #121212
- Surface:     #1E1E1E
- Primary:     #BB86FC
- Secondary:   #03DAC6
- Text:        #FFFFFF
```

## Responsive Breakpoints

```
Mobile:    320px - 767px   (Single column layout)
Tablet:    768px - 1023px  (Two column layout)
Desktop:   1024px - 1439px (Three column layout)
Large:     1440px+         (Four column layout)
```

## Component Specifications

### Status Indicators

- 🟢 Online/Healthy: Green with pulse animation
- 🟡 Warning: Yellow with slow blink
- 🔴 Error/Offline: Red with attention animation
- ⚪ Unknown: Gray static

### Interactive Elements

- Hover effects: 0.2s ease transition
- Click feedback: Ripple effect (Material Design)
- Loading states: Skeleton placeholders
- Error states: Red outline with error message

### Data Tables

- Sortable columns with arrow indicators
- Pagination with "Showing X of Y" info
- Bulk selection with checkboxes
- Row actions on hover
- Responsive collapse on mobile

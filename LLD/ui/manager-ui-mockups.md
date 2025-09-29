# Manager UI Mockups

This document provides detailed mockups and design specifications for the Manager UI interface, which is used by system administrators to manage organizations and global settings.

## Manager UI Overview

The Manager UI is a comprehensive web application built with Laravel and Vue.js components, providing a clean and intuitive interface for system-wide management.

### Design Principles
- **Clean and Modern**: Material Design inspired interface
- **Responsive**: Mobile-first responsive design
- **Intuitive Navigation**: Clear hierarchical navigation
- **Real-time Updates**: Live data updates and notifications
- **Dark/Light Theme**: Support for both themes

## Login Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║                                                                              ║
║                              RMAS Manager Portal                             ║
║                                                                              ║
║    ┌─────────────────────────────────────────────────────────────────────┐   ║
║    │                                                                     │   ║
║    │                         🔐 Manager Login                           │   ║
║    │                                                                     │   ║
║    │    ┌─────────────────────────────────────────────────────────────┐  │   ║
║    │    │ Username                                                    │  │   ║
║    │    │ [admin                                               ]      │  │   ║
║    │    └─────────────────────────────────────────────────────────────┘  │   ║
║    │                                                                     │   ║
║    │    ┌─────────────────────────────────────────────────────────────┐  │   ║
║    │    │ Password                                                    │  │   ║
║    │    │ [••••••••••••••••••••••••••••••••••••••••••••••••••]      │  │   ║
║    │    └─────────────────────────────────────────────────────────────┘  │   ║
║    │                                                                     │   ║
║    │    ☐ Remember me                                                   │   ║
║    │                                                                     │   ║
║    │                      [    Sign In    ]                             │   ║
║    │                                                                     │   ║
║    │                    Forgot Password?                                 │   ║
║    │                                                                     │   ║
║    └─────────────────────────────────────────────────────────────────────┘   ║
║                                                                              ║
║                              v1.2.3 | © 2025 RMAS                           ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Dashboard Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager    Organizations    Device Types    Managers    Analytics   🔔║
║                                                                        Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║                              System Overview                                 ║
║                                                                              ║
║ ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐ ┌───────────────┐ ║
║ │ Organizations   │ │ Total Devices   │ │ Active Agents   │ │ Jobs Today    │ ║
║ │      25         │ │     2,450       │ │     2,380       │ │     145       │ ║
║ │   📈 +2 today   │ │  📊 97% online  │ │   ✅ 97.1%      │ │  ✅ 97.9%     │ ║
║ └─────────────────┘ └─────────────────┘ └─────────────────┘ └───────────────┘ ║
║                                                                              ║
║ ┌────────────────────────────────────┐ ┌─────────────────────────────────────┐ ║
║ │          Recent Activities          │ │           System Health            │ ║
║ │                                    │ │                                     │ ║
║ │ • 🏢 Acme Corp created             │ │ ┌─────────────────────────────────┐ │ ║
║ │   2 hours ago                      │ │ │ API Response Time: 45ms         │ │ ║
║ │                                    │ │ │ Database Connections: 23/100    │ │ ║
║ │ • 🖥️  50 new devices registered    │ │ │ Memory Usage: 2.1GB/4GB        │ │ ║
║ │   Today                            │ │ │ Disk Usage: 156GB/500GB        │ │ ║
║ │                                    │ │ └─────────────────────────────────┘ │ ║
║ │ • 🔧 Device type "Linux Server"    │ │                                     │ ║
║ │   updated                          │ │ 🟢 All systems operational         │ ║
║ │   1 day ago                        │ │                                     │ ║
║ │                                    │ │                                     │ ║
║ │           [View All]               │ │            [Details]               │ ║
║ └────────────────────────────────────┘ └─────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │                          Organization Status                             │ ║
║ │                                                                          │ ║
║ │ Name               Status    Devices   Last Activity    Database         │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🏢 Acme Corporation  🟢 Active   150    2 mins ago      156.7 MB        │ ║
║ │ 🏭 TechCorp Inc     🟢 Active    89     5 mins ago       89.2 MB        │ ║
║ │ 🏗️  BuildCo Ltd     🟡 Warning   45     2 hours ago      45.8 MB        │ ║
║ │ 🏪 RetailMax       🟢 Active    67     1 min ago        67.3 MB        │ ║
║ │ 🏦 FinanceFirst    🔴 Error      0     1 day ago         0.1 MB        │ ║
║ │                                                                          │ ║
║ │                              [View All Organizations]                   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Organizations Management Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Organizations                                       Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Organizations Management                                  [+ Create New Org] ║
║                                                                              ║
║ ┌─ Filters ────────────────────────────────────────────────────────────────┐ ║
║ │ Status: [All ▼]  Search: [                           🔍]  [🔄 Refresh]  │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Name                Status    Devices  Users  Created      Actions       │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🏢 Acme Corporation                                                      │ ║
║ │    acme-corp        🟢 Active   150     25   2024-01-15  [👁️] [✏️] [⚙️]   │ ║
║ │    Database: rmas_org_acme_corp                                          │ ║
║ │    Last Activity: 2 minutes ago                                          │ ║
║ │                                                                          │ ║
║ │ 🏭 TechCorp Inc                                                          │ ║
║ │    techcorp-inc     🟢 Active    89     12   2024-02-01  [👁️] [✏️] [⚙️]   │ ║
║ │    Database: rmas_org_techcorp_inc                                       │ ║
║ │    Last Activity: 5 minutes ago                                          │ ║
║ │                                                                          │ ║
║ │ 🏗️  BuildCo Ltd                                                          │ ║
║ │    buildco-ltd      🟡 Warning   45      8   2024-01-20  [👁️] [✏️] [⚙️]   │ ║
║ │    Database: rmas_org_buildco_ltd                                        │ ║
║ │    ⚠️  No activity for 2 hours                                           │ ║
║ │                                                                          │ ║
║ │ 🏦 FinanceFirst                                                          │ ║
║ │    financefirst     🔴 Error      0      3   2024-03-01  [👁️] [✏️] [⚙️]   │ ║
║ │    Database: rmas_org_financefirst                                       │ ║
║ │    ❌ Database connection failed                                          │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ Showing 4 of 25 organizations                           « Previous | Next » ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Create Organization Modal

```
╔══════════════════════════════════════════════════════════════════════════════╗
║                                    ░░░░░░░                                   ║
║                 ░░░ ┌─────────────────────────────────────────┐ ░░░          ║
║                 ░░░ │            Create Organization          │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │ Organization Name *                     │ ░░░          ║
║                 ░░░ │ [                                 ]     │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │ Slug (URL identifier) *                 │ ░░░          ║
║                 ░░░ │ [                                 ]     │ ░░░          ║
║                 ░░░ │ Will be: /org/your-slug                 │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │ Domain (optional)                       │ ░░░          ║
║                 ░░░ │ [                                 ]     │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │ ─── Default Admin User ───              │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │ Admin Username *                        │ ░░░          ║
║                 ░░░ │ [                                 ]     │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │ Admin Email *                           │ ░░░          ║
║                 ░░░ │ [                                 ]     │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │ ☐ Copy device types from template       │ ░░░          ║
║                 ░░░ │ ☐ Send welcome email to admin           │ ░░░          ║
║                 ░░░ │                                         │ ░░░          ║
║                 ░░░ │              [Cancel] [Create]          │ ░░░          ║
║                 ░░░ └─────────────────────────────────────────┘ ░░░          ║
║                                    ░░░░░░░                                   ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Device Types Management

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Device Types                                       Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Device Type Templates                                   [+ Create Device Type] ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Templates are synchronized to all organizations                          │ ║
║ │ Organizations can customize settings but core template remains here      │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Name              Platform    Orgs   Devices   Last Updated   Actions     │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️  Windows Desktop                                                       │ ║
║ │    windows-desktop  Windows     25     1,240   2024-01-10   [👁️] [✏️] [🔄] │ ║
║ │    Agent monitoring, file operations, registry access                   │ ║
║ │                                                                          │ ║
║ │ 🐧 Linux Server                                                          │ ║
║ │    linux-server     Linux       23       890   2024-01-08   [👁️] [✏️] [🔄] │ ║
║ │    System monitoring, service management, log collection                 │ ║
║ │                                                                          │ ║
║ │ 🍎 macOS Workstation                                                     │ ║
║ │    macos-workstation macOS       12       320   2024-01-05   [👁️] [✏️] [🔄] │ ║
║ │    Application monitoring, brew package management                       │ ║
║ │                                                                          │ ║
║ │ 📡 Network Device                                                        │ ║
║ │    network-device   SNMP          8        45   2024-01-12   [👁️] [✏️] [🔄] │ ║
║ │    SNMP monitoring, network statistics, port status                      │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ Legend: [👁️] View Details  [✏️] Edit  [🔄] Sync to All Organizations         ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## System Analytics Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Analytics                                          Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ System Analytics & Reports                      📅 Last 30 days [🔽] [📊 Export]║
║                                                                              ║
║ ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐ ┌───────────────┐ ║
║ │ Total Orgs      │ │ Total Devices   │ │ Job Success     │ │ Data Storage  │ ║
║ │      25         │ │     2,450       │ │     97.9%       │ │    1.2 TB     │ ║
║ │   📈 +8.3%      │ │   📈 +12.1%     │ │   📈 +2.1%      │ │  📈 +156 GB   │ ║
║ └─────────────────┘ └─────────────────┘ └─────────────────┘ └───────────────┘ ║
║                                                                              ║
║ ┌────────────────────────────────────┐ ┌─────────────────────────────────────┐ ║
║ │        Device Growth Trend          │ │         Job Execution Trend        │ ║
║ │                                    │ │                                     │ ║
║ │    📈                              │ │     📊                              │ ║
║ │   2.5k ┼─────────────────────┐     │ │   200  ┼──────────────────────────   │ ║
║ │        │                    ╱│     │ │        │     ╭─╮         ╭─╮        │ ║
║ │   2.0k ┼─────────────────╱───┘     │ │   150  ┼─────│ │─────────│ │────    │ ║
║ │        │               ╱           │ │        │     │ │       ╭─╯ │        │ ║
║ │   1.5k ┼─────────────╱─            │ │   100  ┼─────╰─╯───────╯   ╰────    │ ║
║ │        │           ╱               │ │        │                            │ ║
║ │   1.0k ┼─────────╱─                │ │    50  ┼─────────────────────────   │ ║
║ │        │       ╱                   │ │        │                            │ ║
║ │        └───┬───┬───┬───┬───┬───┬   │ │        └───┬───┬───┬───┬───┬───┬    │ ║
║ │           W1  W2  W3  W4  W5  W6   │ │           W1  W2  W3  W4  W5  W6    │ ║
║ └────────────────────────────────────┘ └─────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │                     Top Organizations by Activity                        │ ║
║ │                                                                          │ ║
║ │ Organization        Devices   Agents   Jobs/Day   Success Rate   Growth  │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🏢 Acme Corporation   150      149       45        98.2%        📈 +15%  │ ║
║ │ 🏭 TechCorp Inc        89       87       28        97.8%        📈 +8%   │ ║
║ │ 🏪 RetailMax           67       67       22        99.1%        📈 +12%  │ ║
║ │ 🏗️  BuildCo Ltd        45       43       15        95.5%        📉 -2%   │ ║
║ │ 🏫 EduTech             34       34       12        98.8%        📈 +25%  │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Organization Health Status Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > System Health                                      Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Real-time System Health Monitor                          🔄 Auto-refresh: ON ║
║                                                                              ║
║ ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐ ┌───────────────┐ ║
║ │ Overall Status  │ │ API Health      │ │ Database Health │ │ Agent API     │ ║
║ │  🟢 Healthy     │ │  🟢 45ms avg    │ │  🟢 23/100 conn │ │  🟢 98.7% up  │ ║
║ │  All systems OK │ │  Response time  │ │  Active conns   │ │  Uptime       │ ║
║ └─────────────────┘ └─────────────────┘ └─────────────────┘ └───────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │                     Organization Health Status                          │ ║
║ │                                                                          │ ║
║ │ Organization     DB Status  Devices  Active   Last HB    Alerts          │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🏢 Acme Corp     🟢 Online    150     149     2 min      None            │ ║
║ │    DB Size: 156.7 MB │ Backup: ✅ Daily │ Performance: Good             │ ║
║ │                                                                          │ ║
║ │ 🏭 TechCorp      🟢 Online     89      87     3 min      None            │ ║
║ │    DB Size: 89.2 MB  │ Backup: ✅ Daily │ Performance: Good             │ ║
║ │                                                                          │ ║
║ │ 🏗️  BuildCo      🟡 Warning    45      43     2 hours    ⚠️  2 offline    │ ║
║ │    DB Size: 45.8 MB  │ Backup: ✅ Daily │ Performance: Slow             │ ║
║ │                                                                          │ ║
║ │ 🏪 RetailMax     🟢 Online     67      67     1 min      None            │ ║
║ │    DB Size: 67.3 MB  │ Backup: ✅ Daily │ Performance: Excellent        │ ║
║ │                                                                          │ ║
║ │ 🏦 FinanceFirst  🔴 Error       0       0     1 day      ❌ DB offline    │ ║
║ │    DB Size: 0.1 MB   │ Backup: ❌ Failed │ Performance: N/A             │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ System Resources ───────────────────────────────────────────────────────┐ ║
║ │ CPU Usage:    ████████░░ 32%     │ Network I/O:  📤 1.2 GB/s 📥 2.1 GB/s │ ║
║ │ Memory:       ██████████ 67%     │ Active Pods:  Manager: 2  Agent: 4    │ ║
║ │ Disk Space:   ████░░░░░░ 23%     │ K8s Status:   🟢 All nodes healthy    │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Color Scheme and Design System

### Color Palette
```
Primary Colors:
- Primary Blue:   #1976D2
- Primary Dark:   #1565C0  
- Primary Light:  #42A5F5

Status Colors:
- Success Green: #4CAF50
- Warning Orange: #FF9800
- Error Red:     #F44336
- Info Blue:     #2196F3

Background:
- Light Gray:    #F5F5F5
- White:         #FFFFFF
- Dark Gray:     #424242

Text:
- Primary Text:  #212121
- Secondary:     #757575
- Hint Text:     #BDBDBD
```

### Typography
```
Headings:  Roboto, 700 weight
Body Text: Roboto, 400 weight
Code:      'Roboto Mono', monospace
```

### Component Specifications

#### Cards
- Border radius: 8px
- Shadow: 0 2px 4px rgba(0,0,0,0.1)
- Padding: 16px

#### Buttons
- Primary: Blue background, white text
- Secondary: White background, blue border
- Danger: Red background, white text
- Border radius: 4px

#### Status Indicators
- 🟢 Online/Healthy: Green circle
- 🟡 Warning: Yellow triangle
- 🔴 Error/Offline: Red circle
- ⚪ Unknown: Gray circle

#### Icons
- Material Design Icons
- Size: 24px for action icons, 16px for status
- Color matches the theme context

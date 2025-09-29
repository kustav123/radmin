# Manager UI - Users Management Module

This document provides comprehensive UI mockups and field specifications for the Users management module in the Manager UI.

## Module Overview

**Module**: Users Management
**Access Level**: System Administrators
**Purpose**: Manage system administrators and view organization users
**Location**: Manager UI → Users

## Global Users List Page

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Users                                           Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Users Management                                         [+ Create Admin User]║
║                                                                              ║
║ ┌─ Search & Filters ───────────────────────────────────────────────────────┐ ║
║ │ Search: [                            ] [🔍]  Role: [All ▼]              │ ║
║ │ Organization: [All ▼]  Status: [All ▼]  Last Login: [All Time ▼] [🔄]    │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Quick Stats: Total: 212 │ Admins: 8 │ Org Users: 204 │ Active: 198 │ Locked: 3│ ║
║ │ Today: 156 logins │ This Week: 987 │ MFA Enabled: 145 (68%) │ Failed: 12 │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ User                     Organization   Role      Status    Last Login   │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 👑 System Administrator                                                    │ ║
║ │   admin@rmas.system      System         Admin     🟢 Active  5 min ago    │ ║
║ │   Created: 2024-01-01 | MFA: ✅ | IP: 10.0.1.5 | Sessions: 3        [👁️][✏️]│ ║
║ │   Permissions: All System Access | Last Password Change: 30 days ago    │ ║
║ │                                                                          │ ║
║ │ 👤 John Doe                                                              │ ║
║ │   john.doe@acme.com      Acme Corp      Admin     🟢 Active  2 min ago    │ ║
║ │   Created: 2024-01-15 | MFA: ✅ | IP: 192.168.1.10 | Sessions: 1    [👁️][✏️]│ ║
║ │   Permissions: Organization Admin | Last Login: 192.168.1.10            │ ║
║ │                                                                          │ ║
║ │ 👤 Jane Smith                                                            │ ║
║ │   jane.smith@acme.com    Acme Corp      Manager   🟢 Active  15 min ago   │ ║
║ │   Created: 2024-02-01 | MFA: ✅ | IP: 192.168.1.25 | Sessions: 2    [👁️][✏️]│ ║
║ │   Permissions: Device Management | Last Failed: None                    │ ║
║ │                                                                          │ ║
║ │ 👤 Mike Johnson                                                          │ ║
║ │   mike.j@techcorp.com    TechCorp       User      🟢 Active  1 hour ago   │ ║
║ │   Created: 2024-02-15 | MFA: ❌ | IP: 172.16.0.15 | Sessions: 1     [👁️][✏️]│ ║
║ │   Permissions: Device Monitoring | Groups: IT Servers, Dev Workstations │ ║
║ │                                                                          │ ║
║ │ 👤 Sarah Wilson                                                          │ ║
║ │   s.wilson@buildco.net   BuildCo        Manager   🟡 Warning 2 days ago   │ ║
║ │   Created: 2024-01-20 | MFA: ✅ | IP: 10.1.1.50 | Sessions: 0       [👁️][✏️]│ ║
║ │   ⚠️ Account expires in 7 days | Failed logins: 2 (last 24h)           │ ║
║ │                                                                          │ ║
║ │ 👤 Bob Chen                                                              │ ║
║ │   b.chen@retailmax.com   RetailMax      User      🔒 Locked  1 week ago   │ ║
║ │   Created: 2024-03-05 | MFA: ❌ | IP: - | Sessions: 0               [👁️][🔓]│ ║
║ │   🔒 Locked: Too many failed attempts (5) | Auto-unlock: 2 hours       │ ║
║ │                                                                          │ ║
║ │ 👤 System Service                                                        │ ║
║ │   service@rmas.system    System         Service   🟢 Active  continuous  │ ║
║ │   Created: 2024-01-01 | MFA: N/A | Type: API Service | Sessions: N/A [👁️][✏️]│ ║
║ │   Purpose: Background job processing and system maintenance             │ ║
║ │                                                                          │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Bulk Actions ───────────────────────────────────────────────────────────┐ ║
║ │ ☐ Select All  [📧 Send Message] [🔒 Lock Selected] [📊 Export Users]     │ ║
║ │ [🔄 Force Password Reset] [⚠️ Disable MFA] [📋 Generate Report]           │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ Showing 7 of 212 users                                 « Previous | Next » ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Create Admin User Form

```
╔══════════════════════════════════════════════════════════════════════════════╗
║                        ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░           ║
║     ░░░ ┌──────────────────────────────────────────────────────────┐ ░░░     ║
║     ░░░ │                 Create System Admin User                │ ░░░     ║
║     ░░░ ├──────────────────────────────────────────────────────────┤ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 👤 User Information                                      │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ Username:           [admin.jane      ] *Required   │   │ ░░░     ║
║     ░░░ │ │ Email:              [jane@company.com] *Required   │   │ ░░░     ║
║     ░░░ │ │ First Name:         [Jane            ]             │   │ ░░░     ║
║     ░░░ │ │ Last Name:          [Smith           ]             │   │ ░░░     ║
║     ░░░ │ │ Job Title:          [System Admin    ]             │   │ ░░░     ║
║     ░░░ │ │ Phone:              [+1-555-987-6543 ]             │   │ ░░░     ║
║     ░░░ │ │ Department:         [IT Operations   ]             │   │ ░░░     ║
║     ░░░ │ │ Manager:            [IT Director     ]             │   │ ░░░     ║
║     ░░░ │ │ Employee ID:        [EMP-12345       ]             │   │ ░░░     ║
║     ░░░ │ │ Location:           [New York Office ]             │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 🔐 Account Settings                                      │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ User Role:          ◉ System Admin                 │   │ ░░░     ║
║     ░░░ │ │                     ○ Support Admin                │   │ ░░░     ║
║     ░░░ │ │                     ○ Billing Admin                │   │ ░░░     ║
║     ░░░ │ │                     ○ Read Only Admin              │   │ ░░░     ║
║     ░░░ │ │                                                    │   │ ░░░     ║
║     ░░░ │ │ Password:           [••••••••••••••••••••] (generated)│   │ ░░░     ║
║     ░░░ │ │ Confirm Password:   [••••••••••••••••••••]         │   │ ░░░     ║
║     ░░░ │ │ ☑️ Generate secure password automatically          │   │ ░░░     ║
║     ░░░ │ │ ☑️ Require password change on first login         │   │ ░░░     ║
║     ░░░ │ │                                                    │   │ ░░░     ║
║     ░░░ │ │ Account Status:     ◉ Active  ○ Inactive           │   │ ░░░     ║
║     ░░░ │ │ Account Expires:    [Never ▼            ]          │   │ ░░░     ║
║     ░░░ │ │ Email Verified:     ☑️ Mark as verified           │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 🔒 Security Settings                                     │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ Multi-Factor Auth:  ☑️ Require MFA setup          │   │ ░░░     ║
║     ░░░ │ │ IP Restrictions:    ☐ Enable IP whitelist         │   │ ░░░     ║
║     ░░░ │ │ Session Timeout:    [240              ] minutes    │   │ ░░░     ║
║     ░░░ │ │ Concurrent Sessions:[3                ] max        │   │ ░░░     ║
║     ░░░ │ │ API Access:         ☑️ Allow API key generation   │   │ ░░░     ║
║     ░░░ │ │ Audit Logging:      ☑️ Log all user actions       │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 🔑 System Permissions                                    │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ Organization Management: ☑️ Create/Edit/Delete     │   │ ░░░     ║
║     ░░░ │ │ User Management:         ☑️ Full Access            │   │ ░░░     ║
║     ░░░ │ │ Device Type Management:  ☑️ Full Access            │   │ ░░░     ║
║     ░░░ │ │ System Configuration:    ☑️ Full Access            │   │ ░░░     ║
║     ░░░ │ │ Monitoring & Alerts:     ☑️ View All               │   │ ░░░     ║
║     ░░░ │ │ Database Management:     ☑️ Full Access            │   │ ░░░     ║
║     ░░️ │ │ Backup & Restore:        ☑️ Full Access            │   │ ░░░     ║
║     ░░░ │ │ System Logs:             ☑️ View All               │   │ ░░░     ║
║     ░░░ │ │ API Management:          ☑️ Full Access            │   │ ░░░     ║
║     ░░░ │ │ License Management:      ☑️ View/Edit              │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │ 📧 Notification Settings                                 │ ░░░     ║
║     ░░░ │ ┌────────────────────────────────────────────────────┐   │ ░░░     ║
║     ░░░ │ │ ☑️ Send welcome email with login details           │   │ ░░░     ║
║     ░░░ │ │ ☑️ Send MFA setup instructions                     │   │ ░░░     ║
║     ░░░ │ │ ☑️ Email system alerts and notifications           │   │ ░░░     ║
║     ░░░ │ │ ☑️ Weekly activity summary                         │   │ ░░░     ║
║     ░░░ │ │ ☑️ Security event notifications                    │   │ ░░░     ║
║     ░░░ │ │                                                    │   │ ░░░     ║
║     ░░░ │ │ Email Template:     [Standard ▼        ]          │   │ ░░░     ║
║     ░░░ │ │ Delivery Time:      [Immediately ▼     ]          │   │ ░░░     ║
║     ░░░ │ └────────────────────────────────────────────────────┘   │ ░░░     ║
║     ░░░ │                                                          │ ░░░     ║
║     ░░░ │          [❌ Cancel] [🧪 Validate] [👤 Create User]       │ ░░░     ║
║     ░░░ └──────────────────────────────────────────────────────────┘ ░░░     ║
║                        ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░           ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## User Details View

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager  > Users > John Doe                               Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ User: John Doe (john.doe@acme.com)      [✏️ Edit] [🔒 Lock] [📧 Email] [⚠️]   ║
║                                                                              ║
║ ┌─ Profile Information ────────────────────────────────────────────────────┐ ║
║ │ Username: john.doe                     Organization: Acme Corporation    │ ║
║ │ Email: john.doe@acme.com               Role: Admin                       │ ║
║ │ Name: John Doe                         Status: 🟢 Active                │ ║
║ │ Job Title: IT Manager                  Employee ID: EMP-67890           │ ║
║ │ Phone: +1-555-123-4568                Department: Information Technology │ ║
║ │ Created: 2024-01-15 by System Admin   Last Modified: 2024-09-15         │ ║
║ │ Account Expires: Never                 Email Verified: ✅ Yes            │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Security Information ───────────────────────────────────────────────────┐ ║
║ │ Multi-Factor Auth: ✅ Enabled (TOTP)  Last Password Change: 30 days ago  │ ║
║ │ Failed Login Attempts: 0              Account Lockout: Never             │ ║
║ │ API Keys: 2 active                    IP Restrictions: None              │ ║
║ │ Session Timeout: 240 minutes          Max Concurrent Sessions: 3         │ ║
║ │ Last Successful Login: 2024-09-30 14:30 from 192.168.1.10               │ ║
║ │ Last Failed Login: None                Password Strength: Strong         │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Current Sessions (1) ───────────────────────────────────────────────────┐ ║
║ │ Session ID           Started    IP Address    Location      Browser      │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ sess_abc123...       14:30      192.168.1.10  New York, US Chrome 118    │ ║
║ │ Active since 14:30   Last Activity: 14:32    Expires: 18:30  [🚫 Kill]  │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Organization Permissions ───────────────────────────────────────────────┐ ║
║ │ Organization Access: Acme Corporation (Full Admin)                       │ ║
║ │                                                                          │ ║
║ │ ✅ Device Management          ✅ User Management             ✅ Job Management│ ║
║ │ ✅ Group Management           ✅ Alert Configuration        ✅ Settings    │ ║
║ │ ✅ SNMP Configuration         ✅ Custom Field Management    ✅ Reports     │ ║
║ │ ✅ Database Access            ✅ Backup & Restore           ✅ API Access  │ ║
║ │                                                                          │ ║
║ │ Device Groups Access: All (8 groups)                                    │ ║
║ │ ├─ IT Servers (12 devices)           ├─ HR Workstations (25 devices)    │ ║
║ │ ├─ Network Devices (8 devices)       ├─ Office Printers (6 devices)     │ ║
║ │ └─ Mobile Devices (16 devices)       └─ Dev Workstations (23 devices)   │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Activity Timeline (Last 30 Days) ───────────────────────────────────────┐ ║
║ │ 2024-09-30 14:30  🔑 Logged in from 192.168.1.10                        │ ║
║ │ 2024-09-30 14:25  📝 Updated device group "HR Workstations"              │ ║
║ │ 2024-09-30 14:20  🔧 Executed job "System Health Check" on 25 devices    │ ║
║ │ 2024-09-30 14:15  👥 Added user "mike.wilson@acme.com"                   │ ║
║ │ 2024-09-30 14:10  ⚙️ Modified SNMP settings for "Network Devices"       │ ║
║ │ 2024-09-30 14:05  📊 Generated device inventory report                   │ ║
║ │ 2024-09-30 13:45  🚨 Acknowledged alert "High CPU Usage" on SERVER-03    │ ║
║ │ 2024-09-30 13:30  🔄 Updated custom field definitions                    │ ║
║ │ 2024-09-30 13:15  📋 Created job template "Security Patches"             │ ║
║ │ 2024-09-30 13:00  🖥️ Added 3 new devices to "IT Servers" group          │ ║
║ │ 2024-09-30 12:45  🔑 Logged out                                          │ ║
║ │ 2024-09-30 09:00  🔑 Logged in from 192.168.1.10                        │ ║
║ │                                                          [View All →]    │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Activity Statistics ────────────────────────────────────────────────────┐ ║
║ │ Login Frequency: 24.3 times/month     Avg Session: 4.2 hours            │ ║
║ │ Peak Usage: 14:00-16:00               Device Interactions: 1,247         │ ║
║ │ Jobs Executed: 89                     Reports Generated: 23              │ ║
║ │ Users Created: 5                      Devices Added: 18                  │ ║
║ │ Groups Modified: 12                   Alerts Handled: 34                 │ ║
║ │ API Calls: 2,456                      Failed Operations: 3               │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Quick Actions ──────────────────────────────────────────────────────────┐ ║
║ │ [🔒 Lock Account] [🔄 Reset Password] [📧 Send Email] [🚫 Kill Sessions]   │ ║
║ │ [🔑 Disable MFA] [📱 Reset MFA] [🔐 Generate API Key] [📊 Activity Report]│ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## System Activity Monitor

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ System Activity Monitor                                          [✕ Close] ║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ 🕐 Real-time User Activity                                [⏸️ Pause] [🔄 Refresh]║
║                                                                              ║
║ ┌─ Active Sessions (23) ───────────────────────────────────────────────────┐ ║
║ │ User                    Org          Location      Active Since   Actions │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🟢 john.doe@acme.com    Acme Corp    192.168.1.10  14:30          [👁️][🚫]│ ║
║ │    Admin | Chrome 118 | Last action: Updated device group (1 min ago)   │ ║
║ │                                                                          │ ║
║ │ 🟢 jane.smith@acme.com  Acme Corp    192.168.1.25  14:15          [👁️][🚫]│ ║
║ │    Manager | Firefox 119 | Last action: Executed job (3 min ago)       │ ║
║ │                                                                          │ ║
║ │ 🟢 mike.j@techcorp.com  TechCorp     172.16.0.15   13:45          [👁️][🚫]│ ║
║ │    User | Chrome 118 | Last action: Viewed devices (5 min ago)          │ ║
║ │                                                                          │ ║
║ │ 🟡 admin@rmas.system    System       10.0.1.5      12:00          [👁️][🚫]│ ║
║ │    System Admin | Chrome 118 | Last action: System config (30 min ago) │ ║
║ │                                                                          │ ║
║ │ 🔵 s.wilson@buildco.net BuildCo      10.1.1.50     11:30          [👁️][🚫]│ ║
║ │    Manager | Safari 17 | Last action: Idle for 3 hours                 │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Recent Authentication Events ──────────────────────────────────────────┐ ║
║ │ Time     Event                     User               IP            Result│ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 14:32    🔑 Login                  john.doe@acme.com   192.168.1.10  ✅ Success│ ║
║ │ 14:30    🔐 MFA Challenge          john.doe@acme.com   192.168.1.10  ✅ Success│ ║
║ │ 14:25    🔑 Login                  jane.smith@acme.com 192.168.1.25  ✅ Success│ ║
║ │ 14:20    🚫 Failed Login           unknown@acme.com    203.0.113.10  ❌ Failed │ ║
║ │ 14:15    🔑 Login                  mike.j@techcorp.com 172.16.0.15   ✅ Success│ ║
║ │ 14:10    🔒 Account Locked         b.chen@retailmax.com 198.51.100.5 🔒 Locked │ ║
║ │ 14:05    🚫 Failed Login (5th)     b.chen@retailmax.com 198.51.100.5 ❌ Failed │ ║
║ │ 14:00    🔑 Login                  s.wilson@buildco.net 10.1.1.50    ✅ Success│ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ System Actions (Last 1 Hour) ──────────────────────────────────────────┐ ║
║ │ Time     Action                                    User             Org  │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 14:32    📝 Updated device group "HR Workstations" john.doe@acme.com  Acme │ ║
║ │ 14:30    🔧 Executed job "System Health Check"     jane.smith@acme.com Acme│ ║
║ │ 14:25    👥 Created user "new.user@acme.com"       john.doe@acme.com  Acme │ ║
║ │ 14:20    🖥️ Added device "WIN-WS-067"             mike.j@techcorp.com Tech │ ║
║ │ 14:15    ⚙️ Modified SNMP configuration            admin@rmas.system System│ ║
║ │ 14:10    🚨 Acknowledged alert "Disk Space Low"    s.wilson@buildco.net Build│ ║
║ │ 14:05    📊 Generated inventory report             john.doe@acme.com  Acme │ ║
║ │ 14:00    🔄 Refreshed device types                 admin@rmas.system System│ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Security Alerts ────────────────────────────────────────────────────────┐ ║
║ │ 🔴 Multiple failed login attempts from 203.0.113.10 (5 attempts in 10 min)│ ║
║ │ 🟡 User b.chen@retailmax.com account locked due to failed attempts        │ ║
║ │ 🟡 Admin user logged in from new IP: 10.0.1.5 (admin@rmas.system)        │ ║
║ │ 🟢 All MFA challenges passed successfully (100% success rate today)       │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Performance Metrics ────────────────────────────────────────────────────┐ ║
║ │ Active Users: 23        Peak Today: 34 (at 10:00)    Avg Session: 3.2h  │ ║
║ │ API Calls/min: 45       Database Queries/sec: 12     Cache Hit Rate: 95% │ ║
║ │ Response Time: 89ms     CPU Usage: 34%               Memory: 67%          │ ║
║ │ Failed Logins: 12       Success Rate: 96.2%          MFA Rate: 89%       │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Module Field Specifications

### User Profile Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `username` | String | ✅ | - | Max 50 chars, unique globally |
| `email` | Email | ✅ | - | Valid email, unique globally |
| `first_name` | String | ❌ | - | Max 50 chars |
| `last_name` | String | ❌ | - | Max 50 chars |
| `job_title` | String | ❌ | - | Max 100 chars |
| `phone` | String | ❌ | - | International phone format |
| `department` | String | ❌ | - | Max 100 chars |
| `manager` | String | ❌ | - | Max 100 chars |
| `employee_id` | String | ❌ | - | Max 50 chars |
| `location` | String | ❌ | - | Max 100 chars |

### Account Settings Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `user_role` | Enum | ✅ | User | System Admin, Support Admin, Billing Admin, Read Only |
| `password` | String | ✅ | auto-generated | Min 12 chars, complex |
| `status` | Enum | ✅ | Active | Active, Inactive, Locked, Suspended |
| `account_expires` | Date | ❌ | null | Future date or null |
| `email_verified` | Boolean | ✅ | false | - |
| `created_by` | String | ✅ | current_user | Username of creator |
| `last_modified` | DateTime | ✅ | now() | Auto-updated |

### Security Settings Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `mfa_enabled` | Boolean | ✅ | false | - |
| `mfa_type` | Enum | ❌ | TOTP | TOTP, SMS, Email |
| `ip_whitelist` | JSON | ❌ | null | Array of IP addresses/ranges |
| `session_timeout` | Integer | ✅ | 240 | Minutes, 30-1440 |
| `max_sessions` | Integer | ✅ | 3 | 1-10 |
| `api_access` | Boolean | ✅ | true | - |
| `audit_logging` | Boolean | ✅ | true | - |
| `failed_attempts` | Integer | ✅ | 0 | Auto-incremented |
| `locked_until` | DateTime | ❌ | null | Auto-calculated |
| `last_login` | DateTime | ❌ | null | Auto-updated |
| `last_login_ip` | String | ❌ | null | IP address |
| `password_changed` | DateTime | ❌ | null | Auto-updated |

### Permission Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `organization_id` | UUID | ❌ | null | Valid organization ID |
| `organization_role` | Enum | ❌ | User | Admin, Manager, User |
| `device_groups` | JSON | ❌ | [] | Array of group IDs |
| `permissions` | JSON | ✅ | {} | Permission object |
| `inherited_permissions` | JSON | ✅ | {} | Calculated permissions |

### Activity Tracking Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `login_count` | Integer | ✅ | 0 | Auto-incremented |
| `last_activity` | DateTime | ❌ | null | Auto-updated |
| `session_count` | Integer | ✅ | 0 | Current active sessions |
| `api_calls_count` | Integer | ✅ | 0 | Total API calls made |
| `failed_operations` | Integer | ✅ | 0 | Failed operation count |

### Notification Settings Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `email_notifications` | Boolean | ✅ | true | - |
| `security_alerts` | Boolean | ✅ | true | - |
| `system_alerts` | Boolean | ✅ | true | - |
| `weekly_summary` | Boolean | ✅ | true | - |
| `notification_template` | String | ✅ | standard | Template identifier |
| `delivery_time` | Enum | ✅ | immediate | immediate, hourly, daily |

### Menu Structure
```
Users Management
├── Global Users List
│   ├── Search & Filters
│   ├── Create Admin User
│   ├── Bulk Actions
│   └── Quick Stats
├── Create Admin User
│   ├── User Information
│   ├── Account Settings
│   ├── Security Settings
│   ├── System Permissions
│   └── Notification Settings
├── User Details View
│   ├── Profile Information
│   ├── Security Information
│   ├── Current Sessions
│   ├── Organization Permissions
│   ├── Activity Timeline
│   ├── Activity Statistics
│   └── Quick Actions
└── System Activity Monitor
    ├── Active Sessions
    ├── Authentication Events
    ├── System Actions
    ├── Security Alerts
    └── Performance Metrics
```

This module provides comprehensive user management capabilities for system administrators, allowing them to create, monitor, and manage both system admin users and view organization users across all tenants with detailed activity tracking and security monitoring.

# Organization UI - Job Templates Module

This document provides comprehensive UI mockups and field specifications for the Job Templates management module in the Organization UI.

## Module Overview

**Module**: Job Templates Management
**Access Level**: Organization Administrators/Managers
**Purpose**: Create, manage, and execute automation job templates
**Location**: Organization UI → Job Templates

## Job Templates List Page

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corporation  > Job Templates                              john.doe ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Job Templates Management                               [+ Create Job Template]║
║                                                                              ║
║ ┌─ Search & Filters ───────────────────────────────────────────────────────┐ ║
║ │ Search: [                            ] [🔍]  Category: [All ▼]           │ ║
║ │ Status: [All ▼]  Type: [All ▼]  Last Run: [All Time ▼]  [🔄 Refresh]     │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Quick Stats: Total: 12 │ Active: 10 │ Scheduled: 6 │ Running: 2 │ Failed: 0│ ║
║ │ Today: 47 executions │ Success: 45 (95.7%) │ Avg Duration: 3.2 min        │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌──────────────────────────────────────────────────────────────────────────┐ ║
║ │ Template Name         Category    Type      Status   Last Run    Actions │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🔧 System Health Check                                                    │ ║
║ │   SYSTEM-HEALTH      Monitoring   Script    🟢 Active  2 hours ago [👁️][▶️][✏️]│ ║
║ │   Description: Comprehensive system health monitoring and reporting      │ ║
║ │   Schedule: Every 2 hours | Duration: 4.2 min | Success: 98.5%          │ ║
║ │   Target Groups: IT Servers (12), Prod Servers (45) | Next: 16:00       │ ║
║ │   Parameters: --check-disk --check-memory --check-services              │ ║
║ │                                                                          │ ║
║ │ 🔄 Software Inventory                                                     │ ║
║ │   SOFTWARE-INVENTORY Compliance  PowerShell 🟢 Active  1 day ago    [👁️][▶️][✏️]│ ║
║ │   Description: Collect installed software and version information       │ ║
║ │   Schedule: Daily at 03:00 | Duration: 8.5 min | Success: 96.2%         │ ║
║ │   Target Groups: HR Workstations (25), Dev Workstations (23)            │ ║
║ │   Parameters: -IncludeUpdates -ExportFormat JSON                        │ ║
║ │                                                                          │ ║
║ │ ⚡ Security Updates                                                       │ ║
║ │   SECURITY-UPDATES   Maintenance  Script    🟡 Running  10 min ago   [👁️][⏸️][✏️]│ ║
║ │   Description: Install critical security updates and patches            │ ║
║ │   Schedule: Weekly Sunday 03:00 | Duration: 23.8 min | Success: 92.1%   │ ║
║ │   Target Groups: All Servers (57) | Progress: 45/57 (79%) complete      │ ║
║ │   Parameters: --auto-reboot --exclude-kernel                            │ ║
║ │                                                                          │ ║
║ │ 📊 Performance Baseline                                                   │ ║
║ │   PERF-BASELINE      Monitoring   Agent     🟢 Active  6 hours ago   [👁️][▶️][✏️]│ ║
║ │   Description: Establish performance baselines for capacity planning    │ ║
║ │   Schedule: Every 6 hours | Duration: 2.1 min | Success: 99.1%          │ ║
║ │   Target Groups: Prod Servers (45), Network Devices (8)                 │ ║
║ │   Parameters: --cpu --memory --disk --network                           │ ║
║ │                                                                          │ ║
║ │ 🚨 Emergency Response                                                     │ ║
║ │   EMERGENCY-RESPONSE Incident    Script    🔴 Manual   Never         [👁️][▶️][✏️]│ ║
║ │   Description: Emergency incident response and system stabilization     │ ║
║ │   Schedule: Manual trigger only | Duration: 15.3 min | Success: 89.5%   │ ║
║ │   Target Groups: All Critical Systems | Requires approval               │ ║
║ │   Parameters: --emergency-mode --notify-on-call                         │ ║
║ │                                                                          │ ║
║ │ 🔍 SNMP Discovery                                                         │ ║
║ │   SNMP-DISCOVERY     Discovery    SNMP      🟢 Active  1 day ago     [👁️][▶️][✏️]│ ║
║ │   Description: Discover and catalog network devices via SNMP            │ ║
║ │   Schedule: Daily at 02:00 | Duration: 12.7 min | Success: 94.3%        │ ║
║ │   Target Networks: 192.168.1.0/24, 10.0.0.0/16                         │ ║
║ │   Parameters: --community public --timeout 30 --retries 3               │ ║
║ │                                                                          │ ║
║ │ 📋 Compliance Audit                                                       │ ║
║ │   COMPLIANCE-AUDIT   Compliance  Script    🟢 Active  1 week ago    [👁️][▶️][✏️]│ ║
║ │   Description: SOX compliance audit and reporting                       │ ║
║ │   Schedule: Monthly 1st Sunday | Duration: 45.2 min | Success: 87.8%    │ ║
║ │   Target Groups: All Systems | Generates compliance report              │ ║
║ │   Parameters: --sox-compliance --generate-report                        │ ║
║ │                                                                          │ ║
║ │ 🔄 Configuration Backup                                                   │ ║
║ │   CONFIG-BACKUP      Backup      Script    🟢 Active  12 hours ago  [👁️][▶️][✏️]│ ║
║ │   Description: Backup device configurations and system settings         │ ║
║ │   Schedule: Twice daily (06:00, 18:00) | Duration: 7.9 min | Success: 98.9%│ ║
║ │   Target Groups: Network Devices (8), Infrastructure (15)               │ ║
║ │   Parameters: --compress --encrypt --verify                             │ ║
║ │                                                                          │ ║
║ │ [Show 4 more templates...]                            [📋 View All (12)] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Bulk Actions ───────────────────────────────────────────────────────────┐ ║
║ │ ☐ Select All  [▶️ Run Selected] [📊 Compare Templates] [📤 Export]        │ ║
║ │ [📋 Clone Templates] [🔄 Update Schedules] [📈 Performance Report]       │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Create Job Template Form

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║                    ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░         ║
║   ░░░ ┌────────────────────────────────────────────────────────────┐ ░░░   ║
║   ░░░ │                 Create Job Template                        │ ░░░   ║
║   ░░░ ├────────────────────────────────────────────────────────────┤ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 📋 Basic Information                                       │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Template Name:      [Log File Cleanup   ] *Required  │   │ ░░░   ║
║   ░░░ │ │ Template ID:        [LOG-FILE-CLEANUP   ] (auto)     │   │ ░░░   ║
║   ░░░ │ │ Description:        [Automated cleanup of old log    │   │ ░░░   ║
║   ░░░ │ │                      files to free up disk space   ]│   │ ░░░   ║
║   ░░░ │ │ Category:           [Maintenance ▼      ]           │   │ ░░░   ║
║   ░░░ │ │ Priority:           [Medium ▼           ]           │   │ ░░░   ║
║   ░░░ │ │ Job Type:           ◉ Script Execution              │   │ ░░░   ║
║   ░░░ │ │                     ○ Agent Command                 │   │ ░░░   ║
║   ░░️ │ │                     ○ SNMP Operation                │   │ ░░░   ║
║   ░░░ │ │                     ○ Custom Field Collection       │   │ ░░░   ║
║   ░░░ │ │ Tags:               [cleanup, maintenance, logs]    │   │ ░░░   ║
║   ░░░ │ │ Owner:              [john.doe@acme.com ▼]          │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 🎯 Target Selection                                        │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Target Type:        ◉ Device Groups                 │   │ ░░░   ║
║   ░░️ │ │                     ○ Specific Devices              │   │ ░░░   ║
║   ░░░ │ │                     ○ Dynamic Query                 │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Selected Groups:                                     │   │ ░░░   ║
║   ░░░ │ │ ☑️ IT Servers (12 devices)                          │   │ ░░░   ║
║   ░░░ │ │ ☑️ Prod Servers (45 devices)                        │   │ ░░░   ║
║   ░░░ │ │ ☐ HR Workstations (25 devices)                     │   │ ░░░   ║
║   ░░░ │ │ ☐ Dev Workstations (23 devices)                    │   │ ░░░   ║
║   ░░░ │ │ ☐ Network Devices (8 devices)                      │   │ ░░░   ║
║   ░░░ │ │ ☐ Mobile Devices (16 devices)                      │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Total Target Devices: 57                             │   │ ░░░   ║
║   ░░░ │ │ Estimated Duration: 8.5 minutes                      │   │ ░░░   ║
║   ░░░ │ │ [🔍 Preview Targets] [🧪 Test Connection]            │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 🔧 Script Configuration                                    │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Script Type:        ◉ Shell Script                  │   │ ░░░   ║
║   ░░░ │ │                     ○ PowerShell                    │   │ ░░░   ║
║   ░░░ │ │                     ○ Python                        │   │ ░░░   ║
║   ░░░ │ │                     ○ Custom Command                │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Script Content:                                      │   │ ░░░   ║
║   ░░░ │ │ ┌──────────────────────────────────────────────────┐ │   │ ░░░   ║
║   ░░░ │ │ │#!/bin/bash                                       │ │   │ ░░░   ║
║   ░░░ │ │ │# Log file cleanup script                        │ │   │ ░░░   ║
║   ░░░ │ │ │                                                  │ │   │ ░░░   ║
║   ░░░ │ │ │# Define log directories                          │ │   │ ░░░   ║
║   ░░░ │ │ │LOG_DIRS="/var/log /opt/app/logs /tmp"           │ │   │ ░░░   ║
║   ░░░ │ │ │                                                  │ │   │ ░░░   ║
║   ░░░ │ │ │# Remove logs older than 30 days                 │ │   │ ░░░   ║
║   ░░░ │ │ │for dir in $LOG_DIRS; do                         │ │   │ ░░░   ║
║   ░░░ │ │ │  if [ -d "$dir" ]; then                         │ │   │ ░░░   ║
║   ░░░ │ │ │    find "$dir" -name "*.log" -mtime +30 -delete │ │   │ ░░░   ║
║   ░░░ │ │ │    find "$dir" -name "*.gz" -mtime +60 -delete  │ │   │ ░░░   ║
║   ░░░ │ │ │  fi                                              │ │   │ ░░░   ║
║   ░░░ │ │ │done                                              │ │   │ ░░░   ║
║   ░░░ │ │ │                                                  │ │   │ ░░░   ║
║   ░░░ │ │ │echo "Log cleanup completed"                      │ │   │ ░░░   ║
║   ░░░ │ │ └──────────────────────────────────────────────────┘ │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Parameters:         [--days 30 --compress]           │   │ ░░░   ║
║   ░░░ │ │ Working Directory:  [/tmp                 ]          │   │ ░░░   ║
║   ░░░ │ │ Run As User:        [root ▼               ]          │   │ ░░░   ║
║   ░░░ │ │ Timeout (minutes):  [15                   ]          │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ ☑️ Capture stdout output                            │   │ ░░░   ║
║   ░░░ │ │ ☑️ Capture stderr output                            │   │ ░░░   ║
║   ░░░ │ │ ☑️ Log execution details                            │   │ ░░░   ║
║   ░░░ │ │ ☐ Continue on failure                               │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ [📁 Upload Script File] [🧪 Validate Syntax]        │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ ⏰ Scheduling Options                                       │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Schedule Type:      ◉ Recurring                     │   │ ░░░   ║
║   ░░░ │ │                     ○ One-time                      │   │ ░░░   ║
║   ░░░ │ │                     ○ Manual only                   │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Frequency:          ◉ Daily   ○ Weekly   ○ Monthly  │   │ ░░░   ║
║   ░░░ │ │                     ○ Hourly  ○ Custom Cron        │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Time:               [02:30 📅]                      │   │ ░░░   ║
║   ░░░ │ │ Timezone:           [America/New_York ▼]           │   │ ░░░   ║
║   ░░░ │ │ Start Date:         [2024-10-01 📅]                │   │ ░░░   ║
║   ░░░ │ │ End Date:           [Never ▼         ]             │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Advanced Options:                                    │   │ ░░░   ║
║   ░░░ │ │ ☑️ Skip if previous execution still running         │   │ ░░░   ║
║   ░░░ │ │ ☑️ Retry failed executions (max 3 attempts)        │   │ ░░░   ║
║   ░░░ │ │ ☐ Run only on business days                        │   │ ░░░   ║
║   ░░░ │ │ ☐ Pause during maintenance windows                 │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Next Execution: 2024-10-01 02:30 EST               │   │ ░░░   ║
║   ░░░ │ │ [📅 Show Next 10 Executions]                       │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ ⚙️ Execution Settings                                      │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Parallel Execution: [5                ] max devices │   │ ░░░   ║
║   ░░░ │ │ Batch Size:         [10               ] devices     │   │ ░░️   ║
║   ░░░ │ │ Batch Delay:        [30               ] seconds     │   │ ░░░   ║
║   ░░░ │ │ Failure Threshold:  [20               ] % max fails │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ ☑️ Stop execution if failure threshold exceeded     │   │ ░░░   ║
║   ░░░ │ │ ☑️ Send notification on completion                  │   │ ░░░   ║
║   ░░░ │ │ ☑️ Generate execution report                        │   │ ░░░   ║
║   ░░░ │ │ ☐ Require manual approval for execution            │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Output Storage:     [30               ] days        │   │ ░░░   ║
║   ░░░ │ │ Log Level:          [INFO ▼           ]             │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │ 🔔 Notification Settings                                   │ ░░░   ║
║   ░░░ │ ┌──────────────────────────────────────────────────────┐   │ ░░░   ║
║   ░░░ │ │ Notify On:                                           │   │ ░░░   ║
║   ░░░ │ │ ☑️ Job completion (success)                         │   │ ░░░   ║
║   ░░░ │ │ ☑️ Job failure                                      │   │ ░░░   ║
║   ░░░ │ │ ☑️ Job timeout                                      │   │ ░░░   ║
║   ░░░ │ │ ☐ Each device completion                            │   │ ░░░   ║
║   ░░░ │ │ ☐ Failure threshold reached                         │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Recipients:                                          │   │ ░░░   ║
║   ░░░ │ │ ☑️ Template owner     ☑️ Group managers             │   │ ░░░   ║
║   ░░░ │ │ ☐ All organization    ☐ Custom email list          │   │ ░░░   ║
║   ░░░ │ │                                                      │   │ ░░░   ║
║   ░░░ │ │ Custom Recipients:  [ops-team@acme.com]             │   │ ░░░   ║
║   ░░░ │ │ Message Template:   [Standard ▼       ]             │   │ ░░░   ║
║   ░░░ │ └──────────────────────────────────────────────────────┘   │ ░░░   ║
║   ░░░ │                                                            │ ░░░   ║
║   ░░░ │     [❌ Cancel] [🧪 Test Template] [💾 Create Template]     │ ░░░   ║
║   ░░░ └────────────────────────────────────────────────────────────┘ ░░░   ║
║                    ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░         ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Job Execution Monitor

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corporation  > Job Templates > Security Updates > Execution         ║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Job Execution: Security Updates                    [⏸️ Pause] [🛑 Stop] [🔄] ║
║ Started: 2024-09-30 03:00:15 | Elapsed: 18m 32s | ETA: 5m 12s                ║
║                                                                              ║
║ ┌─ Execution Overview ─────────────────────────────────────────────────────┐ ║
║ │ Status: 🟡 Running (Batch 5 of 6)              Progress: 79% ████████░░   │ ║
║ │ Total Devices: 57                              Success: 41 (72%)          │ ║
║ │ Completed: 45                                   Failed: 4 (7%)            │ ║
║ │ Running: 8                                      Pending: 4 (7%)           │ ║
║ │ Skipped: 0                                      Timeout: 0 (0%)           │ ║
║ │                                                                          │ ║
║ │ Execution ID: exec_20240930_030015              Template: SECURITY-UPDATES│ ║
║ │ Triggered By: Scheduled (john.doe@acme.com)    Batch Size: 10 devices    │ ║
║ │ Parallel Limit: 5 devices                      Batch Delay: 30 seconds   │ ║
║ │ Failure Threshold: 20% (not exceeded)          Current Batch: 5/6        │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Current Batch (8 running) ──────────────────────────────────────────────┐ ║
║ │ Device Name          Status        Progress  Duration  Output             │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ 🖥️ PROD-SRV-008      🟡 Installing  68%       12m 15s  Installing kernel..│ ║
║ │ 🖥️ PROD-SRV-009      🟡 Downloading 45%       8m 22s   Fetching packages │ ║
║ │ 🖥️ PROD-SRV-010      🟡 Installing  89%       15m 31s  Configuring...    │ ║
║ │ 🖥️ PROD-SRV-011      🟡 Downloading 23%       5m 12s   0/47 packages     │ ║
║ │ 🖥️ PROD-SRV-012      🟡 Installing  92%       18m 05s  Almost done...    │ ║
║ │ 🖥️ PROD-SRV-013      🟡 Rebooting   100%      19m 42s  Restarting...     │ ║
║ │ 🖥️ PROD-SRV-014      🟡 Installing  56%       11m 18s  Installing libs   │ ║
║ │ 🖥️ PROD-SRV-015      🟡 Downloading 78%       9m 45s   32/47 packages    │ ║
║ │                                                          [📋 View Details]│ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Completed Devices (45) ─────────────────────────────────────────────────┐ ║
║ │ Filter: [All ▼] Status: [All ▼] Group: [All ▼] [🔍]          [📤 Export]│ ║
║ │                                                                          │ ║
║ │ Device Name          Group         Status      Duration  Updates   Output│ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ ✅ PROD-SRV-001      Prod Servers  Success     23m 15s   12 updates [👁️] │ ║
║ │ ✅ PROD-SRV-002      Prod Servers  Success     19m 42s   8 updates  [👁️] │ ║
║ │ ✅ PROD-SRV-003      Prod Servers  Success     21m 33s   15 updates [👁️] │ ║
║ │ ❌ PROD-SRV-004      Prod Servers  Failed      5m 18s    0 updates  [👁️] │ ║
║ │ ✅ PROD-SRV-005      Prod Servers  Success     18m 07s   6 updates  [👁️] │ ║
║ │ ✅ IT-SRV-001        IT Servers    Success     16m 24s   9 updates  [👁️] │ ║
║ │ ❌ IT-SRV-002        IT Servers    Failed      2m 45s    0 updates  [👁️] │ ║
║ │ ✅ IT-SRV-003        IT Servers    Success     20m 11s   11 updates [👁️] │ ║
║ │                                                                          │ ║
║ │ Showing 8 of 45 completed devices               [📋 View All Completed] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Failed Devices (4) ─────────────────────────────────────────────────────┐ ║
║ │ Device Name          Error                          Duration  Retry       │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ ❌ PROD-SRV-004      Package repository timeout    5m 18s    [🔄] (2/3)  │ ║
║ │ ❌ IT-SRV-002        Insufficient disk space       2m 45s    [🔄] (1/3)  │ ║
║ │ ❌ PROD-SRV-016      SSH connection failed          1m 12s    [🔄] (3/3)  │ ║
║ │ ❌ PROD-SRV-023      Permission denied              3m 33s    [🔄] (1/3)  │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Execution Timeline ─────────────────────────────────────────────────────┐ ║
║ │ 03:00:15  🚀 Job execution started (57 devices queued)                   │ ║
║ │ 03:00:16  📊 Batch 1 started (10 devices)                               │ ║
║ │ 03:03:45  ✅ Batch 1 completed (9 success, 1 failed)                     │ ║
║ │ 03:04:15  📊 Batch 2 started (10 devices)                               │ ║
║ │ 03:07:32  ✅ Batch 2 completed (10 success, 0 failed)                    │ ║
║ │ 03:08:02  📊 Batch 3 started (10 devices)                               │ ║
║ │ 03:11:18  ✅ Batch 3 completed (8 success, 2 failed)                     │ ║
║ │ 03:11:48  📊 Batch 4 started (10 devices)                               │ ║
║ │ 03:15:25  ✅ Batch 4 completed (10 success, 0 failed)                    │ ║
║ │ 03:15:55  📊 Batch 5 started (10 devices) - CURRENT                     │ ║
║ │ 03:18:47  🔄 Retrying failed device PROD-SRV-004 (attempt 2/3)          │ ║
║ │                                                      [📋 View Full Log] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Performance Metrics ────────────────────────────────────────────────────┐ ║
║ │ Avg Device Duration: 18.2 minutes    Peak Concurrent: 8/5 devices       │ ║
║ │ Throughput: 2.5 devices/min          CPU Usage: 67% (executor)          │ ║
║ │ Network I/O: 45.2 MB/s               Memory Usage: 1.2 GB (executor)    │ ║
║ │ Success Rate: 91.1% (current)        Historical Avg: 92.1%              │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Job History & Reports

```text
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏢 Acme Corporation  > Job Templates > System Health Check > History        ║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ Job Template: System Health Check                          [📊] [⚙️] [📤]   ║
║                                                                              ║
║ ┌─ Execution History ──────────────────────────────────────────────────────┐ ║
║ │ Filter: [Last 30 Days ▼] Status: [All ▼] [🔍]            [🔄 Refresh]    │ ║
║ │                                                                          │ ║
║ │ Execution ID         Started       Duration   Devices  Success Rate     │ ║
║ │ ────────────────────────────────────────────────────────────────────────── │ ║
║ │ ✅ exec_20240930_1200  30 Sep 12:00   4m 12s    57      100% (57/57)    │ ║
║ │ ✅ exec_20240930_1000  30 Sep 10:00   4m 08s    57      100% (57/57)    │ ║
║ │ ✅ exec_20240930_0800  30 Sep 08:00   4m 15s    57      100% (57/57)    │ ║
║ │ ✅ exec_20240930_0600  30 Sep 06:00   4m 21s    57      100% (57/57)    │ ║
║ │ ✅ exec_20240930_0400  30 Sep 04:00   4m 18s    57      100% (57/57)    │ ║
║ │ ⚠️ exec_20240930_0200  30 Sep 02:00   3m 45s    57      98.2% (56/57)   │ ║
║ │ ✅ exec_20240930_0000  30 Sep 00:00   4m 33s    57      100% (57/57)    │ ║
║ │ ✅ exec_20240929_2200  29 Sep 22:00   4m 11s    57      100% (57/57)    │ ║
║ │ ✅ exec_20240929_2000  29 Sep 20:00   4m 17s    57      100% (57/57)    │ ║
║ │ ❌ exec_20240929_1800  29 Sep 18:00   2m 34s    57      87.7% (50/57)   │ ║
║ │                                                      [📋 View All (124)] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Performance Trends (Last 30 Days) ──────────────────────────────────────┐ ║
║ │                                                                          │ ║
║ │ Success Rate:                    Duration (minutes):                     │ ║
║ │ 100% ┼─────────────────────────   6.0 ┼─────────────────────────────────  │ ║
║ │      │     ╭─╮                        │                                  │ ║
║ │  95% ┼─────╯ ╰─╮   ╭───────────       │         ╭─╮                      │ ║
║ │      │         ╰───╯               5.0 ┼─────────╯ ╰─╮  ╭─╮              │ ║
║ │  90% ┼─────────────────────────        │             ╰──╯ ╰──╮ ╭─────    │ ║
║ │      │                             4.0 ┼─────────────────────╰─╯         │ ║
║ │  85% ┼─────────────────────────        │                                  │ ║
║ │      └─┬─┬─┬─┬─┬─┬─┬─┬─┬─┬─┬─      3.0 └─┬─┬─┬─┬─┬─┬─┬─┬─┬─┬─┬─┬─┬─┬─   │ ║
║ │       25 26 27 28 29 30 01 02         25 26 27 28 29 30 01 02 03 04 05   │ ║
║ │                                                                          │ ║
║ │ Average Success Rate: 98.5%          Average Duration: 4.2 minutes       │ ║
║ │ Trend: Stable ↔️                     Trend: Improving ↗️                 │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Device Performance Analysis ────────────────────────────────────────────┐ ║
║ │                                                                          │ ║
║ │ Top Performing Devices (Fastest Execution):                             │ ║
║ │ • PROD-SRV-001: Avg 2.1 min (100% success) - High-performance SSD      │ ║
║ │ • PROD-SRV-015: Avg 2.3 min (100% success) - Dedicated resources       │ ║
║ │ • IT-SRV-003: Avg 2.4 min (100% success) - Optimized configuration     │ ║
║ │                                                                          │ ║
║ │ Problematic Devices (Frequent Issues):                                  │ ║
║ │ • DEV-SRV-002: 15% failure rate - Resource constraints                  │ ║
║ │ • PROD-SRV-012: 8% failure rate - Network connectivity issues          │ ║
║ │ • IT-SRV-007: 12% failure rate - High load during execution             │ ║
║ │                                                                          │ ║
║ │ Device Group Performance:                                                │ ║
║ │ • Prod Servers: 99.1% success, 4.1 min avg                             │ ║
║ │ • IT Servers: 97.8% success, 4.5 min avg                               │ ║
║ │                                                  [📊 Detailed Analysis] │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Schedule Compliance ────────────────────────────────────────────────────┐ ║
║ │ Scheduled Executions: 240            Successful Starts: 238 (99.2%)     │ ║
║ │ Missed Executions: 2                 Average Delay: 15 seconds          │ ║
║ │ Manual Executions: 12                Peak Load Time: 14:00-16:00         │ ║
║ │                                                                          │ ║
║ │ Missed Execution Reasons:                                                │ ║
║ │ • System maintenance: 1              • Resource exhaustion: 1            │ ║
║ │                                                                          │ ║
║ │ Next Scheduled: 2024-09-30 14:00 (in 1h 28m)                           │ ║
║ │ Schedule Health: 🟢 Excellent                                           │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
║ ┌─ Resource Usage ─────────────────────────────────────────────────────────┐ ║
║ │ Total Execution Time: 847 minutes    Avg CPU Usage: 34%                 │ ║
║ │ Network Transfer: 2.3 GB             Avg Memory Usage: 512 MB           │ ║
║ │ Storage Used: 45.2 MB (logs)         Peak Concurrent: 5 devices         │ ║
║ │                                                                          │ ║
║ │ Cost Analysis (Estimated):                                               │ ║
║ │ • Compute Time: $12.45               • Network: $0.23                    │ ║
║ │ • Storage: $0.12                     • Total: $12.80                     │ ║
║ └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝
```

## Module Field Specifications

### Basic Information Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `template_name` | String | ✅ | - | Max 100 chars, unique within org |
| `template_id` | String | ✅ | auto-generated | Uppercase, hyphenated, unique |
| `description` | Text | ❌ | - | Max 1000 chars |
| `category` | Enum | ✅ | Maintenance | Monitoring, Maintenance, Compliance, Discovery, Backup, Security, Custom |
| `priority` | Enum | ✅ | Medium | Low, Medium, High, Critical |
| `job_type` | Enum | ✅ | Script | Script, Agent, SNMP, Collection |
| `tags` | JSON | ❌ | [] | Array of strings |
| `owner_id` | UUID | ✅ | current_user | Valid user ID |
| `status` | Enum | ✅ | Active | Active, Inactive, Draft, Archived |

### Target Selection Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `target_type` | Enum | ✅ | Groups | Groups, Devices, Query |
| `target_groups` | JSON | ❌ | [] | Array of group IDs |
| `target_devices` | JSON | ❌ | [] | Array of device IDs |
| `target_query` | JSON | ❌ | null | Dynamic query object |
| `estimated_devices` | Integer | ✅ | 0 | Auto-calculated |
| `estimated_duration` | Integer | ❌ | null | Minutes, auto-estimated |

### Script Configuration Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `script_type` | Enum | ✅ | Shell | Shell, PowerShell, Python, Command |
| `script_content` | Text | ✅ | - | Max 50000 chars |
| `script_file` | String | ❌ | null | File path reference |
| `parameters` | String | ❌ | - | Max 1000 chars |
| `working_directory` | String | ❌ | /tmp | Valid directory path |
| `run_as_user` | String | ✅ | root | Valid username |
| `timeout_minutes` | Integer | ✅ | 30 | 1-1440 minutes |
| `capture_stdout` | Boolean | ✅ | true | - |
| `capture_stderr` | Boolean | ✅ | true | - |
| `log_execution` | Boolean | ✅ | true | - |
| `continue_on_failure` | Boolean | ✅ | false | - |

### Scheduling Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `schedule_type` | Enum | ✅ | Manual | Recurring, OneTime, Manual |
| `frequency` | Enum | ❌ | Daily | Hourly, Daily, Weekly, Monthly, Cron |
| `cron_expression` | String | ❌ | null | Valid cron expression |
| `schedule_time` | Time | ❌ | null | HH:MM format |
| `timezone` | String | ❌ | UTC | Valid timezone identifier |
| `start_date` | Date | ❌ | today | Future date |
| `end_date` | Date | ❌ | null | After start_date |
| `skip_if_running` | Boolean | ✅ | true | - |
| `retry_failed` | Boolean | ✅ | true | - |
| `max_retries` | Integer | ✅ | 3 | 0-10 |
| `business_days_only` | Boolean | ✅ | false | - |
| `pause_maintenance` | Boolean | ✅ | false | - |

### Execution Settings Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `parallel_limit` | Integer | ✅ | 5 | 1-50 |
| `batch_size` | Integer | ✅ | 10 | 1-100 |
| `batch_delay_seconds` | Integer | ✅ | 30 | 0-3600 |
| `failure_threshold_percent` | Integer | ✅ | 20 | 0-100 |
| `stop_on_threshold` | Boolean | ✅ | true | - |
| `notify_completion` | Boolean | ✅ | true | - |
| `generate_report` | Boolean | ✅ | true | - |
| `require_approval` | Boolean | ✅ | false | - |
| `output_retention_days` | Integer | ✅ | 30 | 1-365 |
| `log_level` | Enum | ✅ | INFO | DEBUG, INFO, WARN, ERROR |

### Notification Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `notify_completion` | Boolean | ✅ | true | - |
| `notify_failure` | Boolean | ✅ | true | - |
| `notify_timeout` | Boolean | ✅ | true | - |
| `notify_device_completion` | Boolean | ✅ | false | - |
| `notify_threshold` | Boolean | ✅ | false | - |
| `notification_recipients` | JSON | ✅ | ["owner"] | Array of recipient types |
| `custom_recipients` | String | ❌ | - | Comma-separated emails |
| `message_template` | String | ✅ | standard | Template identifier |

### Execution Tracking Fields
| Field Name | Type | Required | Default | Validation |
|------------|------|----------|---------|------------|
| `execution_count` | Integer | ✅ | 0 | Auto-incremented |
| `last_execution` | DateTime | ❌ | null | Auto-updated |
| `last_success` | DateTime | ❌ | null | Auto-updated |
| `last_failure` | DateTime | ❌ | null | Auto-updated |
| `success_rate` | Float | ✅ | 0.0 | Percentage, 0-100 |
| `avg_duration` | Integer | ✅ | 0 | Minutes, auto-calculated |
| `next_execution` | DateTime | ❌ | null | Auto-calculated |

### Menu Structure
```
Job Templates
├── Job Templates List
│   ├── Search & Filters
│   ├── Create Job Template
│   ├── Bulk Actions
│   └── Quick Stats
├── Create Job Template
│   ├── Basic Information
│   ├── Target Selection
│   ├── Script Configuration
│   ├── Scheduling Options
│   ├── Execution Settings
│   └── Notification Settings
├── Job Execution Monitor
│   ├── Execution Overview
│   ├── Current Batch
│   ├── Completed Devices
│   ├── Failed Devices
│   ├── Execution Timeline
│   └── Performance Metrics
├── Job History & Reports
│   ├── Execution History
│   ├── Performance Trends
│   ├── Device Performance Analysis
│   ├── Schedule Compliance
│   └── Resource Usage
└── Template Management
    ├── Edit Template
    ├── Clone Template
    ├── Manage Permissions
    └── Export Template
```

This module provides comprehensive job template management capabilities, allowing organization users to create automated scripts, schedule recurring tasks, monitor execution progress, and analyze performance trends with detailed reporting and metrics.

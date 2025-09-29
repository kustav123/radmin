# Manager UI Overview

This document provides an overview and design specifications for the Manager UI interface, which is used by system administrators to manage organizations and global settings.

## Manager UI Overview

The Manager UI is a comprehensive web application built with Laravel and Vue.js components, providing a clean and intuitive interface for system-wide management.

### Design Principles
- **Clean and Modern**: Material Design inspired interface
- **Responsive**: Mobile-first responsive design
- **Intuitive Navigation**: Clear hierarchical navigation
- **Real-time Updates**: Live data updates and notifications
- **Dark/Light Theme**: Support for both themes

### Module Documentation
For detailed UI mockups and field specifications, see the individual module documentation:

- **[Device Types Management](modules/manager-device-types.md)** - Global device type templates and custom field definitions
- **[Organizations Management](modules/manager-organizations.md)** - Tenant organization creation and management
- **[Users Management](modules/manager-users.md)** - System administrator and user management across all tenants

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

## Dashboard Overview

```
╔══════════════════════════════════════════════════════════════════════════════╗
║ 🏠 RMAS Manager                                                       Admin ▼║
╠══════════════════════════════════════════════════════════════════════════════╣
║ Dashboard    Organizations    Device Types    Users    System     Support    ║
╠══════════════════════════════════════════════════════════════════════════════╣
║                                                                              ║
║ ┌─────────────────────────────────┐ ┌─────────────────────────────────────┐ ║
║ │          System Overview        │ │           System Health             │ ║
║ │                                 │ │                                     │ ║
║ │ 📊 Total Organizations: 25      │ │ 🟢 Database: Healthy                │ ║
║ │ 📱 Total Devices: 2,503         │ │ ┌─────────────────────────────────┐ │ ║
║ │ 👥 Total Users: 187             │ │ │ CPU Usage: 45%                  │ │ ║
║ │ 🔧 Device Types: 12             │ │ │ Memory: 67% ████████░░░░░░░░░░  │ │ ║
║ │ 📋 Active Jobs: 47              │ │ │ Disk Usage: 156GB/500GB        │ │ ║
║ │                                 │ │ └─────────────────────────────────┘ │ ║
║ │ 🟢 Online: 2,487 (99.4%)        │ │                                     │ ║
║ │ 🟡 Warning: 12 (0.5%)           │ │ 🟢 All systems operational         │ ║
║ │ 🔴 Offline: 4 (0.1%)            │ │                                     │ ║
║ │                                 │ │            [Details]               │ ║
║ │           [Details]             │ └─────────────────────────────────────┘ ║
║ └─────────────────────────────────┘                                       ║
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

## Navigation Structure

### Main Navigation Tabs
- **Dashboard**: System overview and health monitoring
- **Organizations**: Tenant management and organization settings
- **Device Types**: Global device type templates and custom field definitions
- **Users**: System administrator management
- **System**: Global system configuration and settings
- **Support**: Help, documentation, and support tools

### Module References
Each tab leads to detailed module interfaces documented separately:

1. **Device Types** → [manager-device-types.md](modules/manager-device-types.md)
2. **Organizations** → [manager-organizations.md](modules/manager-organizations.md)  
3. **Users** → [manager-users.md](modules/manager-users.md)

## Design System

### Color Scheme
- **Primary**: #1976D2 (Blue)
- **Success**: #4CAF50 (Green)  
- **Warning**: #FF9800 (Orange)
- **Error**: #F44336 (Red)
- **Info**: #2196F3 (Light Blue)

### Status Indicators
- 🟢 **Active/Online/Healthy**: Green
- 🟡 **Warning/Inactive**: Yellow/Orange
- 🔴 **Error/Offline/Critical**: Red
- 🔵 **Info/Processing**: Blue
- ⚪ **Unknown/Pending**: Gray

### Icons
- 🏠 Home/Dashboard
- 🏢 Organizations
- 👥 Users  
- 🖥️ Devices
- ⚙️ Settings
- 📊 Analytics
- 🔧 Tools
- 📋 Templates
- 🔍 Search
- 📱 Mobile Devices
- 🌐 Network
- 🔐 Security

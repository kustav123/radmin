# RMAS UI Documentation

This directory contains comprehensive UI documentation for the RMAS (Remote Management Administration System) including detailed mockups, field specifications, and design guidelines.

## Documentation Structure

### Overview Files
- **[manager-ui-overview.md](manager-ui-overview.md)** - Manager UI interface overview with login and dashboard mockups
- **[organization-ui-overview.md](organization-ui-overview.md)** - Organization UI interface overview with navigation and data flow
- **[ui-flow-structure.md](ui-flow-structure.md)** - Complete UI hierarchy and module relationships

### Detailed Module Documentation

#### Manager UI Modules
Located in `modules/` directory with `manager-` prefix:

- **[manager-device-types.md](modules/manager-device-types.md)** - Device type templates and custom field definitions
- **[manager-organizations.md](modules/manager-organizations.md)** - Tenant organization creation and management  
- **[manager-users.md](modules/manager-users.md)** - System administrator and user management

#### Organization UI Modules  
Located in `modules/` directory with `organization-` prefix:

- **[organization-device-groups.md](modules/organization-device-groups.md)** - Device group management with dynamic rules
- **[organization-job-templates.md](modules/organization-job-templates.md)** - Job template creation and execution monitoring
- **[organization-device-management.md](modules/organization-device-management.md)** - Device registration and monitoring *(coming soon)*
- **[organization-snmp-management.md](modules/organization-snmp-management.md)** - SNMP configuration and discovery *(coming soon)*
- **[organization-alert-management.md](modules/organization-alert-management.md)** - Alert rules and notifications *(coming soon)*

## Content Features

Each module documentation includes:

### 📱 Detailed UI Mockups
- **Colorful ASCII art** representations of interfaces
- **Realistic data examples** with practical scenarios
- **Responsive design** considerations for desktop, tablet, and mobile
- **Status indicators** with proper color coding

### 📋 Comprehensive Field Specifications
- **Complete field tables** with data types, validation rules, and default values
- **Required vs optional** field indicators
- **Field relationships** and dependencies
- **Validation rules** and constraints

### 🎨 Design Guidelines
- **Color schemes** and status indicators
- **Icon usage** standards
- **Typography** and layout principles
- **Accessibility** considerations

### 🔄 Workflow Documentation
- **Step-by-step processes** for common tasks
- **User interaction flows** with detailed scenarios
- **Error handling** and validation feedback
- **Success confirmations** and progress indicators

## Data Flow Architecture

The RMAS system follows a hierarchical data inheritance model:

```
Manager UI (Global)
├── Device Types → Custom Fields Definition
├── Organizations → Tenant Management
└── Users → System Administration

Organization UI (Tenant-specific)
├── Device Groups → Inherit from Device Types
├── Job Templates → Target Device Groups
├── Devices → Inherit Custom Fields
├── SNMP → Monitor Devices
└── Alerts → Monitor Everything
```

### Key Inheritance Rules:
1. **Device Types** (Manager UI) define templates and custom fields
2. **Device Groups** (Organization UI) inherit device type definitions
3. **Devices** inherit custom fields based on their device type
4. **Job Templates** can target device groups or specific devices
5. **Alerts** can monitor devices, groups, or organization-wide metrics

## Module Integration

### Manager UI Integration:
- **Device Types** → Synchronized to all organizations
- **Organizations** → Each gets isolated database and settings
- **Users** → Can access multiple organizations with role-based permissions

### Organization UI Integration:
- **Device Groups** → Reference device types from Manager UI
- **Job Templates** → Target device groups for execution
- **Devices** → Members of groups, inherit custom fields
- **SNMP** → Provides monitoring data for devices
- **Alerts** → Monitor all components and trigger notifications

## Design Principles

### Manager UI
- **System-wide perspective** with multi-tenant overview
- **Administrative focus** on global configuration
- **Clean, professional** interface for system administrators
- **Centralized control** over templates and organizations

### Organization UI  
- **Tenant-specific branding** with custom colors/logos
- **Role-based access** with different views for different user types
- **Real-time monitoring** with live status updates
- **Mobile-responsive** design for field technicians

## Status Indicators

Consistent color coding throughout all interfaces:

- 🟢 **Success/Active/Online**: #4CAF50 (Green)
- 🟡 **Warning/Attention**: #FF9800 (Orange)  
- 🔴 **Error/Critical/Offline**: #F44336 (Red)
- 🔵 **Info/Processing**: #2196F3 (Blue)
- ⚪ **Unknown/Pending**: #9E9E9E (Gray)

## Getting Started

1. **Review Overview Files**: Start with `manager-ui-overview.md` and `organization-ui-overview.md`
2. **Understand Data Flow**: Read `ui-flow-structure.md` for system architecture
3. **Explore Modules**: Dive into specific `modules/` documentation for detailed implementation guidance
4. **Follow Design Guidelines**: Use the established color schemes, icons, and layout principles

## Contributing

When updating UI documentation:

1. **Maintain Consistency**: Follow established patterns and formatting
2. **Include Examples**: Provide realistic data examples in mockups
3. **Document Fields**: Complete field specifications with validation rules
4. **Update References**: Keep module cross-references current
5. **Test Flows**: Ensure user workflows are complete and logical

## Version Information

- **Created**: September 2025
- **Last Updated**: September 30, 2025
- **RMAS Version**: 1.2.3
- **Documentation Version**: 2.0.0

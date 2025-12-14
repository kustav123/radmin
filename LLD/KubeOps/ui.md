# 06. UI Design

The UI is built with React and provides a web-based interface for managing KubeOps components. It includes authentication, dashboard views, and forms for creating/managing workers and jobs.

## 06.01 Technology Stack
- React 18
- TypeScript
- Material-UI (MUI) for components
- React Router for navigation
- Axios for API calls
- JWT for authentication

## 06.02 Main Views

### 1. Login Page
- Username/password form
- "Remember me" checkbox
- Link to registration (if enabled)

### 2. Dashboard
- Overview cards showing:
  - Total workers
  - Active jobs
  - Cluster health status
  - Recent activities

### 3. Workers Management
- Table view of all workers
- Create/Edit worker modal
- Status indicators
- Actions: Edit, Delete, Toggle Status

### 4. Jobs Management
- Table view of all jobs
- Create job form
- Job execution controls
- Status monitoring
- Reconciliation triggers

### 5. Cluster Overview
- Resource listings (deployments, cronjobs, PVCs)
- Health metrics
- Namespace management
- Scaling controls

## 06.03 Component Hierarchy

```
App
├── AuthProvider
├── Router
│   ├── Login
│   ├── Dashboard
│   │   ├── StatsCards
│   │   └── RecentActivity
│   ├── Workers
│   │   ├── WorkerTable
│   │   ├── WorkerForm (modal)
│   │   └── WorkerDetails
│   ├── Jobs
│   │   ├── JobTable
│   │   ├── JobForm
│   │   └── JobExecution
│   └── Cluster
│       ├── ResourceList
│       ├── HealthMonitor
│       └── NamespaceManager
```

## 06.04 UI Mockups

### Dashboard
```
+-----------------------------------+
|           KubeOps Dashboard       |
+-----------------------------------+
| [Workers: 5] [Jobs: 12] [Health: OK] |
+-----------------------------------+
| Recent Jobs:                      |
| - redis-deploy (completed)        |
| - kafka-setup (running)           |
| - postgres-backup (pending)       |
+-----------------------------------+
```

### Worker Management
```
Workers
+----+-------------+-------+--------+--------+
| ID | Name        | Type  | Status | Actions|
+----+-------------+-------+--------+--------+
| 1  | helm-redis  | helm  | active | [E][D] |
| 2  | kubectl-pg  | kubectl| active | [E][D] |
+----+-------------+-------+--------+--------+
[Create Worker]
```

### Job Creation Form
```
Create New Job
Name: [____________________]
Namespace: [_________________]
Worker: [v] helm-redis
Arguments:
{
  "chart": "bitnami/redis",
  "values": {
    "replicas": 1
  }
}
Artifacts:
[Choose Files...] [values.yaml, config.yml]
Uploaded Files:
- values.yaml (1.2 KB) [Remove]
- config.yml (512 B) [Remove]
[Create] [Cancel]
```

## 06.05 State Management

- React Context for authentication state
- Local component state for forms
- Real-time updates via polling or WebSockets (future enhancement)

## 06.06 Responsive Design

- Mobile-first approach
- Collapsible sidebar for navigation
- Responsive tables with horizontal scroll
- Adaptive layouts for different screen sizes

## 06.07 Error Handling

- Toast notifications for API errors
- Form validation with error messages
- Loading states for async operations
- Retry mechanisms for failed requests

## 06.07 Role-Based UI Access

The UI dynamically shows/hides elements based on user roles:

### Admin Role UI Elements
- Full access to all features
- User management section
- System configuration options
- All CRUD operations visible
- Advanced cluster management controls

### Operator Role UI Elements
- Job and worker management (create, edit, delete)
- Artifact upload/download
- Job execution and reconciliation controls
- Health check scheduling
- Cluster resource viewing and basic management

### User Role UI Elements
- Read-only dashboard with status information
- Job status monitoring
- Worker information display
- Cluster health overview
- Basic metrics and logs viewing
- No create/edit/delete buttons
- No upload or execution controls

### Implementation
```javascript
// Role-based component visibility
const AdminOnly = ({ children, userRole }) => 
  userRole === 'admin' ? children : null;

const OperatorOrAdmin = ({ children, userRole }) => 
  ['admin', 'operator'].includes(userRole) ? children : null;

// Usage in components
<OperatorOrAdmin userRole={currentUser.role}>
  <Button onClick={executeJob}>Execute Job</Button>
</OperatorOrAdmin>

<AdminOnly userRole={currentUser.role}>
  <UserManagement />
</AdminOnly>
```

## 06.08 Security

- JWT token storage in httpOnly cookies
- Automatic token refresh
- Route protection for authenticated pages
- Input sanitization and validation
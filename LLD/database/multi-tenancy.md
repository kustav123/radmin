# Multi-Tenancy Strategy

This document outlines the multi-tenant architecture strategy for the agent-based remote monitoring system. The system implements a **Database-per-Tenant** approach with shared application instances to ensure complete data isolation while maintaining operational efficiency.

## Multi-Tenancy Architecture Overview

```mermaid
graph TB
    subgraph "Application Layer (Shared)"
        LaravelApp[Laravel Application<br/>Manager & Org UIs]
        AAPI1[Agent API Instance 1]
        AAPI2[Agent API Instance 2]
    end
    
    subgraph "Master Database"
        MasterDB[(Master Database<br/>Global Data)]
    end
    
    subgraph "Organization Databases"
        OrgDB1[(Organization 1<br/>Database)]
        OrgDB2[(Organization 2<br/>Database)]
        OrgDB3[(Organization 3<br/>Database)]
        OrgDBN[(Organization N<br/>Database)]
    end
    
    LaravelApp --> MasterDB
    LaravelApp --> OrgDB1
    LaravelApp --> OrgDB2
    LaravelApp --> OrgDB3
    LaravelApp --> OrgDBN
    
    AAPI1 --> OrgDB1
    AAPI1 --> OrgDB3
    AAPI2 --> OrgDB2
    AAPI2 --> OrgDBN
```

## Multi-Tenancy Models Comparison

| Aspect | Shared Database | Database per Tenant (Our Choice) | Schema per Tenant |
|--------|----------------|-----------------------------------|-------------------|
| **Data Isolation** | Low | High ✓ | Medium |
| **Security** | Application-level | Database-level ✓ | Schema-level |
| **Scalability** | Limited | High ✓ | Medium |
| **Customization** | Limited | High ✓ | Medium |
| **Maintenance** | Easy | Complex | Medium |
| **Cost per Tenant** | Low | Medium | Low |
| **Backup/Recovery** | Shared | Individual ✓ | Individual |

## Implementation Strategy

### 1. Database-per-Tenant Model

#### Benefits
- **Complete Data Isolation**: Each organization has its own PostgreSQL database
- **Enhanced Security**: No risk of cross-tenant data leaks
- **Custom Schema**: Organizations can have custom fields and tables
- **Independent Scaling**: Each database can be scaled independently
- **Isolated Backups**: Organization-specific backup and recovery
- **Compliance**: Easier to meet data residency requirements

#### Challenges and Mitigation
- **Connection Management**: Mitigated with connection pooling
- **Schema Migrations**: Automated migration scripts across all databases
- **Monitoring**: Database-specific monitoring and alerting
- **Backup Complexity**: Automated backup scheduling per organization

### 2. Tenant Identification Strategy

#### URL-based Tenant Identification
```
Manager Interface:
https://app.rmas.com/manager/

Organization Interface:
https://app.rmas.com/org/{org_slug}/

Agent API:
https://api.rmas.com/agent/
```

#### Request Flow
```mermaid
sequenceDiagram
    participant Client
    participant LaravelApp as Laravel App
    participant TenantResolver
    participant MasterDB
    participant OrgDB
    
    Client->>LaravelApp: Request to /org/acme/devices
    LaravelApp->>TenantResolver: Extract tenant (acme)
    TenantResolver->>MasterDB: Get organization details
    MasterDB->>TenantResolver: Return org info + DB connection
    TenantResolver->>LaravelApp: Set tenant context
    LaravelApp->>OrgDB: Query organization database
    OrgDB->>LaravelApp: Return data
    LaravelApp->>Client: Response with org-specific data
```

### 3. Database Connection Management

#### Connection Pool Strategy
```php
// Laravel Database Configuration
'connections' => [
    'master' => [
        'driver' => 'pgsql',
        'host' => env('DB_MASTER_HOST'),
        'database' => env('DB_MASTER_DATABASE'),
        'username' => env('DB_MASTER_USERNAME'),
        'password' => env('DB_MASTER_PASSWORD'),
    ],
    
    // Dynamic organization connections
    'organization_template' => [
        'driver' => 'pgsql',
        'host' => env('DB_ORG_HOST'),
        'username' => env('DB_ORG_USERNAME'),
        'password' => env('DB_ORG_PASSWORD'),
    ]
];
```

#### Dynamic Connection Resolution
```php
class TenantDatabaseManager
{
    public function connection(string $organizationSlug): Connection
    {
        $organization = $this->getOrganization($organizationSlug);
        
        if (!isset($this->connections[$organizationSlug])) {
            $config = config('database.connections.organization_template');
            $config['database'] = $organization->database_name;
            
            $this->connections[$organizationSlug] = $this->createConnection($config);
        }
        
        return $this->connections[$organizationSlug];
    }
}
```

#### FastAPI Connection Management
```python
class TenantDatabaseManager:
    def __init__(self):
        self.connections = {}
        self.master_engine = create_engine(MASTER_DATABASE_URL)
    
    async def get_org_connection(self, org_id: str):
        if org_id not in self.connections:
            org_info = await self.get_organization_info(org_id)
            engine = create_engine(org_info.database_url)
            self.connections[org_id] = engine
        
        return self.connections[org_id]
```

### 4. Tenant Context Management

#### Middleware Implementation
```php
class TenantContextMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Extract tenant from URL or header
        $tenantSlug = $this->extractTenant($request);
        
        if ($tenantSlug) {
            // Set tenant context
            app(TenantManager::class)->setCurrentTenant($tenantSlug);
            
            // Switch database connection
            DB::setDefaultConnection('tenant');
            config(['database.default' => 'tenant']);
        }
        
        return $next($request);
    }
}
```

#### Agent API Tenant Resolution
```python
@app.middleware("http")
async def tenant_middleware(request: Request, call_next):
    # Extract organization from agent token
    auth_header = request.headers.get("Authorization")
    if auth_header:
        token = auth_header.replace("Bearer ", "")
        org_id = await extract_org_from_token(token)
        request.state.org_id = org_id
    
    response = await call_next(request)
    return response
```

### 5. Schema Management and Migrations

#### Master Database Migrations
```sql
-- Master database schema migrations
-- Run once for the entire system
migrations/
├── master/
│   ├── 001_create_managers_table.sql
│   ├── 002_create_organizations_table.sql
│   └── 003_create_device_types_table.sql
```

#### Organization Database Template
```sql
-- Organization database template
-- Applied to each new organization database
migrations/
├── organization/
│   ├── 001_create_users_table.sql
│   ├── 002_create_devices_table.sql
│   ├── 003_create_device_groups_table.sql
│   └── 004_create_job_templates_table.sql
```

#### Migration Management
```php
class TenantMigrationCommand extends Command
{
    public function handle()
    {
        $organizations = Organization::all();
        
        foreach ($organizations as $org) {
            $this->migrateOrganization($org);
        }
    }
    
    private function migrateOrganization(Organization $org)
    {
        // Switch to organization database
        DB::setDefaultConnection($org->database_name);
        
        // Run migrations
        Artisan::call('migrate', [
            '--path' => 'database/migrations/organization',
            '--database' => $org->database_name
        ]);
    }
}
```

### 6. Data Synchronization Strategy

#### Device Type Synchronization
```mermaid
sequenceDiagram
    participant Manager as Manager UI
    participant Laravel as Laravel App
    participant Master as Master DB
    participant Orgs as Organization DBs
    
    Manager->>Laravel: Create Device Type Template
    Laravel->>Master: Store Device Type
    Laravel->>Manager: Return Success
    
    Manager->>Laravel: Push to All Organizations
    Laravel->>Master: Get All Organizations
    
    loop For Each Organization
        Laravel->>Orgs: Create Device Type Copy
        Laravel->>Orgs: Set Default Status (Enabled)
    end
    
    Laravel->>Manager: Push Complete
    
    Note over Manager,Orgs: One-way sync only
    Manager->>Laravel: Update Device Type Template
    Laravel->>Master: Update Master Template
    
    opt Push Updates to Organizations
        Laravel->>Orgs: Update All Copies
        Note over Orgs: Simple override - no conflict resolution
    end
```

#### Sync Implementation
```php
class DeviceTypeSyncService
{
    public function syncToOrganizations(DeviceType $masterDeviceType)
    {
        $organizations = Organization::where('is_active', true)->get();
        
        foreach ($organizations as $org) {
            $this->syncToOrganization($masterDeviceType, $org);
        }
    }
    
    private function syncToOrganization(DeviceType $master, Organization $org)
    {
        $orgConnection = $this->getOrgConnection($org);
        
        $existing = $orgConnection->table('device_types')
            ->where('master_device_type_id', $master->id)
            ->first();
        
        if (!$existing) {
            // Create new device type
            $this->createDeviceType($orgConnection, $master);
        } else {
            // Update existing device type (simple override)
            $this->updateDeviceType($orgConnection, $existing, $master);
        }
    }
}
```

### 7. Backup and Recovery Strategy

#### Organization-Specific Backups
```bash
#!/bin/bash
# Organization backup script

# Get list of organization databases
ORG_DATABASES=$(psql -h $DB_HOST -U $DB_USER -d rmas_master -t -c "
    SELECT database_name FROM organization_databases 
    WHERE status = 'active'
")

# Backup each organization database
for db in $ORG_DATABASES; do
    echo "Backing up $db..."
    pg_dump -h $DB_HOST -U $DB_USER $db > "backups/${db}_$(date +%Y%m%d_%H%M%S).sql"
    
    # Upload to cloud storage
    aws s3 cp "backups/${db}_$(date +%Y%m%d_%H%M%S).sql" \
        "s3://rmas-backups/organizations/$db/"
done
```

#### Automated Backup Scheduling
```yaml
# Kubernetes CronJob for organization backups
apiVersion: batch/v1
kind: CronJob
metadata:
  name: org-database-backup
spec:
  schedule: "0 2 * * *"  # Daily at 2 AM
  jobTemplate:
    spec:
      template:
        spec:
          containers:
          - name: backup
            image: postgres:14
            command: ["/scripts/backup-organizations.sh"]
            env:
            - name: DB_HOST
              value: "postgres-master"
            - name: DB_USER
              valueFrom:
                secretKeyRef:
                  name: postgres-credentials
                  key: username
```

### 8. Monitoring and Observability

#### Per-Tenant Metrics
```python
# Prometheus metrics per organization
from prometheus_client import Counter, Histogram, Gauge

# Request metrics per organization
REQUEST_COUNT = Counter(
    'rmas_requests_total',
    'Total requests',
    ['organization', 'method', 'endpoint']
)

# Database connection metrics
DB_CONNECTIONS = Gauge(
    'rmas_db_connections',
    'Active database connections',
    ['organization', 'database']
)

# Job execution metrics
JOB_EXECUTION_TIME = Histogram(
    'rmas_job_execution_seconds',
    'Job execution time',
    ['organization', 'job_type']
)
```

#### Health Check Implementation
Organization health checks are accessed through the manager UI dashboard.

```php
class OrganizationHealthCheck
{
    public function check(): array
    {
        $results = [];
        $organizations = Organization::where('is_active', true)->get();
        
        foreach ($organizations as $org) {
            $results[$org->slug] = [
                'database_status' => $this->checkDatabase($org),
                'device_count' => $this->getDeviceCount($org),
                'active_agents' => $this->getActiveAgentCount($org),
                'last_heartbeat' => $this->getLastHeartbeat($org),
            ];
        }
        
        return $results;
    }
}
```

### 9. Security Considerations

#### Cross-Tenant Security Measures
1. **Database-Level Isolation**: Each organization has its own database
2. **Connection Validation**: Verify organization context on every request
3. **Token Scoping**: Agent tokens are scoped to specific organizations
4. **Audit Logging**: Organization-specific audit trails
5. **Access Control**: Role-based permissions within organizations

#### Cross-Tenant Security Middleware
```php
class TenantSecurityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = app(TenantManager::class)->getCurrentTenant();
        
        // Validate user has access to this tenant
        if (!$this->userCanAccessTenant($request->user(), $tenant)) {
            abort(403, 'Access denied to organization');
        }
        
        // Set up query filters to prevent cross-tenant data access
        $this->setupTenantFilters($tenant);
        
        return $next($request);
    }
}
```

### 10. Scaling Considerations

#### Horizontal Scaling
- **Database Sharding**: Organization databases can be distributed across multiple servers
- **Read Replicas**: Create read replicas for high-traffic organizations
- **Connection Pooling**: Implement connection pooling to manage database connections efficiently

#### Performance Optimization
- **Database Indexing**: Organization-specific index optimization
- **Caching Strategy**: Redis with organization-scoped keys
- **CDN Integration**: Organization-specific static asset caching

#### Future Scaling Options
1. **Geographic Distribution**: Deploy organization databases closer to users
2. **Database Clustering**: Implement PostgreSQL clustering for high availability
3. **Microservices**: Split services by functionality while maintaining tenant isolation
4. **Event Sourcing**: Implement event sourcing for audit trails and replication

# System Architecture

## High-Level Architecture

```mermaid
graph TB
    subgraph "Client Layer"
        ManagerUI[Manager UI<br/>Laravel Web]
        OrgUI[Organization UI<br/>Laravel Web]
        Agent[Remote Agents<br/>Python/Go]
    end
    
    subgraph "Application Layer"
        LaravelApp[Laravel Application<br/>Manager & Organization UIs]
        AgentAPI[Agent API<br/>FastAPI]
        AuthService[Authentication Service]
    end
    
    subgraph "Database Layer"
        MasterDB[(Master Database<br/>PostgreSQL)]
        OrgDB1[(Org DB 1<br/>PostgreSQL)]
        OrgDB2[(Org DB 2<br/>PostgreSQL)]
        OrgDBN[(Org DB N<br/>PostgreSQL)]
    end
    
    ManagerUI --> LaravelApp
    OrgUI --> LaravelApp
    Agent --> AgentAPI
    
    LaravelApp --> MasterDB
    LaravelApp --> OrgDB1
    LaravelApp --> OrgDB2
    LaravelApp --> OrgDBN
    
    AgentAPI --> OrgDB1
    AgentAPI --> OrgDB2
    AgentAPI --> OrgDBN
    
    AuthService --> MasterDB
    LaravelApp --> AuthService
    AgentAPI --> AuthService
```

## Component Overview

### 1. Manager UI (Laravel)
- **Purpose**: Super admin web interface for managing organizations and global settings
- **URL**: `/manager/*`
- **Users**: System managers and super administrators
- **Features**:
  - Organization management (create, update, delete)
  - Manager user management
  - Device type templates
  - Global configurations
  - System monitoring dashboard

### 2. Organization UI (Laravel)
- **Purpose**: Organization-specific web interface for device management
- **URL**: `/org/{org_slug}/*`
- **Users**: Organization administrators and users
- **Features**:
  - Device inventory management
  - Device group management
  - Job template creation
  - Agent monitoring
  - Organization-specific reporting

### 3. Agent API (FastAPI)
- **Purpose**: High-performance API for agent communications
- **Technology**: FastAPI with async processing
- **Responsibilities**:
  - Agent registration and authentication
  - Heartbeat processing with job instructions
  - Job distribution and result collection
  - System information collection

### 4. Authentication Service
- **Purpose**: Centralized authentication and authorization
- **Features**:
  - Multi-tenant authentication
  - Token-based agent authentication
  - Role-based access control (RBAC)
  - Session management

## Data Flow Architecture

### Manager Operations Flow
```mermaid
sequenceDiagram
    participant M as Manager UI
    participant Laravel as Laravel App
    participant Auth as Auth Service
    participant MDB as Master DB
    participant ODB as Org Database
    
    M->>Laravel: Create Organization
    Laravel->>Auth: Validate Manager Permissions
    Auth->>MDB: Check Manager Role
    Laravel->>MDB: Create Organization Record
    Laravel->>ODB: Create Organization Database
    Laravel->>ODB: Initialize Default Tables
    Laravel->>M: Return Organization Details
```

### Device Management Flow
```mermaid
sequenceDiagram
    participant O as Org UI
    participant Laravel as Laravel App
    participant ODB as Org Database
    participant Agent as Remote Agent
    
    O->>Laravel: Create Device
    Laravel->>ODB: Insert Device Record
    Laravel->>ODB: Generate Device Token
    Laravel->>O: Return Device Token
    
    Note over Agent: Agent Registration
    Agent->>Laravel: Register with Token
    Laravel->>ODB: Validate Token
    Laravel->>ODB: Update Device Status
    Laravel->>Agent: Return Config & Settings
```

### Job Execution Flow
```mermaid
sequenceDiagram
    participant O as Org UI
    participant Laravel as Laravel App
    participant AAPI as Agent API
    participant ODB as Org Database
    participant Agent as Remote Agent
    
    O->>Laravel: Create Job Template
    Laravel->>ODB: Store Job Template
    O->>Laravel: Assign Job to Device Group
    Laravel->>ODB: Create Job Assignment
    
    Note over Agent: Heartbeat Cycle
    Agent->>AAPI: Send Heartbeat
    AAPI->>ODB: Check Pending Jobs
    AAPI->>Agent: Return Job Instructions
    Agent->>Agent: Execute Job
    Agent->>AAPI: Send Job Results
    AAPI->>ODB: Store Job Results
```

## Scalability Considerations

### Horizontal Scaling
- **Database Sharding**: Each organization has its own database
- **API Load Balancing**: Multiple instances of both Laravel and FastAPI
- **Stateless Design**: All services are stateless for easy scaling

### Performance Optimization
- **Caching**: Redis for session and frequently accessed data
- **Database Indexing**: Optimized indexes for query performance
- **Async Processing**: FastAPI for handling high-volume agent requests
- **Connection Pooling**: Database connection optimization

## Security Architecture

### Authentication Layers
1. **Manager Authentication**: Laravel Sanctum with session-based auth
2. **Organization Authentication**: Multi-tenant session management
3. **Agent Authentication**: Token-based authentication with device binding

### Data Isolation
- **Database Level**: Separate databases per organization
- **Application Level**: Organization context validation
- **API Level**: Route-based organization filtering

### Security Measures
- **Token Rotation**: Regular device token rotation
- **Audit Logging**: Comprehensive audit trail
- **Rate Limiting**: API rate limiting per organization
- **Encryption**: TLS for all communications

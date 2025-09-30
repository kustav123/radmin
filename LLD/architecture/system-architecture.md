# System Architecture

## Cloud-Native Architecture Overview

RMAS is built as a cloud-native system deployed on Kubernetes with operator-managed data services for high availability and scalability.

```mermaid
graph TB
    subgraph KubernetesCluster["Kubernetes Cluster"]
        subgraph WebLayer["Web Layer"]
            ManagerUI["Manager UI<br/>Laravel"]
            OrgUI["Organization UI<br/>Laravel + SNMP MIB Management"]
        end
        
        subgraph APILayer["API Layer"]
            AdminAPI["Admin API<br/>Laravel"]
            AgentAPI["Agent API<br/>FastAPI"]
            DBService["Database Service<br/>Python + CNPG API"]
        end
        
        subgraph InfraServices["Infrastructure Services"]
            subgraph RedisCluster["Redis Cluster - 6-Node"]
                RedisM1["Redis Master 1"]
                RedisM2["Redis Master 2"] 
                RedisM3["Redis Master 3"]
                RedisR1["Redis Replica 1"]
                RedisR2["Redis Replica 2"]
                RedisR3["Redis Replica 3"]
            end
            
            subgraph KafkaCluster["Kafka Cluster - KRaft"]
                KafkaB1["Kafka Broker 1"]
                KafkaB2["Kafka Broker 2"]
                KafkaB3["Kafka Broker 3"]
                KRaft["KRaft Controller<br/>No ZooKeeper"]
            end
            
            subgraph PostgreSQL["PostgreSQL - CNPG"]
                PGPrimary["PostgreSQL Primary"]
                PGReplica1["PostgreSQL Replica 1"]
                PGReplica2["PostgreSQL Replica 2"]
            end
        end
        
        subgraph MonitoringServices["Monitoring Services"]
            AdditionalMonitoring["Additional Monitoring Engine<br/>InfluxDB + Prometheus"]
            AlertEngine["Alert System<br/>Multi-channel Notifications"]
            SNMPMonitoring["SNMP Monitoring<br/>Agentless + MIB Support"]
        end
        
        subgraph K8sOperators["Kubernetes Operators"]
            StrimziOp["Strimzi Operator<br/>Kafka Management"]
            CNPGOp["CNPG Operator<br/>PostgreSQL Management"]
            RedisOp["Redis Operator<br/>Cluster Management"]
        end
    end
    
    subgraph ExternalDevices["External Devices"]
        Agents["Device Agents<br/>Python/Go"]
        SNMPDevices["SNMP Devices<br/>Network Equipment"]
        ManualDevices["Manual Entry<br/>Custom Fields"]
    end
    
    subgraph ExternalServices["External Services"]
        EmailSMTP["Email/SMTP"]
        Webhooks["Webhooks/APIs"]
        SNMPTraps["SNMP Trap Receivers"]
    end
    
    %% Web Layer Connections
    ManagerUI --> AdminAPI
    OrgUI --> AdminAPI
    OrgUI -.->|MIB Import/Export| SNMPMonitoring
    
    %% API Layer Connections
    AdminAPI --> DBService
    AgentAPI --> RedisCluster
    AgentAPI --> KafkaCluster
    DBService -.->|CNPG API| CNPGOp
    
    %% Infrastructure Connections
    RedisM1 -.-> RedisR1
    RedisM2 -.-> RedisR2
    RedisM3 -.-> RedisR3
    
    KRaft --> KafkaB1
    KRaft --> KafkaB2
    KRaft --> KafkaB3
    
    CNPGOp --> PGPrimary
    CNPGOp --> PGReplica1
    CNPGOp --> PGReplica2
    
    %% Monitoring Connections
    AdditionalMonitoring --> KafkaCluster
    AdditionalMonitoring --> RedisCluster
    AlertEngine --> KafkaCluster
    AlertEngine --> EmailSMTP
    AlertEngine --> Webhooks
    AlertEngine --> SNMPTraps
    SNMPMonitoring --> KafkaCluster
    SNMPMonitoring --> RedisCluster
    
    %% External Device Connections
    Agents --> AgentAPI
    SNMPDevices --> SNMPMonitoring
    ManualDevices --> OrgUI
    
    %% Operator Management
    StrimziOp -.->|Manages| KafkaCluster
    CNPGOp -.->|Manages| PostgreSQL
    RedisOp -.->|Manages| RedisCluster
```

## Component Overview

### 1. Manager UI (Laravel)
- **Purpose**: Super admin web interface for managing organizations and global settings
- **URL**: `/manager/*`
- **Users**: System managers and super administrators
- **Features**:
  - Organization management (create, update, delete)
  - Manager user management
  - Device type templates with custom fields
  - Global configurations
  - System monitoring dashboard
  - Global alert rule management
  - SNMP configuration templates
  - Monitoring infrastructure overview

### 2. Organization UI (Laravel)
- **Purpose**: Organization-specific web interface for device management
- **URL**: `/org/{org_slug}/*`
- **Users**: Organization administrators and users
- **Features**:
  - Device inventory management with custom fields
  - Device group management
  - Job template creation
  - Agent monitoring
  - Organization-specific reporting
  - Real-time monitoring dashboards
  - Alert management and notification settings
  - SNMP device discovery and monitoring
  - Custom device type configuration

### 3. Agent API (FastAPI)
- **Purpose**: High-performance API for agent communications
- **Technology**: FastAPI with async processing
- **Responsibilities**:
  - Agent registration and authentication
  - Heartbeat processing with job instructions
  - Job distribution and result collection
  - System information collection
  - Monitoring data streaming to Kafka
  - Custom metrics collection

### 4. Authentication Service
- **Purpose**: Centralized authentication and authorization
- **Features**:
  - Multi-tenant authentication
  - Token-based agent authentication
  - Role-based access control (RBAC)
  - Session management via Redis
  - JWT token management

### 5. Redis Cache Layer
- **Purpose**: High-performance caching and session management
- **Usage**:
  - Device name lists and active status
  - User session storage
  - Configuration caching
  - Real-time device metrics
  - Alert rule caching
  - SNMP device discovery cache

### 6. Kafka Message Broker
- **Purpose**: Reliable message streaming and event processing
- **Topics**:
  - `agent-responses`: Agent heartbeat and system information
  - `monitoring-data`: Device metrics and custom measurements
  - `audit-logs`: System audit events
  - `alert-events`: Alert triggers and notifications
  - `snmp-data`: SNMP polling results and traps

### 7. Monitoring Engine
- **Purpose**: Process monitoring data and maintain device health
- **Technology**: Python/Go microservice
- **Responsibilities**:
  - Consume monitoring data from Kafka
  - Parse custom device metrics
  - Store time-series data in InfluxDB
  - Update Prometheus metrics
  - Trigger alert conditions
  - Generate monitoring reports

### 8. Alert Engine
- **Purpose**: Process alerts and send notifications
- **Technology**: Python microservice
- **Responsibilities**:
  - Monitor alert conditions
  - Send SNMP traps
  - Execute webhook calls
  - Send email notifications
  - Manage notification escalation
  - Track alert acknowledgments

### 9. SNMP Collector
- **Purpose**: Agentless monitoring via SNMP
- **Technology**: Python service with SNMP libraries
- **Responsibilities**:
  - Active SNMP polling
  - SNMP trap receiving
  - Device discovery via SNMP
  - MIB parsing and custom OID monitoring
  - Network device health monitoring

### 10. Time-Series Databases
- **InfluxDB**: Primary time-series database for monitoring data
- **Prometheus**: Metrics collection and alerting
- **Grafana**: Visualization and dashboard platform

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
- **Message Broker Partitioning**: Kafka topic partitioning for parallel processing
- **Microservice Architecture**: Independent scaling of monitoring and alert engines

### Performance Optimization
- **Redis Caching**: Session storage, device lists, and configuration caching
- **Database Indexing**: Optimized indexes for query performance
- **Async Processing**: FastAPI for handling high-volume agent requests
- **Connection Pooling**: Database connection optimization
- **Message Streaming**: Kafka for decoupled, high-throughput data processing
- **Time-Series Optimization**: InfluxDB for efficient monitoring data storage

### Monitoring Data Pipeline
- **Real-time Processing**: Kafka Streams for live monitoring data
- **Batch Processing**: Scheduled aggregation of historical data
- **Data Retention**: Configurable retention policies for time-series data
- **Compression**: Efficient storage compression for large monitoring datasets

## Security Architecture

### Authentication Layers
1. **Manager Authentication**: Laravel Sanctum with Redis session storage
2. **Organization Authentication**: Multi-tenant session management via Redis
3. **Agent Authentication**: JWT tokens with device binding and Redis validation
4. **SNMP Authentication**: Community strings and SNMPv3 authentication

### Data Isolation
- **Database Level**: Separate databases per organization
- **Application Level**: Organization context validation
- **API Level**: Route-based organization filtering
- **Cache Level**: Redis namespace isolation per organization
- **Message Level**: Kafka topic access control per organization

### Security Measures
- **Token Rotation**: Regular device token rotation
- **Audit Logging**: Comprehensive audit trail via Kafka
- **Rate Limiting**: API rate limiting per organization
- **Encryption**: TLS for all communications and encrypted message payloads
- **SNMP Security**: SNMPv3 encryption and authentication support
- **Monitoring Security**: Encrypted monitoring data transmission

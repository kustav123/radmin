# Flow Diagrams

## Core Business Process Flows

### 1. Organization Setup Flow

```mermaid
flowchart TD
    A[Manager Login] --> B{Valid Credentials?}
    B -->|No| A
    B -->|Yes| C[Manager Dashboard]
    
    C --> D[Create Organization]
    D --> E[Fill Organization Details]
    E --> F{Validation Pass?}
    F -->|No| E
    F -->|Yes| G[Create Organization Database]
    
    G --> H[Initialize Default Tables]
    H --> I[Create Default Admin User]
    I --> J[Generate Organization URL]
    J --> K[Send Credentials to Org Admin]
    K --> L[Organization Ready]
    
    style A fill:#e1f5fe
    style L fill:#c8e6c9
    style G fill:#fff3e0
    style H fill:#fff3e0
```

### 2. Device Registration Flow

```mermaid
flowchart TD
    A[Org Admin Login] --> B[Device Management]
    B --> C[Add New Device]
    C --> D[Fill Device Details]
    D --> E[Select Device Group]
    E --> F[Select Device Type]
    F --> G[Generate Device Token]
    G --> H[Device Created]
    
    H --> I[Deploy Agent on Device]
    I --> J[Agent Startup]
    J --> K[Agent Registration Request]
    K --> L{Valid Token?}
    L -->|No| M[Registration Failed]
    L -->|Yes| N[Update Device Status]
    N --> O[Send Agent Config]
    O --> P[Agent Ready]
    
    P --> Q[Start Heartbeat Cycle]
    Q --> R[Send System Info]
    R --> S[Device Active]
    
    style A fill:#e1f5fe
    style S fill:#c8e6c9
    style M fill:#ffcdd2
    style G fill:#fff3e0
```

### 3. Job Template Creation and Execution Flow

```mermaid
flowchart TD
    A[Create Job Template] --> B[Define Job Steps]
    B --> C[Set Parameters]
    C --> D[Test Job Template]
    D --> E{Test Successful?}
    E -->|No| B
    E -->|Yes| F[Save Job Template]
    
    F --> G[Assign to Device Group]
    G --> H[Schedule Job]
    H --> I[Job in Queue]
    
    I --> J[Agent Heartbeat]
    J --> K{Pending Jobs?}
    K -->|No| J
    K -->|Yes| L[Download Job Template]
    L --> M[Validate Job Requirements]
    M --> N{Requirements Met?}
    N -->|No| O[Report Error]
    N -->|Yes| P[Execute Job]
    
    P --> Q[Monitor Execution]
    Q --> R{Job Complete?}
    R -->|No| Q
    R -->|Yes| S[Send Results]
    S --> T[Update Job Status]
    T --> U[Notify Admin]
    
    style A fill:#e1f5fe
    style U fill:#c8e6c9
    style O fill:#ffcdd2
    style H fill:#fff3e0
```

### 4. Agent Heartbeat and Monitoring Flow

```mermaid
flowchart TD
    A[Agent Startup] --> B[Initial Registration]
    B --> C[Receive Heartbeat Interval]
    C --> D[Start Heartbeat Timer]
    
    D --> E[Collect System Metrics]
    E --> F[Send Heartbeat]
    F --> G[Server Processing]
    G --> H{Valid Heartbeat?}
    H -->|No| I[Log Error]
    H -->|Yes| J[Update Last Seen]
    
    J --> K{Pending Jobs?}
    K -->|Yes| L[Return Job List]
    K -->|No| M[Return Status OK]
    
    L --> N[Download & Execute Jobs]
    M --> O[Wait for Next Interval]
    O --> D
    
    N --> P[Send Job Results]
    P --> O
    
    I --> Q{Max Retries?}
    Q -->|No| R[Retry Heartbeat]
    Q -->|Yes| S[Mark Agent Offline]
    R --> F
    
    style A fill:#e1f5fe
    style S fill:#ffcdd2
    style J fill:#c8e6c9
```

### 5. Multi-Tenant Data Access Flow

```mermaid
flowchart TD
    A[User Request] --> B[Extract Organization Context]
    B --> C{Valid Organization?}
    C -->|No| D[Return 403 Forbidden]
    C -->|Yes| E[Validate User Permissions]
    
    E --> F{User Authorized?}
    F -->|No| D
    F -->|Yes| G[Determine Database Connection]
    
    G --> H[Connect to Org Database]
    H --> I[Execute Query with Org Filter]
    I --> J[Return Filtered Results]
    
    style A fill:#e1f5fe
    style J fill:#c8e6c9
    style D fill:#ffcdd2
    style G fill:#fff3e0
```

## Detailed Process Flows

### Device Type Management Flow

```mermaid
sequenceDiagram
    participant M as Manager
    participant API as Admin API
    participant MDB as Master DB
    participant ODB as Org Databases
    
    M->>API: Create Device Type Template
    API->>MDB: Store Device Type
    API->>M: Return Success
    
    M->>API: Push to All Organizations
    API->>MDB: Get All Organizations
    
    loop For Each Organization
        API->>ODB: Create Device Type Copy
        API->>ODB: Set Default Status (Enabled)
    end
    
    API->>M: Push Complete
    
    Note over M,ODB: Organizations can now customize
    M->>API: Update Device Type Template
    API->>MDB: Update Master Template
    
    opt Sync to Organizations
        API->>ODB: Update Existing Copies
        Note over ODB: Only if not customized locally
    end
```

### Agent Authentication Flow

```mermaid
sequenceDiagram
    participant A as Agent
    participant AAPI as Agent API
    participant Auth as Auth Service
    participant ODB as Org Database
    
    A->>AAPI: Register with Device Token
    AAPI->>Auth: Validate Device Token
    Auth->>ODB: Check Token in Devices Table
    
    alt Token Valid
        Auth->>AAPI: Token Valid + Org Context
        AAPI->>ODB: Update Device Status (Online)
        AAPI->>ODB: Log Agent Registration
        AAPI->>A: Return Config + Agent Token
        
        Note over A: Store Agent Token for future requests
        
    else Token Invalid
        Auth->>AAPI: Token Invalid
        AAPI->>A: Return 401 Unauthorized
    end
    
    Note over A,ODB: Subsequent requests use Agent Token
    A->>AAPI: Heartbeat with Agent Token
    AAPI->>Auth: Validate Agent Token
    Auth->>AAPI: Token Valid + Device Context
    AAPI->>ODB: Process Heartbeat
```

### Job Distribution and Execution Flow

```mermaid
sequenceDiagram
    participant O as Org Admin
    participant API as Admin API
    participant JS as Job Scheduler
    participant AAPI as Agent API
    participant A as Agent
    participant ODB as Org Database
    
    O->>API: Create Job Assignment
    API->>ODB: Store Job Assignment
    API->>JS: Notify New Job
    
    Note over A: Regular Heartbeat Cycle
    A->>AAPI: Send Heartbeat
    AAPI->>ODB: Check Pending Jobs for Device
    
    alt Jobs Available
        AAPI->>A: Return Job List
        A->>AAPI: Request Job Details
        AAPI->>ODB: Get Job Template
        AAPI->>A: Return Job Template
        
        A->>A: Execute Job
        A->>AAPI: Send Job Progress
        AAPI->>ODB: Update Job Status
        
        A->>AAPI: Send Job Results
        AAPI->>ODB: Store Job Results
        AAPI->>JS: Notify Job Complete
        JS->>API: Send Completion Notification
        API->>O: Display Job Results
        
    else No Jobs
        AAPI->>A: Return Empty Response
    end
```

### Error Handling and Recovery Flow

```mermaid
flowchart TD
    A[Error Detected] --> B{Error Type?}
    
    B -->|Agent Offline| C[Mark Device Offline]
    B -->|Job Failed| D[Update Job Status]
    B -->|Database Error| E[Log Database Error]
    B -->|Authentication Error| F[Revoke Token]
    
    C --> G[Send Alert to Admin]
    D --> H[Retry Job if Configured]
    E --> I[Failover to Backup DB]
    F --> J[Require Re-registration]
    
    G --> K[Schedule Health Check]
    H --> L{Max Retries Reached?}
    L -->|No| M[Queue Job for Retry]
    L -->|Yes| N[Mark Job as Failed]
    
    I --> O[Resume Operations]
    J --> P[Agent Must Re-register]
    
    K --> Q[Monitor Recovery]
    M --> D
    N --> G
    
    style A fill:#ffcdd2
    style O fill:#c8e6c9
    style Q fill:#c8e6c9
```

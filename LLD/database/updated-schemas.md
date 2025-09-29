# Updated Database Schema for RMAS System

This document outlines the comprehensive database schema updates to support Redis integration, Kafka messaging, monitoring systems, alert systems, SNMP monitoring, custom device fields, and audit logging.

## Schema Overview

### New Tables Added
1. **Custom Field Management**: `custom_field_definitions`, `device_custom_fields`
2. **Monitoring Data**: `monitoring_data`, `custom_metrics`, `device_performance_metrics`
3. **Alert System**: `alert_rules`, `alert_instances`, `notification_channels`, `escalation_policies`
4. **SNMP Management**: `snmp_configurations`, `snmp_devices`, `snmp_oids`, `snmp_trap_rules`
5. **Audit Logging**: `audit_logs`, `kafka_events`, `system_events`
6. **Redis Management**: `redis_configurations`, `cache_policies`

### Updated Tables
1. **devices**: Added custom fields support
2. **device_groups**: Added device type inheritance
3. **organizations**: Added monitoring and alert configurations
4. **managers**: Added system-wide alert settings

## Organization-Specific Schema Structure

### Master Database Tables

#### Custom Field Definitions
```sql
-- Custom field definitions for device types
CREATE TABLE custom_field_definitions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    device_type_id UUID NOT NULL,
    category_name VARCHAR(100) NOT NULL,
    field_name VARCHAR(100) NOT NULL,
    field_type VARCHAR(50) NOT NULL CHECK (field_type IN ('integer', 'float', 'string', 'boolean', 'enum', 'json', 'datetime', 'url', 'email')),
    is_required BOOLEAN DEFAULT FALSE,
    default_value JSONB,
    validation_rules JSONB,
    collection_method VARCHAR(50) NOT NULL CHECK (collection_method IN ('agent', 'snmp', 'manual', 'calculated')),
    agent_source VARCHAR(255),
    snmp_oid VARCHAR(255),
    calculation_formula TEXT,
    unit VARCHAR(50),
    description TEXT,
    display_order INTEGER DEFAULT 1,
    is_searchable BOOLEAN DEFAULT FALSE,
    is_filterable BOOLEAN DEFAULT FALSE,
    show_in_list BOOLEAN DEFAULT FALSE,
    show_in_dashboard BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    UNIQUE(organization_id, device_type_id, category_name, field_name),
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (device_type_id) REFERENCES device_types(id) ON DELETE CASCADE
);

-- Indexes for performance
CREATE INDEX idx_custom_field_definitions_org_device_type ON custom_field_definitions(organization_id, device_type_id);
CREATE INDEX idx_custom_field_definitions_collection_method ON custom_field_definitions(collection_method);
CREATE INDEX idx_custom_field_definitions_searchable ON custom_field_definitions(is_searchable) WHERE is_searchable = TRUE;
CREATE INDEX idx_custom_field_definitions_filterable ON custom_field_definitions(is_filterable) WHERE is_filterable = TRUE;

-- Sample data
INSERT INTO custom_field_definitions (organization_id, device_type_id, category_name, field_name, field_type, is_required, default_value, validation_rules, collection_method, agent_source, unit, description, display_order, is_searchable, is_filterable, show_in_list, show_in_dashboard) VALUES
('550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', 'hardware_specs', 'cpu_cores', 'integer', TRUE, '4', '{"min": 1, "max": 128}', 'agent', 'system_info.hardware.cpu.cores', 'cores', 'Number of CPU cores', 1, TRUE, TRUE, TRUE, TRUE),
('550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', 'hardware_specs', 'ram_gb', 'integer', TRUE, '8', '{"min": 1, "max": 1024}', 'agent', 'system_info.hardware.memory.total_gb', 'GB', 'System memory in gigabytes', 2, TRUE, TRUE, TRUE, TRUE),
('550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', 'business_info', 'department', 'enum', TRUE, '"IT"', '{"allowed_values": ["IT", "Finance", "HR", "Marketing", "Operations"]}', 'manual', NULL, NULL, 'Department this device belongs to', 1, TRUE, TRUE, TRUE, TRUE);
```

#### Device Custom Fields Data
```sql
-- Storage for actual custom field values per device
CREATE TABLE device_custom_fields (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    device_id UUID NOT NULL,
    organization_id UUID NOT NULL,
    category_name VARCHAR(100) NOT NULL,
    field_name VARCHAR(100) NOT NULL,
    field_value JSONB,
    data_type VARCHAR(50) NOT NULL,
    collection_method VARCHAR(50) NOT NULL,
    last_updated TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    last_collected TIMESTAMP WITH TIME ZONE,
    collection_status VARCHAR(50) DEFAULT 'pending' CHECK (collection_status IN ('pending', 'collecting', 'success', 'failed', 'manual')),
    collection_error TEXT,
    validation_status VARCHAR(50) DEFAULT 'valid' CHECK (validation_status IN ('valid', 'invalid', 'pending')),
    validation_error TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(device_id, category_name, field_name),
    FOREIGN KEY (device_id) REFERENCES devices(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Indexes for performance
CREATE INDEX idx_device_custom_fields_device ON device_custom_fields(device_id);
CREATE INDEX idx_device_custom_fields_org ON device_custom_fields(organization_id);
CREATE INDEX idx_device_custom_fields_category ON device_custom_fields(category_name);
CREATE INDEX idx_device_custom_fields_collection_status ON device_custom_fields(collection_status);
CREATE INDEX idx_device_custom_fields_last_updated ON device_custom_fields(last_updated);

-- GIN index for JSONB field values (for searching)
CREATE INDEX idx_device_custom_fields_value_gin ON device_custom_fields USING GIN (field_value);

-- Sample data
INSERT INTO device_custom_fields (device_id, organization_id, category_name, field_name, field_value, data_type, collection_method, collection_status) VALUES
('550e8400-e29b-41d4-a716-446655440020', '550e8400-e29b-41d4-a716-446655440010', 'hardware_specs', 'cpu_cores', '8', 'integer', 'agent', 'success'),
('550e8400-e29b-41d4-a716-446655440020', '550e8400-e29b-41d4-a716-446655440010', 'hardware_specs', 'ram_gb', '16', 'integer', 'agent', 'success'),
('550e8400-e29b-41d4-a716-446655440020', '550e8400-e29b-41d4-a716-446655440010', 'business_info', 'department', '"IT"', 'enum', 'manual', 'manual');
```

#### Monitoring Data Storage
```sql
-- Time-series monitoring data
CREATE TABLE monitoring_data (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    device_id UUID NOT NULL,
    organization_id UUID NOT NULL,
    metric_name VARCHAR(255) NOT NULL,
    metric_value NUMERIC,
    metric_unit VARCHAR(50),
    metric_type VARCHAR(50) CHECK (metric_type IN ('gauge', 'counter', 'histogram', 'summary')),
    custom_field_name VARCHAR(100), -- Link to custom field if applicable
    timestamp TIMESTAMP WITH TIME ZONE NOT NULL,
    collection_method VARCHAR(50) CHECK (collection_method IN ('agent', 'snmp', 'calculated')),
    tags JSONB, -- Additional metadata tags
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (device_id) REFERENCES devices(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Partition by month for performance
CREATE TABLE monitoring_data_y2025m01 PARTITION OF monitoring_data
    FOR VALUES FROM ('2025-01-01') TO ('2025-02-01');
CREATE TABLE monitoring_data_y2025m02 PARTITION OF monitoring_data
    FOR VALUES FROM ('2025-02-01') TO ('2025-03-01');

-- Indexes
CREATE INDEX idx_monitoring_data_device_timestamp ON monitoring_data(device_id, timestamp DESC);
CREATE INDEX idx_monitoring_data_org_timestamp ON monitoring_data(organization_id, timestamp DESC);
CREATE INDEX idx_monitoring_data_metric_name ON monitoring_data(metric_name);
CREATE INDEX idx_monitoring_data_custom_field ON monitoring_data(custom_field_name) WHERE custom_field_name IS NOT NULL;

-- GIN index for tags
CREATE INDEX idx_monitoring_data_tags_gin ON monitoring_data USING GIN (tags);
```

#### Alert System Tables
```sql
-- Alert rules configuration
CREATE TABLE alert_rules (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    rule_name VARCHAR(255) NOT NULL,
    rule_type VARCHAR(50) NOT NULL CHECK (rule_type IN ('threshold', 'anomaly', 'custom_field', 'snmp_trap', 'agent_offline')),
    target_type VARCHAR(50) NOT NULL CHECK (target_type IN ('device', 'device_group', 'organization')),
    target_id UUID, -- device_id, group_id, or NULL for organization-wide
    metric_name VARCHAR(255),
    custom_field_name VARCHAR(100),
    condition_operator VARCHAR(20) CHECK (condition_operator IN ('>', '<', '>=', '<=', '=', '!=', 'contains', 'not_contains')),
    threshold_value NUMERIC,
    severity VARCHAR(20) NOT NULL CHECK (severity IN ('low', 'medium', 'high', 'critical')),
    evaluation_interval INTEGER DEFAULT 300, -- seconds
    evaluation_window INTEGER DEFAULT 600, -- seconds
    consecutive_breaches INTEGER DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    notification_channels UUID[], -- Array of notification channel IDs
    escalation_policy_id UUID,
    rule_conditions JSONB, -- Complex rule conditions
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (escalation_policy_id) REFERENCES escalation_policies(id)
);

-- Indexes
CREATE INDEX idx_alert_rules_org ON alert_rules(organization_id);
CREATE INDEX idx_alert_rules_target ON alert_rules(target_type, target_id);
CREATE INDEX idx_alert_rules_active ON alert_rules(is_active) WHERE is_active = TRUE;
CREATE INDEX idx_alert_rules_metric ON alert_rules(metric_name);

-- Alert instances (actual alerts triggered)
CREATE TABLE alert_instances (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    alert_rule_id UUID NOT NULL,
    organization_id UUID NOT NULL,
    device_id UUID,
    alert_state VARCHAR(20) NOT NULL CHECK (alert_state IN ('firing', 'resolved', 'acknowledged', 'suppressed')),
    severity VARCHAR(20) NOT NULL,
    triggered_at TIMESTAMP WITH TIME ZONE NOT NULL,
    resolved_at TIMESTAMP WITH TIME ZONE,
    acknowledged_at TIMESTAMP WITH TIME ZONE,
    acknowledged_by UUID,
    current_value NUMERIC,
    threshold_value NUMERIC,
    breach_count INTEGER DEFAULT 1,
    alert_details JSONB,
    notification_status JSONB, -- Status of each notification attempt
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (alert_rule_id) REFERENCES alert_rules(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (device_id) REFERENCES devices(id) ON DELETE SET NULL
);

-- Indexes
CREATE INDEX idx_alert_instances_rule ON alert_instances(alert_rule_id);
CREATE INDEX idx_alert_instances_org ON alert_instances(organization_id);
CREATE INDEX idx_alert_instances_device ON alert_instances(device_id);
CREATE INDEX idx_alert_instances_state ON alert_instances(alert_state);
CREATE INDEX idx_alert_instances_triggered ON alert_instances(triggered_at DESC);

-- Notification channels
CREATE TABLE notification_channels (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    channel_name VARCHAR(255) NOT NULL,
    channel_type VARCHAR(50) NOT NULL CHECK (channel_type IN ('email', 'webhook', 'snmp_trap', 'slack', 'teams', 'sms')),
    is_active BOOLEAN DEFAULT TRUE,
    configuration JSONB NOT NULL, -- Channel-specific configuration
    test_status VARCHAR(20) DEFAULT 'untested' CHECK (test_status IN ('untested', 'success', 'failed')),
    last_test_at TIMESTAMP WITH TIME ZONE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    UNIQUE(organization_id, channel_name),
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Indexes
CREATE INDEX idx_notification_channels_org ON notification_channels(organization_id);
CREATE INDEX idx_notification_channels_type ON notification_channels(channel_type);
CREATE INDEX idx_notification_channels_active ON notification_channels(is_active) WHERE is_active = TRUE;

-- Escalation policies
CREATE TABLE escalation_policies (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    policy_name VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    escalation_steps JSONB NOT NULL, -- Array of escalation steps with timing and channels
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    UNIQUE(organization_id, policy_name),
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Sample escalation policy
INSERT INTO escalation_policies (organization_id, policy_name, escalation_steps) VALUES
('550e8400-e29b-41d4-a716-446655440010', 'Standard Escalation', 
'[
  {"step": 1, "delay_minutes": 0, "channels": ["email-ops"], "severity_filter": ["low", "medium", "high", "critical"]},
  {"step": 2, "delay_minutes": 15, "channels": ["webhook-pagerduty"], "severity_filter": ["high", "critical"]},
  {"step": 3, "delay_minutes": 30, "channels": ["sms-oncall"], "severity_filter": ["critical"]}
]');
```

#### SNMP Configuration Tables
```sql
-- SNMP device configurations
CREATE TABLE snmp_configurations (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    device_id UUID,
    device_group_id UUID,
    configuration_name VARCHAR(255) NOT NULL,
    host VARCHAR(255) NOT NULL,
    port INTEGER DEFAULT 161,
    snmp_version VARCHAR(10) NOT NULL CHECK (snmp_version IN ('v1', 'v2c', 'v3')),
    community_string VARCHAR(255), -- For v1/v2c
    security_level VARCHAR(20), -- For v3: noAuthNoPriv, authNoPriv, authPriv
    auth_protocol VARCHAR(20), -- For v3: MD5, SHA
    auth_password VARCHAR(255), -- For v3
    priv_protocol VARCHAR(20), -- For v3: DES, AES
    priv_password VARCHAR(255), -- For v3
    username VARCHAR(255), -- For v3
    polling_interval INTEGER DEFAULT 300, -- seconds
    timeout INTEGER DEFAULT 10, -- seconds
    retries INTEGER DEFAULT 3,
    is_active BOOLEAN DEFAULT TRUE,
    last_poll_at TIMESTAMP WITH TIME ZONE,
    last_poll_status VARCHAR(20) DEFAULT 'pending' CHECK (last_poll_status IN ('pending', 'success', 'failed', 'timeout')),
    last_poll_error TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (device_id) REFERENCES devices(id) ON DELETE CASCADE,
    FOREIGN KEY (device_group_id) REFERENCES device_groups(id) ON DELETE CASCADE,
    CHECK ((device_id IS NOT NULL AND device_group_id IS NULL) OR (device_id IS NULL AND device_group_id IS NOT NULL))
);

-- Indexes
CREATE INDEX idx_snmp_configurations_org ON snmp_configurations(organization_id);
CREATE INDEX idx_snmp_configurations_device ON snmp_configurations(device_id);
CREATE INDEX idx_snmp_configurations_group ON snmp_configurations(device_group_id);
CREATE INDEX idx_snmp_configurations_active ON snmp_configurations(is_active) WHERE is_active = TRUE;
CREATE INDEX idx_snmp_configurations_next_poll ON snmp_configurations(last_poll_at, polling_interval);

-- SNMP OID definitions
CREATE TABLE snmp_oids (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    oid_name VARCHAR(255) NOT NULL,
    oid_value VARCHAR(255) NOT NULL,
    oid_type VARCHAR(50) NOT NULL CHECK (oid_type IN ('integer', 'string', 'oid', 'gauge', 'counter', 'timeticks')),
    description TEXT,
    unit VARCHAR(50),
    is_custom BOOLEAN DEFAULT FALSE,
    device_type_id UUID, -- OID applies to specific device type
    custom_field_mapping VARCHAR(100), -- Maps to custom field
    transformation_formula TEXT, -- Formula to transform SNMP value
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    UNIQUE(organization_id, oid_name),
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (device_type_id) REFERENCES device_types(id) ON DELETE SET NULL
);

-- Indexes
CREATE INDEX idx_snmp_oids_org ON snmp_oids(organization_id);
CREATE INDEX idx_snmp_oids_device_type ON snmp_oids(device_type_id);
CREATE INDEX idx_snmp_oids_custom_field ON snmp_oids(custom_field_mapping) WHERE custom_field_mapping IS NOT NULL;
CREATE INDEX idx_snmp_oids_active ON snmp_oids(is_active) WHERE is_active = TRUE;

-- Sample SNMP OIDs
INSERT INTO snmp_oids (organization_id, oid_name, oid_value, oid_type, description, unit, custom_field_mapping) VALUES
('550e8400-e29b-41d4-a716-446655440010', 'system_name', '1.3.6.1.2.1.1.5.0', 'string', 'System name', NULL, NULL),
('550e8400-e29b-41d4-a716-446655440010', 'system_uptime', '1.3.6.1.2.1.1.3.0', 'timeticks', 'System uptime', 'ticks', NULL),
('550e8400-e29b-41d4-a716-446655440010', 'cpu_usage', '1.3.6.1.4.1.2021.11.9.0', 'integer', 'CPU usage percentage', '%', 'performance_metrics.cpu_usage'),
('550e8400-e29b-41d4-a716-446655440010', 'memory_total', '1.3.6.1.4.1.2021.4.5.0', 'integer', 'Total memory', 'KB', 'hardware_specs.ram_gb');

-- SNMP trap rules
CREATE TABLE snmp_trap_rules (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    rule_name VARCHAR(255) NOT NULL,
    trap_oid VARCHAR(255) NOT NULL,
    source_ip VARCHAR(45), -- IPv4 or IPv6
    community_string VARCHAR(255),
    severity VARCHAR(20) NOT NULL CHECK (severity IN ('low', 'medium', 'high', 'critical')),
    alert_rule_id UUID, -- Link to alert rule if trap should trigger alert
    is_active BOOLEAN DEFAULT TRUE,
    match_conditions JSONB, -- Conditions for trap matching
    action_config JSONB, -- Actions to take when trap received
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    UNIQUE(organization_id, rule_name),
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE,
    FOREIGN KEY (alert_rule_id) REFERENCES alert_rules(id) ON DELETE SET NULL
);

-- Indexes
CREATE INDEX idx_snmp_trap_rules_org ON snmp_trap_rules(organization_id);
CREATE INDEX idx_snmp_trap_rules_oid ON snmp_trap_rules(trap_oid);
CREATE INDEX idx_snmp_trap_rules_source ON snmp_trap_rules(source_ip);
CREATE INDEX idx_snmp_trap_rules_active ON snmp_trap_rules(is_active) WHERE is_active = TRUE;
```

#### Audit Logging System
```sql
-- Audit logs table
CREATE TABLE audit_logs (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    user_id UUID,
    session_id VARCHAR(255),
    action VARCHAR(100) NOT NULL,
    resource_type VARCHAR(100) NOT NULL,
    resource_id VARCHAR(255),
    resource_name VARCHAR(255),
    old_values JSONB,
    new_values JSONB,
    ip_address INET,
    user_agent TEXT,
    request_id VARCHAR(255),
    correlation_id VARCHAR(255), -- For tracking related actions
    severity VARCHAR(20) DEFAULT 'info' CHECK (severity IN ('debug', 'info', 'warning', 'error', 'critical')),
    success BOOLEAN NOT NULL,
    error_message TEXT,
    duration_ms INTEGER,
    additional_data JSONB,
    timestamp TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    kafka_message_id VARCHAR(255), -- Link to Kafka message
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Partition by month for performance
CREATE TABLE audit_logs_y2025m01 PARTITION OF audit_logs
    FOR VALUES FROM ('2025-01-01') TO ('2025-02-01');
CREATE TABLE audit_logs_y2025m02 PARTITION OF audit_logs
    FOR VALUES FROM ('2025-02-01') TO ('2025-03-01');

-- Indexes
CREATE INDEX idx_audit_logs_org_timestamp ON audit_logs(organization_id, timestamp DESC);
CREATE INDEX idx_audit_logs_user ON audit_logs(user_id, timestamp DESC);
CREATE INDEX idx_audit_logs_action ON audit_logs(action);
CREATE INDEX idx_audit_logs_resource ON audit_logs(resource_type, resource_id);
CREATE INDEX idx_audit_logs_correlation ON audit_logs(correlation_id) WHERE correlation_id IS NOT NULL;

-- Kafka events tracking
CREATE TABLE kafka_events (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    topic_name VARCHAR(255) NOT NULL,
    partition_id INTEGER,
    offset_value BIGINT,
    message_key VARCHAR(500),
    message_id VARCHAR(255) UNIQUE,
    event_type VARCHAR(100) NOT NULL,
    event_data JSONB,
    producer_id VARCHAR(255),
    correlation_id VARCHAR(255),
    timestamp TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    processed_at TIMESTAMP WITH TIME ZONE,
    processing_status VARCHAR(20) DEFAULT 'pending' CHECK (processing_status IN ('pending', 'processing', 'processed', 'failed', 'dead_letter')),
    processing_error TEXT,
    retry_count INTEGER DEFAULT 0,
    
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Partition by day for high-volume events
CREATE TABLE kafka_events_y2025m01d01 PARTITION OF kafka_events
    FOR VALUES FROM ('2025-01-01') TO ('2025-01-02');

-- Indexes
CREATE INDEX idx_kafka_events_org_timestamp ON kafka_events(organization_id, timestamp DESC);
CREATE INDEX idx_kafka_events_topic ON kafka_events(topic_name, partition_id, offset_value);
CREATE INDEX idx_kafka_events_message_id ON kafka_events(message_id);
CREATE INDEX idx_kafka_events_status ON kafka_events(processing_status);
CREATE INDEX idx_kafka_events_correlation ON kafka_events(correlation_id) WHERE correlation_id IS NOT NULL;

-- System events for manager-level operations
CREATE TABLE system_events (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    event_type VARCHAR(100) NOT NULL,
    event_category VARCHAR(50) NOT NULL CHECK (event_category IN ('system', 'security', 'performance', 'maintenance')),
    severity VARCHAR(20) NOT NULL CHECK (severity IN ('debug', 'info', 'warning', 'error', 'critical')),
    source_component VARCHAR(100) NOT NULL,
    event_data JSONB,
    affected_organizations UUID[],
    correlation_id VARCHAR(255),
    timestamp TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP WITH TIME ZONE,
    resolution_notes TEXT,
    created_by_system BOOLEAN DEFAULT TRUE
);

-- Indexes
CREATE INDEX idx_system_events_timestamp ON system_events(timestamp DESC);
CREATE INDEX idx_system_events_type ON system_events(event_type);
CREATE INDEX idx_system_events_category ON system_events(event_category);
CREATE INDEX idx_system_events_severity ON system_events(severity);
CREATE INDEX idx_system_events_correlation ON system_events(correlation_id) WHERE correlation_id IS NOT NULL;

-- GIN index for affected organizations array
CREATE INDEX idx_system_events_orgs_gin ON system_events USING GIN (affected_organizations);
```

#### Redis Configuration Management
```sql
-- Redis configurations per organization
CREATE TABLE redis_configurations (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    configuration_name VARCHAR(255) NOT NULL,
    redis_host VARCHAR(255) NOT NULL,
    redis_port INTEGER DEFAULT 6379,
    redis_database INTEGER DEFAULT 0,
    password_encrypted TEXT,
    connection_pool_size INTEGER DEFAULT 10,
    connection_timeout INTEGER DEFAULT 5000, -- milliseconds
    command_timeout INTEGER DEFAULT 5000, -- milliseconds
    retry_attempts INTEGER DEFAULT 3,
    cache_policies JSONB, -- Cache policies configuration
    is_active BOOLEAN DEFAULT TRUE,
    last_health_check TIMESTAMP WITH TIME ZONE,
    health_status VARCHAR(20) DEFAULT 'unknown' CHECK (health_status IN ('healthy', 'degraded', 'unhealthy', 'unknown')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    created_by UUID,
    updated_by UUID,
    
    UNIQUE(organization_id, configuration_name),
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Cache policies for different data types
CREATE TABLE cache_policies (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    organization_id UUID NOT NULL,
    policy_name VARCHAR(255) NOT NULL,
    data_type VARCHAR(100) NOT NULL, -- device_list, session_data, monitoring_data, etc.
    ttl_seconds INTEGER NOT NULL,
    max_memory_mb INTEGER,
    eviction_policy VARCHAR(50) DEFAULT 'allkeys-lru' CHECK (eviction_policy IN ('noeviction', 'allkeys-lru', 'volatile-lru', 'allkeys-random', 'volatile-random', 'volatile-ttl')),
    compression_enabled BOOLEAN DEFAULT FALSE,
    encryption_enabled BOOLEAN DEFAULT FALSE,
    replication_factor INTEGER DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(organization_id, policy_name),
    FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE
);

-- Sample cache policies
INSERT INTO cache_policies (organization_id, policy_name, data_type, ttl_seconds, max_memory_mb) VALUES
('550e8400-e29b-41d4-a716-446655440010', 'Device List Cache', 'device_list', 1800, 100),
('550e8400-e29b-41d4-a716-446655440010', 'Session Data Cache', 'session_data', 3600, 50),
('550e8400-e29b-41d4-a716-446655440010', 'Monitoring Data Cache', 'monitoring_data', 300, 200),
('550e8400-e29b-41d4-a716-446655440010', 'SNMP Data Cache', 'snmp_data', 600, 150);
```

## Updated Existing Tables

### Devices Table Updates
```sql
-- Add custom fields support to devices table
ALTER TABLE devices ADD COLUMN device_type_id UUID;
ALTER TABLE devices ADD COLUMN custom_fields_last_updated TIMESTAMP WITH TIME ZONE;
ALTER TABLE devices ADD COLUMN custom_fields_collection_status VARCHAR(20) DEFAULT 'pending' 
    CHECK (custom_fields_collection_status IN ('pending', 'collecting', 'complete', 'failed'));
ALTER TABLE devices ADD COLUMN monitoring_enabled BOOLEAN DEFAULT TRUE;
ALTER TABLE devices ADD COLUMN snmp_enabled BOOLEAN DEFAULT FALSE;
ALTER TABLE devices ADD COLUMN alert_enabled BOOLEAN DEFAULT TRUE;

-- Add foreign key constraint
ALTER TABLE devices ADD CONSTRAINT fk_devices_device_type 
    FOREIGN KEY (device_type_id) REFERENCES device_types(id) ON DELETE SET NULL;

-- Add indexes
CREATE INDEX idx_devices_device_type ON devices(device_type_id);
CREATE INDEX idx_devices_custom_fields_status ON devices(custom_fields_collection_status);
CREATE INDEX idx_devices_monitoring_enabled ON devices(monitoring_enabled) WHERE monitoring_enabled = TRUE;
```

### Device Groups Table Updates
```sql
-- Add device type inheritance to device groups
ALTER TABLE device_groups ADD COLUMN device_type_id UUID;
ALTER TABLE device_groups ADD COLUMN inherit_custom_fields BOOLEAN DEFAULT TRUE;
ALTER TABLE device_groups ADD COLUMN custom_field_overrides JSONB;
ALTER TABLE device_groups ADD COLUMN monitoring_profile JSONB;
ALTER TABLE device_groups ADD COLUMN alert_profile JSONB;

-- Add foreign key constraint
ALTER TABLE device_groups ADD CONSTRAINT fk_device_groups_device_type 
    FOREIGN KEY (device_type_id) REFERENCES device_types(id) ON DELETE SET NULL;

-- Add indexes
CREATE INDEX idx_device_groups_device_type ON device_groups(device_type_id);
CREATE INDEX idx_device_groups_inherit_fields ON device_groups(inherit_custom_fields) WHERE inherit_custom_fields = TRUE;
```

### Organizations Table Updates
```sql
-- Add monitoring and alert configurations
ALTER TABLE organizations ADD COLUMN monitoring_config JSONB;
ALTER TABLE organizations ADD COLUMN alert_config JSONB;
ALTER TABLE organizations ADD COLUMN redis_config JSONB;
ALTER TABLE organizations ADD COLUMN kafka_config JSONB;
ALTER TABLE organizations ADD COLUMN snmp_config JSONB;
ALTER TABLE organizations ADD COLUMN custom_fields_enabled BOOLEAN DEFAULT TRUE;
ALTER TABLE organizations ADD COLUMN audit_retention_days INTEGER DEFAULT 90;

-- Sample monitoring configuration
UPDATE organizations SET monitoring_config = '{
    "data_retention_days": 30,
    "metrics_collection_interval": 300,
    "custom_metrics_enabled": true,
    "real_time_dashboards": true,
    "influxdb_config": {
        "database": "org_550e8400_monitoring",
        "retention_policy": "30d"
    },
    "prometheus_config": {
        "scrape_interval": "30s",
        "evaluation_interval": "30s"
    }
}' WHERE id = '550e8400-e29b-41d4-a716-446655440010';

-- Sample alert configuration
UPDATE organizations SET alert_config = '{
    "max_alerts_per_hour": 100,
    "default_escalation_policy": "550e8400-e29b-41d4-a716-446655440100",
    "alert_aggregation_window": 300,
    "auto_resolve_timeout": 3600,
    "notification_rate_limits": {
        "email": 10,
        "webhook": 50,
        "sms": 5
    }
}' WHERE id = '550e8400-e29b-41d4-a716-446655440010';
```

### Managers Table Updates
```sql
-- Add system-wide alert and monitoring settings
ALTER TABLE managers ADD COLUMN system_alert_config JSONB;
ALTER TABLE managers ADD COLUMN system_monitoring_config JSONB;
ALTER TABLE managers ADD COLUMN kafka_admin_config JSONB;
ALTER TABLE managers ADD COLUMN redis_admin_config JSONB;

-- Sample system alert configuration
UPDATE managers SET system_alert_config = '{
    "system_health_alerts": true,
    "performance_alerts": true,
    "security_alerts": true,
    "maintenance_notifications": true,
    "alert_channels": ["email", "webhook"],
    "escalation_timeout": 1800
}' WHERE id = '550e8400-e29b-41d4-a716-446655440000';
```

## Database Views for Performance

### Device Custom Fields Summary View
```sql
CREATE VIEW device_custom_fields_summary AS
SELECT 
    d.id as device_id,
    d.device_name,
    d.organization_id,
    dt.device_type_name,
    COUNT(dcf.id) as total_custom_fields,
    COUNT(CASE WHEN dcf.collection_status = 'success' THEN 1 END) as collected_fields,
    COUNT(CASE WHEN dcf.collection_status = 'failed' THEN 1 END) as failed_fields,
    COUNT(CASE WHEN dcf.collection_status = 'pending' THEN 1 END) as pending_fields,
    MAX(dcf.last_updated) as last_field_update,
    ARRAY_AGG(DISTINCT dcf.category_name) as field_categories
FROM devices d
LEFT JOIN device_types dt ON d.device_type_id = dt.id
LEFT JOIN device_custom_fields dcf ON d.id = dcf.device_id
GROUP BY d.id, d.device_name, d.organization_id, dt.device_type_name;

-- View for monitoring data aggregation
CREATE VIEW monitoring_data_hourly AS
SELECT 
    device_id,
    organization_id,
    metric_name,
    DATE_TRUNC('hour', timestamp) as hour,
    AVG(metric_value) as avg_value,
    MIN(metric_value) as min_value,
    MAX(metric_value) as max_value,
    COUNT(*) as sample_count
FROM monitoring_data
WHERE timestamp >= NOW() - INTERVAL '7 days'
GROUP BY device_id, organization_id, metric_name, DATE_TRUNC('hour', timestamp);

-- View for active alerts summary
CREATE VIEW active_alerts_summary AS
SELECT 
    ai.organization_id,
    ai.device_id,
    d.device_name,
    ar.rule_name,
    ai.severity,
    ai.alert_state,
    ai.triggered_at,
    ai.current_value,
    ai.threshold_value,
    EXTRACT(EPOCH FROM (NOW() - ai.triggered_at)) / 60 as duration_minutes
FROM alert_instances ai
JOIN alert_rules ar ON ai.alert_rule_id = ar.id
LEFT JOIN devices d ON ai.device_id = d.id
WHERE ai.alert_state IN ('firing', 'acknowledged');
```

## Database Functions and Triggers

### Custom Fields Validation Function
```sql
CREATE OR REPLACE FUNCTION validate_custom_field_value()
RETURNS TRIGGER AS $$
DECLARE
    field_def RECORD;
    validation_rules JSONB;
    field_value_text TEXT;
    min_val NUMERIC;
    max_val NUMERIC;
    allowed_values TEXT[];
BEGIN
    -- Get field definition
    SELECT * INTO field_def
    FROM custom_field_definitions cfd
    WHERE cfd.organization_id = NEW.organization_id
    AND cfd.category_name = NEW.category_name
    AND cfd.field_name = NEW.field_name
    LIMIT 1;
    
    IF NOT FOUND THEN
        RAISE EXCEPTION 'Custom field definition not found: %.%', NEW.category_name, NEW.field_name;
    END IF;
    
    validation_rules := field_def.validation_rules;
    field_value_text := NEW.field_value #>> '{}';
    
    -- Validate based on field type
    CASE field_def.field_type
        WHEN 'integer' THEN
            -- Check if value is numeric
            IF field_value_text !~ '^-?\d+$' THEN
                RAISE EXCEPTION 'Invalid integer value: %', field_value_text;
            END IF;
            
            -- Check min/max constraints
            IF validation_rules ? 'min' THEN
                min_val := (validation_rules->>'min')::NUMERIC;
                IF field_value_text::NUMERIC < min_val THEN
                    RAISE EXCEPTION 'Value % is below minimum %', field_value_text, min_val;
                END IF;
            END IF;
            
            IF validation_rules ? 'max' THEN
                max_val := (validation_rules->>'max')::NUMERIC;
                IF field_value_text::NUMERIC > max_val THEN
                    RAISE EXCEPTION 'Value % is above maximum %', field_value_text, max_val;
                END IF;
            END IF;
            
        WHEN 'enum' THEN
            -- Check if value is in allowed list
            IF validation_rules ? 'allowed_values' THEN
                allowed_values := ARRAY(SELECT jsonb_array_elements_text(validation_rules->'allowed_values'));
                IF NOT (field_value_text = ANY(allowed_values)) THEN
                    RAISE EXCEPTION 'Value % not in allowed values: %', field_value_text, allowed_values;
                END IF;
            END IF;
    END CASE;
    
    -- Set validation status
    NEW.validation_status := 'valid';
    NEW.validation_error := NULL;
    
    RETURN NEW;
    
EXCEPTION WHEN OTHERS THEN
    NEW.validation_status := 'invalid';
    NEW.validation_error := SQLERRM;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create trigger
CREATE TRIGGER trigger_validate_custom_field_value
    BEFORE INSERT OR UPDATE ON device_custom_fields
    FOR EACH ROW
    EXECUTE FUNCTION validate_custom_field_value();
```

### Audit Logging Trigger
```sql
CREATE OR REPLACE FUNCTION audit_table_changes()
RETURNS TRIGGER AS $$
DECLARE
    audit_data JSONB;
    org_id UUID;
    user_id UUID;
BEGIN
    -- Determine organization ID based on table
    CASE TG_TABLE_NAME
        WHEN 'devices', 'device_custom_fields', 'alert_instances' THEN
            org_id := COALESCE(NEW.organization_id, OLD.organization_id);
        WHEN 'custom_field_definitions', 'alert_rules' THEN
            org_id := COALESCE(NEW.organization_id, OLD.organization_id);
        ELSE
            org_id := NULL;
    END CASE;
    
    -- Get current user from session (would be set by application)
    user_id := current_setting('app.current_user_id', true)::UUID;
    
    -- Prepare audit data
    audit_data := jsonb_build_object(
        'table_name', TG_TABLE_NAME,
        'operation', TG_OP,
        'old_values', CASE WHEN TG_OP IN ('UPDATE', 'DELETE') THEN row_to_json(OLD) ELSE NULL END,
        'new_values', CASE WHEN TG_OP IN ('INSERT', 'UPDATE') THEN row_to_json(NEW) ELSE NULL END
    );
    
    -- Insert audit record
    INSERT INTO audit_logs (
        organization_id,
        user_id,
        action,
        resource_type,
        resource_id,
        old_values,
        new_values,
        success,
        additional_data
    ) VALUES (
        org_id,
        user_id,
        TG_OP,
        TG_TABLE_NAME,
        COALESCE(NEW.id::TEXT, OLD.id::TEXT),
        CASE WHEN TG_OP IN ('UPDATE', 'DELETE') THEN row_to_json(OLD)::JSONB ELSE NULL END,
        CASE WHEN TG_OP IN ('INSERT', 'UPDATE') THEN row_to_json(NEW)::JSONB ELSE NULL END,
        true,
        audit_data
    );
    
    RETURN COALESCE(NEW, OLD);
END;
$$ LANGUAGE plpgsql;

-- Apply audit trigger to key tables
CREATE TRIGGER audit_custom_field_definitions
    AFTER INSERT OR UPDATE OR DELETE ON custom_field_definitions
    FOR EACH ROW EXECUTE FUNCTION audit_table_changes();

CREATE TRIGGER audit_device_custom_fields
    AFTER INSERT OR UPDATE OR DELETE ON device_custom_fields
    FOR EACH ROW EXECUTE FUNCTION audit_table_changes();

CREATE TRIGGER audit_alert_rules
    AFTER INSERT OR UPDATE OR DELETE ON alert_rules
    FOR EACH ROW EXECUTE FUNCTION audit_table_changes();
```

## Performance Optimization

### Partitioning Strategy
```sql
-- Function to create monthly partitions automatically
CREATE OR REPLACE FUNCTION create_monthly_partition(table_name TEXT, start_date DATE)
RETURNS VOID AS $$
DECLARE
    partition_name TEXT;
    end_date DATE;
BEGIN
    partition_name := table_name || '_y' || EXTRACT(YEAR FROM start_date) || 'm' || LPAD(EXTRACT(MONTH FROM start_date)::TEXT, 2, '0');
    end_date := start_date + INTERVAL '1 month';
    
    EXECUTE format('CREATE TABLE IF NOT EXISTS %I PARTITION OF %I FOR VALUES FROM (%L) TO (%L)',
                   partition_name, table_name, start_date, end_date);
    
    EXECUTE format('CREATE INDEX IF NOT EXISTS idx_%s_timestamp ON %I (timestamp)',
                   partition_name, partition_name);
END;
$$ LANGUAGE plpgsql;

-- Create partitions for next 12 months
DO $$
DECLARE
    current_month DATE := DATE_TRUNC('month', CURRENT_DATE);
    i INTEGER;
BEGIN
    FOR i IN 0..11 LOOP
        PERFORM create_monthly_partition('monitoring_data', current_month + (i || ' months')::INTERVAL);
        PERFORM create_monthly_partition('audit_logs', current_month + (i || ' months')::INTERVAL);
    END LOOP;
END $$;
```

This comprehensive database schema provides the foundation for all the new features while maintaining performance and data integrity. The schema supports multi-tenancy, scalability, and provides audit trails for all operations.

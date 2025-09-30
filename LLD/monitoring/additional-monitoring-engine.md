# Additional Monitoring Engine

The RMAS Additional Monitoring Engine provides comprehensive custom device monitoring capabilities using InfluxDB for time-series data storage, Prometheus for metrics collection, and custom field monitoring independent of the core RMAS system.

## Additional Monitoring Architecture

### Overview
```mermaid
graph TB
    subgraph DataSources["Data Sources"]
        Agents["Remote Agents<br/>Custom Metrics"]
        CustomFields["Custom Device Fields<br/>Hardware Specs"]
        CalculatedMetrics["Calculated Metrics<br/>Performance Indexes"]
        ManualEntry["Manual Entry<br/>Business Metrics"]
    end
    
    subgraph DataCollection["Data Collection"]
        AgentAPI["Agent API<br/>FastAPI"]
        CustomFieldProcessor["Custom Field Processor"]
        MetricsAggregator["Metrics Aggregator"]
    end
    
    subgraph MessageLayer["Message Layer"]
        KafkaCluster["Kafka Cluster KRaft<br/>monitoring-data topic"]
    end
    
    subgraph MonitoringEngine["Additional Monitoring Engine"]
        MonitoringEngine["Additional Monitoring Engine<br/>Python Microservice"]
        DataProcessor["Custom Data Processor"]
        CustomFieldsEngine["Custom Fields Engine"]
        MetricsCalculator["Metrics Calculator"]
    end
    
    subgraph StorageLayer["Storage Layer"]
        InfluxDB["InfluxDB<br/>Time-Series Database"]
        Prometheus[Prometheus<br/>Metrics Storage]
        RedisCluster[Redis Cluster<br/>Real-time Cache]
    end
    
    subgraph "Visualization"
        Grafana[Grafana<br/>Custom Dashboards]
        RealTimeDashboard[Real-time Dashboard<br/>WebSocket]
        CustomReports[Custom Reports<br/>Organization Specific]
    end
    
    %% Data flow
    Agents --> AgentAPI
    CustomFields --> CustomFieldProcessor
    CalculatedMetrics --> MetricsAggregator
    ManualEntry --> CustomFieldProcessor
    
    AgentAPI --> KafkaCluster
    CustomFieldProcessor --> KafkaCluster
    MetricsAggregator --> KafkaCluster
    
    KafkaCluster --> MonitoringEngine
    MonitoringEngine --> DataProcessor
    DataProcessor --> CustomFieldsEngine
    CustomFieldsEngine --> MetricsCalculator
    
    MonitoringEngine --> InfluxDB
    MonitoringEngine --> Prometheus
    MonitoringEngine --> RedisCluster
    
    InfluxDB --> Grafana
    Prometheus --> Grafana
    RedisCluster --> RealTimeDashboard
    MonitoringEngine --> CustomReports
```

## Custom Monitoring Features

### Independent Module Design
The Additional Monitoring Engine operates as an independent module that:

1. **Custom Field Integration**: Monitors custom device fields defined in device types
2. **Performance Metrics**: Calculates performance indexes from hardware specifications
3. **Business Metrics**: Tracks department allocations, cost centers, warranty status
4. **Real-time Processing**: Provides live monitoring data via WebSocket connections
5. **Historical Analysis**: Maintains long-term trends for capacity planning

### Custom Field Monitoring
```python
class CustomFieldMonitoringEngine:
    def __init__(self, kafka_client, influxdb_client, redis_cluster):
        self.kafka_client = kafka_client
        self.influxdb_client = influxdb_client
        self.redis_cluster = redis_cluster
        self.field_processors = {
            'hardware_specs': HardwareSpecsProcessor(),
            'performance_metrics': PerformanceMetricsProcessor(),
            'business_info': BusinessInfoProcessor(),
            'location_info': LocationInfoProcessor()
        }
    
    async def process_custom_field_data(self, device_id: str, org_id: str, 
                                      field_data: Dict):
        """Process custom field data and generate monitoring metrics"""
        
        monitoring_points = []
        
        for category, data in field_data.items():
            if category in self.field_processors:
                processor = self.field_processors[category]
                points = await processor.process_category_data(
                    device_id, org_id, data
                )
                monitoring_points.extend(points)
        
        # Store in InfluxDB
        await self.store_monitoring_points(monitoring_points)
        
        # Update real-time cache
        await self.update_realtime_cache(device_id, monitoring_points)
        
        # Calculate derived metrics
        await self.calculate_derived_metrics(device_id, monitoring_points)
        
        return monitoring_points

class HardwareSpecsProcessor:
    async def process_category_data(self, device_id: str, org_id: str, 
                                  hardware_data: Dict) -> List[MonitoringPoint]:
        """Process hardware specifications data"""
        
        points = []
        
        # CPU utilization efficiency
        if 'cpu_cores' in hardware_data and 'cpu_usage' in hardware_data:
            cpu_efficiency = await self.calculate_cpu_efficiency(
                hardware_data['cpu_cores']['value'],
                hardware_data.get('cpu_usage', {}).get('value', 0)
            )
            
            points.append(MonitoringPoint(
                measurement='hardware_efficiency',
                tags={
                    'device_id': device_id,
                    'organization_id': org_id,
                    'metric_type': 'cpu_efficiency'
                },
                fields={'value': cpu_efficiency},
                timestamp=datetime.utcnow()
            ))
        
        # Memory utilization
        if 'ram_gb' in hardware_data and 'memory_usage' in hardware_data:
            memory_utilization = await self.calculate_memory_utilization(
                hardware_data['ram_gb']['value'],
                hardware_data.get('memory_usage', {}).get('value', 0)
            )
            
            points.append(MonitoringPoint(
                measurement='hardware_utilization',
                tags={
                    'device_id': device_id,
                    'organization_id': org_id,
                    'metric_type': 'memory_utilization'
                },
                fields={'value': memory_utilization},
                timestamp=datetime.utcnow()
            ))
        
        # Storage performance
        if 'storage_type' in hardware_data and 'storage_capacity_gb' in hardware_data:
            storage_performance = await self.calculate_storage_performance(
                hardware_data['storage_type']['value'],
                hardware_data['storage_capacity_gb']['value']
            )
            
            points.append(MonitoringPoint(
                measurement='storage_performance',
                tags={
                    'device_id': device_id,
                    'organization_id': org_id,
                    'storage_type': hardware_data['storage_type']['value']
                },
                fields={'performance_score': storage_performance},
                timestamp=datetime.utcnow()
            ))
        
        return points
    
    async def calculate_cpu_efficiency(self, cpu_cores: int, cpu_usage: float) -> float:
        """Calculate CPU efficiency based on cores and usage"""
        
        if cpu_cores == 0:
            return 0.0
        
        # Base efficiency calculation
        base_efficiency = (100 - cpu_usage) / 100
        
        # Core count multiplier (more cores = higher potential efficiency)
        core_multiplier = min(cpu_cores / 4, 2.0)  # Cap at 2x multiplier
        
        return base_efficiency * core_multiplier * 100
```

### Performance Index Calculation
```python
class PerformanceIndexCalculator:
    def __init__(self):
        self.baseline_scores = {
            'cpu_cores': {'weight': 0.3, 'baseline': 4},
            'ram_gb': {'weight': 0.3, 'baseline': 8},
            'storage_type': {'weight': 0.2, 'baseline_scores': {
                'HDD': 1.0,
                'SSD': 2.5,
                'NVMe': 4.0,
                'Hybrid': 1.8
            }},
            'benchmark_score': {'weight': 0.2, 'baseline': 10000}
        }
    
    async def calculate_device_performance_index(self, device_data: Dict) -> float:
        """Calculate overall device performance index"""
        
        total_score = 0.0
        total_weight = 0.0
        
        for metric, config in self.baseline_scores.items():
            if metric in device_data:
                value = device_data[metric]['value']
                weight = config['weight']
                
                if metric == 'storage_type':
                    # Handle enum scoring
                    score = config['baseline_scores'].get(value, 1.0)
                else:
                    # Handle numeric scoring
                    baseline = config['baseline']
                    score = min(value / baseline, 3.0)  # Cap at 3x baseline
                
                total_score += score * weight
                total_weight += weight
        
        # Normalize to 0-100 scale
        if total_weight > 0:
            performance_index = (total_score / total_weight) * 100
        else:
            performance_index = 0.0
        
        return min(performance_index, 100.0)  # Cap at 100

class BusinessMetricsProcessor:
    async def process_category_data(self, device_id: str, org_id: str, 
                                  business_data: Dict) -> List[MonitoringPoint]:
        """Process business information for monitoring"""
        
        points = []
        
        # Department utilization tracking
        if 'department' in business_data:
            points.append(MonitoringPoint(
                measurement='business_metrics',
                tags={
                    'device_id': device_id,
                    'organization_id': org_id,
                    'metric_type': 'department_allocation',
                    'department': business_data['department']['value']
                },
                fields={'count': 1},
                timestamp=datetime.utcnow()
            ))
        
        # Warranty tracking
        if 'warranty_expiry' in business_data:
            warranty_expiry = datetime.fromisoformat(
                business_data['warranty_expiry']['value']
            )
            days_to_expiry = (warranty_expiry - datetime.utcnow()).days
            
            points.append(MonitoringPoint(
                measurement='warranty_tracking',
                tags={
                    'device_id': device_id,
                    'organization_id': org_id,
                    'metric_type': 'warranty_status'
                },
                fields={
                    'days_to_expiry': days_to_expiry,
                    'is_expired': days_to_expiry < 0,
                    'expires_soon': 0 < days_to_expiry <= 30
                },
                timestamp=datetime.utcnow()
            ))
        
        return points
```

### Real-time Dashboard Integration
```python
class RealTimeDashboardEngine:
    def __init__(self, websocket_manager, redis_cluster):
        self.websocket_manager = websocket_manager
        self.redis_cluster = redis_cluster
    
    async def broadcast_monitoring_update(self, org_id: str, device_id: str, 
                                        metrics: List[MonitoringPoint]):
        """Broadcast real-time monitoring updates via WebSocket"""
        
        # Prepare dashboard update
        dashboard_update = {
            'type': 'monitoring_update',
            'organization_id': org_id,
            'device_id': device_id,
            'timestamp': datetime.utcnow().isoformat(),
            'metrics': {}
        }
        
        # Group metrics by type
        for point in metrics:
            metric_type = point.tags.get('metric_type', 'unknown')
            dashboard_update['metrics'][metric_type] = {
                'value': point.fields.get('value', 0),
                'measurement': point.measurement,
                'tags': point.tags
            }
        
        # Cache in Redis for dashboard state
        cache_key = f"dashboard:realtime:{org_id}:{device_id}"
        await self.redis_cluster.setex(
            cache_key, 300, json.dumps(dashboard_update)  # 5 minute cache
        )
        
        # Broadcast to connected organization dashboards
        await self.websocket_manager.broadcast_to_organization(
            org_id, dashboard_update
        )
    
    async def get_realtime_dashboard_data(self, org_id: str, 
                                        device_ids: List[str] = None) -> Dict:
        """Get current real-time dashboard data"""
        
        dashboard_data = {
            'organization_id': org_id,
            'last_updated': datetime.utcnow().isoformat(),
            'devices': {}
        }
        
        # Get device list if not provided
        if device_ids is None:
            device_ids = await self.get_organization_devices(org_id)
        
        # Collect real-time data for each device
        for device_id in device_ids:
            cache_key = f"dashboard:realtime:{org_id}:{device_id}"
            cached_data = await self.redis_cluster.get(cache_key)
            
            if cached_data:
                device_data = json.loads(cached_data)
                dashboard_data['devices'][device_id] = device_data['metrics']
        
        return dashboard_data
```

### Custom Alerting Integration
```python
class AdditionalMonitoringAlerts:
    def __init__(self, alert_engine_client):
        self.alert_engine = alert_engine_client
        self.custom_alert_rules = [
            'performance_degradation',
            'hardware_underutilization',
            'warranty_expiration',
            'department_capacity_warning'
        ]
    
    async def evaluate_custom_alerts(self, device_id: str, org_id: str, 
                                   monitoring_points: List[MonitoringPoint]):
        """Evaluate custom alert conditions based on monitoring data"""
        
        alerts_triggered = []
        
        for point in monitoring_points:
            measurement = point.measurement
            metric_type = point.tags.get('metric_type')
            value = point.fields.get('value', 0)
            
            # Performance degradation alert
            if (measurement == 'hardware_efficiency' and 
                metric_type == 'cpu_efficiency' and value < 30):
                
                alert = await self.create_performance_alert(
                    device_id, org_id, 'CPU efficiency below 30%', value
                )
                alerts_triggered.append(alert)
            
            # Hardware underutilization alert
            if (measurement == 'hardware_utilization' and 
                metric_type == 'memory_utilization' and value < 20):
                
                alert = await self.create_utilization_alert(
                    device_id, org_id, 'Memory underutilized', value
                )
                alerts_triggered.append(alert)
            
            # Warranty expiration alert
            if (measurement == 'warranty_tracking' and 
                point.fields.get('expires_soon', False)):
                
                days_left = point.fields.get('days_to_expiry', 0)
                alert = await self.create_warranty_alert(
                    device_id, org_id, f'Warranty expires in {days_left} days'
                )
                alerts_triggered.append(alert)
        
        # Send alerts to alert engine
        for alert in alerts_triggered:
            await self.alert_engine.process_custom_alert(alert)
        
        return alerts_triggered
    
    async def create_performance_alert(self, device_id: str, org_id: str, 
                                     message: str, value: float) -> Dict:
        """Create performance-related alert"""
        
        return {
            'alert_type': 'performance_degradation',
            'severity': 'medium' if value > 20 else 'high',
            'device_id': device_id,
            'organization_id': org_id,
            'message': message,
            'current_value': value,
            'threshold': 30,
            'created_at': datetime.utcnow().isoformat(),
            'source': 'additional_monitoring_engine'
        }
```

### Data Retention and Cleanup
```python
class MonitoringDataRetention:
    def __init__(self, influxdb_client, redis_cluster):
        self.influxdb_client = influxdb_client
        self.redis_cluster = redis_cluster
        self.retention_policies = {
            'raw_data': '30d',          # Raw monitoring points
            'hourly_aggregates': '90d',  # Hourly aggregated data
            'daily_aggregates': '1y',    # Daily aggregated data
            'monthly_aggregates': '5y'   # Monthly aggregated data
        }
    
    async def setup_retention_policies(self, org_id: str):
        """Setup InfluxDB retention policies for organization"""
        
        database_name = f"rmas_monitoring_{org_id}"
        
        for policy_name, retention_period in self.retention_policies.items():
            await self.influxdb_client.create_retention_policy(
                name=policy_name,
                database=database_name,
                duration=retention_period,
                replication=1,
                default=(policy_name == 'raw_data')
            )
    
    async def aggregate_monitoring_data(self, org_id: str):
        """Create aggregated data for long-term storage"""
        
        database_name = f"rmas_monitoring_{org_id}"
        
        # Hourly aggregation
        hourly_query = '''
            SELECT 
                MEAN(value) as avg_value,
                MAX(value) as max_value,
                MIN(value) as min_value,
                COUNT(value) as sample_count
            INTO hourly_aggregates.:MEASUREMENT
            FROM raw_data./.*/ 
            WHERE time >= now() - 2h AND time < now() - 1h
            GROUP BY time(1h), device_id, metric_type
        '''
        
        await self.influxdb_client.query(hourly_query, database=database_name)
        
        # Daily aggregation  
        daily_query = '''
            SELECT 
                MEAN(avg_value) as avg_value,
                MAX(max_value) as max_value,
                MIN(min_value) as min_value,
                SUM(sample_count) as total_samples
            INTO daily_aggregates.:MEASUREMENT
            FROM hourly_aggregates./.*/ 
            WHERE time >= now() - 2d AND time < now() - 1d
            GROUP BY time(1d), device_id, metric_type
        '''
        
        await self.influxdb_client.query(daily_query, database=database_name)
```

This Additional Monitoring Engine operates independently from the core RMAS system, providing specialized monitoring for custom device fields, performance metrics, and business intelligence data. It integrates with the Redis cluster for real-time caching and Kafka for event streaming, making it a scalable and maintainable monitoring solution.

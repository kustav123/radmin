# Infra Provisioner - PostgreSQL CNDG Interface

A FastAPI-based service designed to provision and manage PostgreSQL clusters within a Kubernetes environment using the CloudNativePG (CNPG) operator.

## Architecture

- **Backend**: FastAPI
- **Database**: SQLite (SQLAlchemy ORM)
- **Kubernetes SDK**: Python `kubernetes` client
- **Operator**: CloudNativePG (CNPG)

## Installation & Setup

### 1. Prerequisites
- Kubernetes cluster
- [CloudNativePG (CNPG) Operator](https://cloudnative-pg.io/docs/current/installation_upgrade/) installed:
  ```bash
  # Example: Install latest CNPG operator
  kubectl apply -f https://raw.githubusercontent.com/cloudnative-pg/cloudnative-pg/main/releases/cnpg-1.22.1.yaml
  ```
- Kubernetes context configured locally or service account in-cluster.

### 2. Environment Configuration (`.env`)
Create/update the `.env` file:
```ini
IN_CLUSTER=false
SERVICE_ACCOUNT_NAME=infra-provisioner-sa
SHOW_SWAGGER=true
NODE_IP=1.2.3.4  # External IP of your cluster nodes
NODEPORT_START=30000
NODEPORT_RANGE=50
DATABASE_URL=sqlite:///./infra_provisioner.db
```

### 3. Run Locally
```bash
pip install -r requirements.txt
python -m uvicorn main:app --reload
```
The API will be available at [http://localhost:8000](http://localhost:8000).

### 4. Running In-Cluster
1. Apply the ServiceAccount and RBAC:
   ```bash
   kubectl apply -f sa.yaml
   ```
2. Set `IN_CLUSTER=true` in your environment.
3. Deploy the application as a deployment using the `infra-provisioner-sa`.

## API Documentation

### DB Provisioning & Management
- **POST `/db/provision`**: Provision a new PostgreSQL cluster.
  - Parameters: `name`, `instance_count`, `size`, `root_password`, `app_user`, `app_password`, `db_name`, `storage_class_name`, `resource_request`, `resource_limit`, `nodeport` (bool), `tenant_id`.
  - Returns: Cluster details, connection string, and service name.
- **GET `/db/{id}/status`**: Fetch the current status of a provisioned cluster from the Kubernetes API.

### Admin Configuration
- **GET `/admin/getnodeip`**: Retrieve current configured Node IP.
- **POST `/admin/setnodeip`**: Update Node IP for connection strings.
- **GET `/admin/getnodeport`**: Show current NodePort range and last used port.
- **POST `/admin/setnodeport`**: Update the available NodePort range (e.g., 30000 - 30050).

## NodePort Management
When `nodeport=true` is sent in the provision request:
1. The service looks up the `last_used_nodeport` in the local DB.
2. It assigns `last_used_nodeport + 1` within the range.
3. It creates a Kubernetes `Service` of type `NodePort` specifically targeting the primary PostgreSQL instance.
4. Returns a connection string pointing to the assigned port and Node IP.

## Database Migrations

This project uses **Alembic** to handle database migrations.

### Initializing a new migration:
```bash
# Generate a new migration script based on model changes
alembic revision --autogenerate -m "Added some new fields"
```

### Running migrations:
```bash
# Apply all pending migrations to the SQLite DB
alembic upgrade head
```

Wait, the `setup.sh` currently calls `init_db()` which uses `Base.metadata.create_all()`. This is fine to start, but for ongoing changes, use Alembic.

## Future Auth Implementation
While authentication is disabled for now, the system is designed to integrate with **Keycloak**. 
- Admin routes will require an `admin` role.
- Provisioning routes will require a `provisioner` (or tenant-specific) role.

## Swagger UI
If `SHOW_SWAGGER=true` is set, you can access the interactive documentation at:
- [http://localhost:8000/docs](http://localhost:8000/docs)

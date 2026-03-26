#!/bin/bash
set -e

# Path to the database file (mounted from PVC)
DB_PATH="/db/infra_provisioner.db"

echo "Checking database at $DB_PATH..."

# Ensure the directory exists
mkdir -p /db

# Run Alembic migrations to ensure schema is up to date
echo "Applying database migrations..."
alembic upgrade head

# Start the FastAPI application
echo "Starting FastAPI on port 8000..."
python -m uvicorn main:app --host 0.0.0.0 --port 8000

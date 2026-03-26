#!/bin/bash

# Activating venv
if [ -d "venv" ]; then
    . venv/bin/activate
    echo "Using existing virtual environment."
else
    echo "Virtual environment not found. Please run ./setup.sh first."
    exit 1
fi

# Loading .env if it exists
if [ -f ".env" ]; then
    export $(grep -v '^#' .env | xargs)
    echo "Loaded .env configuration."
fi

echo "Starting PostGres Provisioner API..."
python3 -m uvicorn main:app --host 0.0.0.0 --port 8000 --reload

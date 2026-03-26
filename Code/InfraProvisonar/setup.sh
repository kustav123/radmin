#!/bin/bash

# Exit on error
set -e

echo "Setting up virtual environment..."
python3 -m venv venv

echo "Activating virtual environment..."
. venv/bin/activate

echo "Installing requirements..."
pip install --upgrade pip
pip install -r requirements.txt

echo "Running DB Migrations..."
# In case of first run, we usually don't have revisions yet.
# We'll just init the db if it doesn't exist, but for professional use we use alembic.
python3 -c "from database import init_db; init_db()"

echo "Setup complete. You can now use ./run.sh to start the service."

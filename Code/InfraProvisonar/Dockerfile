# Use official Python base image
FROM python:3.11-slim

# Set environment variables
ENV PYTHONDONTWRITEBYTECODE=1
ENV PYTHONUNBUFFERED=1
ENV DATABASE_URL="sqlite:////db/infra_provisioner.db"

# Set work directory
WORKDIR /app

# Install system dependencies (for potential future requirements)
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Install python dependencies
COPY requirements.txt /app/
RUN pip install --no-cache-dir -r requirements.txt

# Copy project files
COPY . /app/

# Make the entrypoint script executable
RUN chmod +x /app/entrypoint.sh

# Create the /db volume directory (for mount)
RUN mkdir -p /db

# Expose port (default FastAPI)
EXPOSE 8000

# Set entrypoint to our script
ENTRYPOINT ["/app/entrypoint.sh"]

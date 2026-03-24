#!/bin/zsh

# Core Chart Deployment Script
# This script runs a dry-run and then performs a debug install of the core umbrella chart.

CHART_DIR=$(dirname "$0")
cd "$CHART_DIR"

echo "Updating Helm dependencies..."
helm dependency update

echo "Running Helm Dry Run (Debug Mode)..."
helm install core-services . --namespace core-services --create-namespace --dry-run --debug > ../helm-dry-run.yaml 2>&1

echo "Running Helm Upgrade/Install (Debug Mode)..."
helm upgrade --install core-services . --namespace core-services --create-namespace --debug > ../helm-debug-install.log 2>&1

echo "Deployment completed. Outputs stored in ../helm-dry-run.yaml and ../helm-debug-install.log"

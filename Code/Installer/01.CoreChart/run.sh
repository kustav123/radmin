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
if helm upgrade --install core-services . --namespace core-services --create-namespace --debug > ../helm-debug-install.log 2>&1; then
    echo "--------------------------------------------------------------------------------"
    echo "📋 HELM POST-INSTALL NOTES"
    echo "--------------------------------------------------------------------------------"
    helm get notes core-services --namespace core-services
    echo "--------------------------------------------------------------------------------"
    echo "✓ Deployment completed successfully. Full logs stored in ../helm-debug-install.log"
else
    echo "❌ Deployment failed! Check ../helm-debug-install.log for details."
    exit 1
fi

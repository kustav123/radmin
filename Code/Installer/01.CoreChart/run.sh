#!/bin/bash

# Core Chart Deployment Script

CHART_DIR=$(dirname "$0")
cd "$CHART_DIR"

echo "[1/4] Ensuring Namespaces Exist..."
kubectl create namespace core-services --dry-run=client -o yaml | kubectl apply -f -
kubectl label namespace core-services pod-security.kubernetes.io/enforce=privileged --overwrite

# Conditional Argo CD Namespace creation
if grep -q "argo-cd:" values.yaml && grep -A 10 "argo-cd:" values.yaml | grep -q "enabled: true"; then
    echo "[INFO] Argo CD enabled, ensuring 'argocd' namespace exists..."
    kubectl create namespace argocd --dry-run=client -o yaml | kubectl apply -f -
    kubectl label namespace argocd pod-security.kubernetes.io/enforce=baseline --overwrite
else
    echo "[INFO] Argo CD not detected or disabled, skipping namespace creation..."
fi

echo "[2/4] Updating Helm dependencies..."
helm dependency update

echo "[3/4] Running Helm Dry Run (Debug Mode)..."
helm install core-services . --namespace core-services --dry-run --debug > ../helm-dry-run.yaml 2>&1

echo "[4/4] Running Helm Upgrade/Install (Debug Mode)..."
if helm upgrade --install core-services . --namespace core-services --debug > ../helm-debug-install.log 2>&1; then
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

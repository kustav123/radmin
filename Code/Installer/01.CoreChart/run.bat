@echo off
setlocal enabledelayedexpansion

REM Core Chart Deployment Script (Windows Batch)

cd /d "%~dp0"

echo [1/4] Ensuring Namespaces Exist...
kubectl create namespace core-services --dry-run=client -o yaml | kubectl apply -f -
kubectl label namespace core-services pod-security.kubernetes.io/enforce=privileged --overwrite

REM Check if Argo CD is enabled in values.yaml
set ARGO_ENABLED=false
for /f "tokens=*" %%a in ('findstr /i "argo-cd:" values.yaml') do set ARGO_FOUND=true
if defined ARGO_FOUND (
    REM Simple check for enabled: true within the file. 
    REM Note: This is a basic grep-like check for batch.
    findstr /r /c:"argo-cd:" /c:"enabled: true" values.yaml > nul
    if %ERRORLEVEL% equ 0 set ARGO_ENABLED=true
)

if "!ARGO_ENABLED!"=="true" (
    echo [INFO] Argo CD enabled, ensuring 'argocd' namespace exists...
    kubectl create namespace argocd --dry-run=client -o yaml | kubectl apply -f -
    kubectl label namespace argocd pod-security.kubernetes.io/enforce=baseline --overwrite
) else (
    echo [INFO] Argo CD not detected or disabled, skipping namespace creation...
)

echo [2/4] Updating Helm dependencies...
helm dependency update
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Helm dependency update failed.
    exit /b %ERRORLEVEL%
)

echo [3/4] Running Helm Dry Run (Debug Mode)...
helm install core-services . --namespace core-services --dry-run --debug > ..\helm-dry-run.yaml 2>&1

echo [4/4] Running Helm Upgrade/Install (Debug Mode)...
helm upgrade --install core-services . --namespace core-services --debug > ..\helm-debug-install.log 2>&1
if %ERRORLEVEL% equ 0 (
    echo --------------------------------------------------------------------------------
    echo 📋 HELM POST-INSTALL NOTES
    echo --------------------------------------------------------------------------------
    helm get notes core-services --namespace core-services
    echo --------------------------------------------------------------------------------
    echo ✓ Deployment completed successfully. Full logs stored in ..\helm-debug-install.log
) else (
    echo ❌ Deployment failed! Check ..\helm-debug-install.log for details.
    exit /b %ERRORLEVEL%
)

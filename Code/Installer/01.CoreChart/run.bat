@echo off
setlocal enabledelayedexpansion

REM Core Chart Deployment Script (Windows Batch)
REM This script runs a dry-run and then performs a debug install of the core umbrella chart.

cd /d "%~dp0"

echo Updating Helm dependencies...
helm dependency update
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Helm dependency update failed.
    exit /b %ERRORLEVEL%
)

echo Running Helm Dry Run (Debug Mode)...
helm install core-services . --namespace core-services --dry-run --debug > ..\helm-dry-run.yaml 2>&1

echo Running Helm Upgrade/Install (Debug Mode)...
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

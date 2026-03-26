@echo off
setlocal enabledelayedexpansion

REM Activating venv
if exist "venv\Scripts\activate.bat" (
    call venv\Scripts\activate.bat
    echo Using existing virtual environment.
) else (
    echo Virtual environment not found. Please run setup.bat first.
    pause
    exit /b 1
)

REM Loading .env if it exists
if exist ".env" (
    for /f "usebackq tokens=*" %%a in (".env") do (
        set "line=%%a"
        if "!line:~0,1!" neq "#" (
            set "%%a"
        )
    )
    echo Loaded .env configuration.
)

echo Starting PostGres Provisioner API...
python -m uvicorn main:app --host 0.0.0.0 --port 8000 --reload

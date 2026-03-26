@echo off
setlocal enabledelayedexpansion

echo Setting up virtual environment...
python -m venv venv
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to create virtual environment. Ensure Python is installed and in PATH.
    pause
    exit /b %ERRORLEVEL%
)

echo Activating virtual environment...
call venv\Scripts\activate.bat

echo Installing requirements...
python -m pip install --upgrade pip
python -m pip install -r requirements.txt

echo Running DB Migrations...
python -c "from database import init_db; init_db()"

echo Setup complete. You can now use run.bat to start the service.
pause

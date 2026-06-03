# Run-local helper for Locadora-de-carros
# Usage: powershell -ExecutionPolicy Bypass -File .\run-local.ps1

$root = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $root

Write-Host "Working directory: $root"

# Ensure .env exists
if (-not (Test-Path ".env")) {
    if (Test-Path ".env.example") {
        Copy-Item .env.example .env
        Write-Host ".env criado a partir de .env.example. Abra para editar as credenciais." -ForegroundColor Green
        Start-Process notepad .env
    } else {
        Write-Host ".env.example não encontrado. Crie .env manualmente a partir das variáveis listadas em .env.example." -ForegroundColor Yellow
    }
} else {
    Write-Host ".env já existe. Abra para revisar ou editar se necessário." -ForegroundColor Green
    Start-Process notepad .env
}

# Check PHP availability
$php = Get-Command php -ErrorAction SilentlyContinue
if (-not $php) {
    Write-Host "PHP não está disponível no PATH. Instale PHP ou adicione 'php' ao PATH para usar o servidor embutido." -ForegroundColor Red
    Write-Host "Alternativa: instalar PHP via https://windows.php.net/ ou usar o instalador do Windows." -ForegroundColor Yellow
    exit 1
}

# Start PHP built-in server on port 8000
$port = 8000
Write-Host "Iniciando servidor PHP embutido em http://localhost:$port ..." -ForegroundColor Cyan
$startInfo = Start-Process -FilePath php -ArgumentList "-S localhost:$port" -WindowStyle Normal -PassThru
Start-Sleep -Milliseconds 500

# Open browser
$uri = "http://localhost:$port/"
try {
    Start-Process $uri
} catch {
    Write-Host "Abra manualmente: $uri"
}

Write-Host "Servidor iniciado (PID: $($startInfo.Id)). Para parar, feche a janela do PHP ou mate o processo." -ForegroundColor Green
Write-Host "Se você precisa importar o banco de dados, importe 'scripts/banco_locadora_fixed.sql' usando seu cliente MySQL (phpMyAdmin, MySQL CLI, etc.)." -ForegroundColor Yellow
Write-Host "Exemplo de import (MySQL CLI): mysql -u root -p locadora < scripts/banco_locadora_fixed.sql" -ForegroundColor Gray

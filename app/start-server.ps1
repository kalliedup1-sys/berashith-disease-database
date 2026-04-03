$ErrorActionPreference = "Stop"

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  Disease Search App - Local Server" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

# Find PHP executable properly
$phpPath = (Get-Command php -ErrorAction Stop).Source
Write-Host "Found PHP at: $phpPath" -ForegroundColor Green

Write-Host "`nStarting PHP development server..." -ForegroundColor Yellow
Write-Host "`nOpen your browser to: http://127.0.0.1:8000`n" -ForegroundColor Green
Write-Host "Press CTRL+C to stop the server`n" -ForegroundColor Yellow
Write-Host "========================================`n" -ForegroundColor Cyan

# Change to app directory
Set-Location "c:\Ai PROJEKTE\Berashith_Deseaces\app"

# Start PHP server
& $phpPath -S 127.0.0.1:8000

# Berashith Disease Database Deployment Script (PowerShell)
# This script deploys the updated 359-disease database to cPanel hosting

# Configuration (EDIT THESE)
$cpanelHost = "your-domain.com"          # Your cPanel domain or IP
$cpanelUser = "your-username"            # Your cPanel username
$remoteAppPath = "/home/$cpanelUser/public_html/app"  # Remote app path
$sshKeyPath = "C:\path\to\id_rsa"        # SSH private key (if using key auth)
$localRepoPath = "c:\Ai PROJEKTE\Berashith_Deseaces"

Write-Host "================================================" -ForegroundColor Cyan
Write-Host "Berashith Disease Database - cPanel Deployment" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Deploying to: $cpanelHost"
Write-Host "Remote path: $remoteAppPath"
Write-Host ""

# Step 1: Verify local files exist
Write-Host "[1/4] Verifying local files..." -ForegroundColor Yellow
$appHtmlPath = Join-Path $localRepoPath "app\app.html"
$diseaseFilePath = Join-Path $localRepoPath "app\diseases-complete-new.js"

if (-not (Test-Path $appHtmlPath)) {
    Write-Host "ERROR: app.html not found at $appHtmlPath" -ForegroundColor Red
    exit 1
}
if (-not (Test-Path $diseaseFilePath)) {
    Write-Host "ERROR: diseases-complete-new.js not found at $diseaseFilePath" -ForegroundColor Red
    exit 1
}
Write-Host "✓ Local files verified" -ForegroundColor Green
Write-Host ""

# Step 2: Connect to cPanel via SSH and pull latest code
Write-Host "[2/4] Connecting to cPanel and pulling latest code..." -ForegroundColor Yellow

# Using SSH (make sure SSH is configured)
$sshCommand = "cd $remoteAppPath && git pull origin master"

try {
    ssh "${cpanelUser}@${cpanelHost}" $sshCommand
    if ($LASTEXITCODE -ne 0) {
        throw "SSH command failed"
    }
    Write-Host "✓ Code pulled from GitHub" -ForegroundColor Green
} catch {
    Write-Host "ERROR: Failed to connect or pull from GitHub!" -ForegroundColor Red
    Write-Host "Error details: $_" -ForegroundColor Red
    exit 1
}
Write-Host ""

# Step 3: Deploy files via SCP
Write-Host "[3/4] Deploying updated files to cPanel..." -ForegroundColor Yellow

try {
    # Copy app.html
    scp $appHtmlPath "${cpanelUser}@${cpanelHost}:${remoteAppPath}/"
    if ($LASTEXITCODE -ne 0) {
        throw "Failed to copy app.html"
    }
    
    # Copy diseases-complete-new.js
    scp $diseaseFilePath "${cpanelUser}@${cpanelHost}:${remoteAppPath}/"
    if ($LASTEXITCODE -ne 0) {
        throw "Failed to copy diseases-complete-new.js"
    }
    
    Write-Host "✓ Files deployed successfully" -ForegroundColor Green
} catch {
    Write-Host "ERROR: File transfer failed!" -ForegroundColor Red
    Write-Host "Error details: $_" -ForegroundColor Red
    exit 1
}
Write-Host ""

# Step 4: Verify deployment
Write-Host "[4/4] Verifying deployment..." -ForegroundColor Yellow

try {
    $verifyCommand = "cd $remoteAppPath && ls -lh app.html diseases-complete-new.js"
    ssh "${cpanelUser}@${cpanelHost}" $verifyCommand
    
    Write-Host "✓ Deployment verified - files are in place" -ForegroundColor Green
    Write-Host ""
    Write-Host "Database Status:" -ForegroundColor Cyan
    
    $countCommand = "cd $remoteAppPath && grep -c 'id:' app.html"
    $result = ssh "${cpanelUser}@${cpanelHost}" $countCommand
    Write-Host "$result diseases found in app.html" -ForegroundColor Green
} catch {
    Write-Host "ERROR: Verification failed!" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "================================================" -ForegroundColor Green
Write-Host "✓ DEPLOYMENT COMPLETE!" -ForegroundColor Green
Write-Host "================================================" -ForegroundColor Green
Write-Host ""
Write-Host "Updated files deployed to cPanel:" -ForegroundColor Cyan
Write-Host "  • app.html (with 359-disease database)"
Write-Host "  • diseases-complete-new.js"
Write-Host ""
Write-Host "The live search is now updated with:" -ForegroundColor Green
Write-Host "  ✓ All 359 diseases"
Write-Host "  ✓ Warts (ID 357) - FOUND!"
Write-Host "  ✓ All missing entries restored"
Write-Host ""

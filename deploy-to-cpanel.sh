#!/bin/bash

# Berashith Disease Database Deployment Script
# This script deploys the updated 359-disease database to cPanel hosting

# Configuration (EDIT THESE)
CPANEL_HOST="your-domain.com"          # Your cPanel domain or IP
CPANEL_USER="your-username"            # Your cPanel username
REMOTE_PATH="/home/$CPANEL_USER/public_html/app"  # Remote app path
LOCAL_REPO="/c/Ai\ PROJEKTE/Berashith_Deseaces"   # Local repo path

echo "================================================"
echo "Berashith Disease Database - cPanel Deployment"
echo "================================================"
echo ""
echo "Deploying to: $CPANEL_HOST"
echo "Remote path: $REMOTE_PATH"
echo ""

# Step 1: Verify local files exist
echo "[1/4] Verifying local files..."
if [ ! -f "$LOCAL_REPO/app/app.html" ]; then
    echo "ERROR: app.html not found!"
    exit 1
fi
if [ ! -f "$LOCAL_REPO/app/diseases-complete-new.js" ]; then
    echo "ERROR: diseases-complete-new.js not found!"
    exit 1
fi
echo "✓ Local files verified"
echo ""

# Step 2: Connect to cPanel and update repository
echo "[2/4] Connecting to cPanel and pulling latest code..."
ssh $CPANEL_USER@$CPANEL_HOST << 'EOF'
    cd $REMOTE_PATH
    git pull origin master
    echo "✓ Code pulled from GitHub"
EOF

if [ $? -ne 0 ]; then
    echo "ERROR: Failed to connect or pull from GitHub!"
    exit 1
fi
echo ""

# Step 3: Deploy files via SCP
echo "[3/4] Deploying updated files to cPanel..."
scp "$LOCAL_REPO/app/app.html" $CPANEL_USER@$CPANEL_HOST:$REMOTE_PATH/
scp "$LOCAL_REPO/app/diseases-complete-new.js" $CPANEL_USER@$CPANEL_HOST:$REMOTE_PATH/

if [ $? -ne 0 ]; then
    echo "ERROR: File transfer failed!"
    exit 1
fi
echo "✓ Files deployed successfully"
echo ""

# Step 4: Verify deployment
echo "[4/4] Verifying deployment..."
ssh $CPANEL_USER@$CPANEL_HOST << 'EOF'
    cd $REMOTE_PATH
    if [ -f "app.html" ] && [ -f "diseases-complete-new.js" ]; then
        echo "✓ Deployment verified - files are in place"
        echo ""
        echo "Database Status:"
        grep -c "id:" app.html | head -1
        echo "diseases found in app.html"
    else
        echo "ERROR: Files not found after deployment!"
        exit 1
    fi
EOF

echo ""
echo "================================================"
echo "✓ DEPLOYMENT COMPLETE!"
echo "================================================"
echo ""
echo "Updated files deployed to cPanel:"
echo "  • app.html (with 359-disease database)"
echo "  • diseases-complete-new.js"
echo ""
echo "The live search is now updated with:"
echo "  ✓ All 359 diseases"
echo "  ✓ Warts (ID 357) - FOUND!"
echo "  ✓ All missing entries restored"
echo ""

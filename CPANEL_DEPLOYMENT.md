# cPanel Deployment Guide

## Your GitHub Repository
✅ Repository: https://github.com/kalliedup1-sys/berashith-disease-database
✅ Status: All files pushed and ready for deployment

## Step 1: Access cPanel Terminal

1. Log in to your cPanel account
2. Find **Terminal** (under Advanced section) or **SSH Access**
3. Enter your credentials

## Step 2: Deploy to Public HTML

Run these commands in the cPanel Terminal:

```bash
# Navigate to your public_html directory
cd ~/public_html

# Remove old app folder if it exists
rm -rf app

# Clone the GitHub repository directly into the app folder
git clone https://github.com/kalliedup1-sys/berashith-disease-database.git app

# Navigate into the app folder
cd app

# Configure git (required for future updates)
git config user.email "kalliedup1@gmail.com"
git config user.name "Kallie"

# Set file permissions (makes files readable by web server)
chmod 644 *.html *.php *.js *.json
chmod 755 . assets data

# List contents to verify
ls -la
```

## Step 3: Set File Permissions via cPanel File Manager

Alternative if terminal commands don't work:

1. Log in to cPanel → File Manager
2. Navigate to `public_html/app`
3. Select all files and folders
4. Right-click → Change Permissions
5. Set to: **644 for files**, **755 for directories**

## Step 4: Verify Deployment

Once deployed, access your app at:
```
https://berashithministry.co.za/app/app.html
```

## Step 5: Update Workflow for Future Changes

To pull latest changes from GitHub:

```bash
cd ~/public_html/app
git pull origin master
```

To push new changes from your local machine:

```bash
# On your Windows machine
cd "c:\Ai PROJEKTE\Berashith_Deseaces\app"
git add .
git commit -m "Your commit message"
git push origin master

# Then on cPanel terminal
cd ~/public_html/app
git pull origin master
```

## Troubleshooting

**Problem**: Files not showing on website
- Run `chmod 644 *.html *.php *.js *.json` to fix permissions

**Problem**: "fatal: not a git repository"
- Make sure you're in `~/public_html/app` directory

**Problem**: Permission denied errors
- Check file permissions are 644 (files) and 755 (directories)

**Problem**: App not loading
- Check if the path is correct: `/app/app.html`
- Verify header image path is relative (should work automatically)

## Success!

Your Disease & Sickness Database is now live on the web! 🚀

---

**Need to make changes?** Just edit locally, commit to GitHub, then pull on cPanel!

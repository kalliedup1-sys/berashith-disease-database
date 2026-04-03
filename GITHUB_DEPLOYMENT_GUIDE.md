# GitHub & cPanel Deployment Guide

## Step 1: Create Repository on GitHub

1. Go to https://github.com/new
2. **Repository name**: `berashith-disease-database`
3. **Description**: Disease & Sickness Database Search Engine for Berashith Ministry
4. **Visibility**: Public (or Private if you prefer)
5. Click **Create repository**

## Step 2: Copy Your Repository URL

After creating the repo, GitHub will show you commands. Copy the HTTPS URL:
```
https://github.com/YOUR-USERNAME/berashith-disease-database.git
```

## Step 3: Terminal Commands (Run in cPanel Terminal)

Replace `YOUR-USERNAME` with your actual GitHub username.

```bash
# Navigate to your public_html directory
cd ~/public_html

# Create app directory if needed
mkdir -p app
cd app

# Initialize git repository
git init

# Add remote (replace YOUR-USERNAME)
git remote add origin https://github.com/YOUR-USERNAME/berashith-disease-database.git

# Configure git with your GitHub email
git config user.email "your-github-email@gmail.com"
git config user.name "Your Name"

# Check git status
git status

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit: Disease & Sickness Database Search Engine"

# Push to GitHub (you'll be prompted for credentials)
git push -u origin main
```

## Step 4: When Prompted for Password

GitHub no longer accepts passwords. You have two options:

### Option A: Use GitHub Personal Access Token (RECOMMENDED)
1. Go to https://github.com/settings/tokens
2. Click "Generate new token" → "Generate new token (classic)"
3. Give it a name like "cPanel Deploy"
4. Select scope: ✓ repo (all)
5. Click "Generate token"
6. Copy the token (save it safely!)
7. When prompted for password in terminal, paste the token instead

### Option B: Use SSH Key
If you prefer SSH, follow GitHub's SSH setup guide at:
https://docs.github.com/en/authentication/connecting-to-github-with-ssh

## Step 5: Verify Deployment

After pushing, verify everything is live:

1. Check GitHub: https://github.com/YOUR-USERNAME/berashith-disease-database
2. Check your website: https://berashithministry.co.za/app/app.html

## Step 6: Future Updates

For future changes:

```bash
cd ~/public_html/app

# Make changes to app.html, images, etc.

# Stage changes
git add .

# Commit
git commit -m "Description of changes"

# Push to GitHub
git push origin main
```

## Step 7: Pull Updates from GitHub to Server

If you make changes on GitHub or another machine:

```bash
cd ~/public_html/app
git pull origin main
```

## Troubleshooting

**Problem**: "fatal: not a git repository"
- Solution: Make sure you're in ~/public_html/app directory
- Run: `git init` first

**Problem**: "Permission denied (publickey)"
- Solution: Use HTTPS with personal access token instead of SSH

**Problem**: "origin already exists"
- Solution: Remove it first with: `git remote remove origin`

**Problem**: Files not updating on website
- Solution: Check file permissions in cPanel File Manager (should be 644 for files)

## Questions?

Contact your hosting support or refer to:
- GitHub Docs: https://docs.github.com
- cPanel Support: Your hosting provider's documentation

---

**Ready to proceed? Run the commands from Step 3 in your cPanel terminal!**

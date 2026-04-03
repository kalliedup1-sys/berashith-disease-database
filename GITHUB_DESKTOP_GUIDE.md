# GitHub Desktop Setup Guide

## Step 1: Download GitHub Desktop

1. Go to https://desktop.github.com
2. Click **Download for Windows** (or Mac/Linux if applicable)
3. Run the installer and follow the setup wizard

## Step 2: Sign In to GitHub

1. Open GitHub Desktop
2. Click **File** → **Options** (or **GitHub Desktop** → **Preferences** on Mac)
3. Click **Accounts** tab
4. Click **Sign in** button
5. Enter your GitHub username/email and password
6. Complete the authentication process

## Step 3: Clone Your Repository

1. In GitHub Desktop, click **File** → **Clone repository**
2. Go to the **URL** tab
3. Paste your repository URL:
   ```
   https://github.com/YOUR-USERNAME/berashith-disease-database.git
   ```
4. Choose where to save it on your computer (example: `C:\Ai PROJEKTE\Berashith_Deseaces\github-repo`)
5. Click **Clone**

## Step 4: Your Repository is Now Cloned

GitHub Desktop will download your repository. You'll see:
- Your project files
- Commit history
- Branch information
- Changes tracker

## Step 5: Making Changes and Pushing

### To Make Changes:
1. Edit files in your code editor (VS Code, etc.)
2. Save your changes
3. GitHub Desktop will automatically detect them

### To Commit and Push:
1. In GitHub Desktop, you'll see a list of changed files
2. Write a **Summary** (example: "Update disease database styling")
3. Optionally add a **Description**
4. Click **Commit to main**
5. Click **Push origin** to send to GitHub

## Step 6: Pulling Updates from GitHub

If you make changes on GitHub.com or another computer:

1. Open GitHub Desktop
2. Click **Fetch origin** (checks for updates)
3. Click **Pull origin** (downloads updates)

Your local files will update automatically!

## Step 7: Workflow Summary

```
Make Changes → Commit → Push to GitHub → Deploy to cPanel
                ↓                              ↓
          Save in GitHub Desktop         Pull in cPanel Terminal
```

## Quick Reference

| Action | Step |
|--------|------|
| **Create Commit** | Write summary + click "Commit to main" |
| **Push to GitHub** | Click "Push origin" |
| **Pull from GitHub** | Click "Fetch origin" then "Pull origin" |
| **See Changes** | Look at "Changes" tab |
| **See History** | Look at "History" tab |
| **Switch Branches** | Click "Current Branch" dropdown |

## Troubleshooting

**Problem**: "Repository not found"
- Solution: Check your GitHub username and repository name
- Make sure the URL is correct

**Problem**: "Authentication failed"
- Solution: Sign out and sign back in
- Go to **File** → **Options** → **Accounts** → Sign out, then sign back in

**Problem**: "Merge conflict"
- Solution: GitHub Desktop will guide you through it
- You can also contact me for help

**Problem**: "Can't see my changes"
- Solution: Make sure you saved files in your editor first
- GitHub Desktop detects changes automatically after save

---

## Next Steps

After setting up GitHub Desktop:

1. **Edit app.html locally** in your code editor
2. **Test changes** on your computer
3. **Commit changes** in GitHub Desktop
4. **Push to GitHub**
5. **Pull in cPanel** terminal to deploy live

---

**Need help with any step? Let me know!** 🚀

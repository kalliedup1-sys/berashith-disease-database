# Berashith Disease Database - Manual cPanel Deployment Guide

## Quick Deployment Instructions

### Option 1: Using SSH Terminal (Recommended - 2 minutes)

```bash
# Step 1: SSH into your cPanel server
ssh your-username@your-domain.com

# Step 2: Navigate to your public_html/app directory
cd ~/public_html/app
# OR
cd /home/your-username/public_html/app

# Step 3: Pull the latest code from GitHub
git pull origin master

# Step 4: Verify the deployment (should show 359 diseases)
grep -c "id:" app.html

# Done! Your site is now updated.
```

### Option 2: Using cPanel File Manager

1. Log in to cPanel
2. Go to **File Manager**
3. Navigate to **public_html/app** (or your app directory)
4. Delete or backup the old `app.html` file
5. Upload the new `app.html` from: `c:\Ai PROJEKTE\Berashith_Deseaces\app\app.html`
6. Upload the new `diseases-complete-new.js` from: `c:\Ai PROJEKTE\Berashith_Deseaces\app\diseases-complete-new.js`
7. Clear your browser cache and test the site

### Option 3: Using Git Deploy (If Git is installed)

If your cPanel has Git installed and the repository is already cloned:

```bash
# SSH into your server
ssh your-username@your-domain.com

# Navigate to app directory
cd ~/public_html/app

# Pull the latest updates
git pull origin master

# Verify (count diseases)
grep -c "id:" app.html
```

Expected output: **359** (indicating all 359 diseases are present)

---

## Verification Commands

After deployment, verify everything is working:

### Check file size and timestamp
```bash
ls -lh app.html diseases-complete-new.js
```

### Count diseases in database
```bash
grep -c "id:" app.html
```
Expected: **359**

### Verify Warts is present
```bash
grep "WARTS" app.html
```
Expected output: Shows `{id: 357, name: "WARTS (See the part of the body affected)"`

### Test the search functionality
```bash
# Visit your site in browser:
https://your-domain.com/app/
# Search for "Warts" - should find it!
```

---

## Files Deployed

**Source Location (Local):**
- `c:\Ai PROJEKTE\Berashith_Deseaces\app\app.html` - Main search app
- `c:\Ai PROJEKTE\Berashith_Deseaces\app\diseases-complete-new.js` - 359-disease database

**Destination (cPanel):**
- `~/public_html/app/app.html`
- `~/public_html/app/diseases-complete-new.js`

---

## What Changed

✅ **Old Database**: 248 incomplete diseases (missing Warts and others)
✅ **New Database**: 359 complete diseases from Online_Sicknesses__Diseases_only.txt
✅ **Warts**: NOW INCLUDED at ID 357
✅ **All Missing Entries**: Restored to database

---

## GitHub Repository

All changes have been pushed to GitHub:
- **Repository**: https://github.com/kalliedup1-sys/berashith-disease-database
- **Branch**: master
- **Latest Commit**: "Fix: Replace incomplete 248-disease database with complete 359-disease database"

---

## Troubleshooting

### Issue: Git command not found
**Solution**: Use cPanel File Manager to upload files directly

### Issue: Permission denied
**Solution**: 
```bash
chmod 644 app.html diseases-complete-new.js
```

### Issue: Browser still shows old data
**Solution**: 
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+Shift+R or Cmd+Shift+R on Mac)
3. Check that files were actually uploaded

### Issue: Search not working
**Solution**:
1. Check browser console for JavaScript errors
2. Verify app.html file is complete (should be ~35KB)
3. Verify diseases-complete-new.js is present

---

## Contact Information

For issues, visit: https://github.com/kalliedup1-sys/berashith-disease-database/issues

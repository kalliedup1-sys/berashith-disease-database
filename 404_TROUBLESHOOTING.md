# 404 Error Troubleshooting Guide

## Quick Diagnostics

Run these commands in cPanel Terminal to find the issue:

```bash
# Check if app folder exists
ls -la ~/public_html/app/

# Check if app.html is there
file ~/public_html/app/app.html

# Check current directory
pwd

# List all files in app directory
ls -la ~/public_html/app/ | grep app.html
```

## Possible Solutions

### Solution 1: Files are in app folder
**Try this URL:**
```
https://berashithministry.co.za/app/app.html
```

### Solution 2: Need to create index.html symlink
If the above doesn't work, create an index.html that redirects:

```bash
cd ~/public_html/app
cp app.html index.html
ls -la
```

Then try:
```
https://berashithministry.co.za/app/
```

### Solution 3: Check if .htaccess is blocking
Run:
```bash
cat ~/public_html/app/.htaccess
```

If there's one, it might have rules that block access.

### Solution 4: Check file permissions
```bash
ls -l ~/public_html/app/app.html
```

Should show something like: `-rw-r--r-- 1`

If not, fix with:
```bash
chmod 644 ~/public_html/app/app.html
```

### Solution 5: Check if directory listing is allowed
```bash
# Check for DirectoryIndex directive
grep -r "DirectoryIndex" ~/public_html/app/

# If nothing found, try creating .htaccess
echo "DirectoryIndex app.html index.html" > ~/public_html/app/.htaccess
```

## What to Check First

1. **Directory exists**: Does `~/public_html/app/` folder exist?
2. **Files present**: Is `app.html` actually in that folder?
3. **Permissions**: Are permissions set to 644?
4. **Web server**: Is Apache running? (Ask hosting provider)

## Common 404 Causes

| Cause | Fix |
|-------|-----|
| Wrong URL path | Try different URL variations |
| File not in right location | Check with `ls -la` |
| Wrong file name | Verify `app.html` exists |
| Bad permissions | Run `chmod 644 *.html` |
| .htaccess blocking | Check for `.htaccess` file |
| Server not serving HTML | Ask hosting provider |

## URLs to Try (in order)

1. `https://berashithministry.co.za/app/app.html`
2. `https://berashithministry.co.za/app/`
3. `https://berashithministry.co.za/app/index.html`
4. `https://berashithministry.co.za/index.html`
5. `https://berashithministry.co.za/`

## Report Back

When you run the diagnostics, tell me:
1. Output of `ls -la ~/public_html/app/`
2. What URLs you tried
3. What error messages you see
4. The web server (Apache/Nginx)

Then I can help you fix it! 🔧

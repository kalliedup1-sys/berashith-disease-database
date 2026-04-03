# cPanel Terminal Commands - Copy & Paste Ready

## ⚡ QUICK DEPLOYMENT (Copy all commands below)

```bash
# Step 1: Navigate and prepare
cd ~/public_html
rm -rf app

# Step 2: Clone your GitHub repository
git clone https://github.com/kalliedup1-sys/berashith-disease-database.git app
cd app

# Step 3: Configure git
git config user.email "kalliedup1@gmail.com"
git config user.name "Kallie"

# Step 4: Set proper permissions
chmod 644 *.html *.php *.js *.json
chmod 755 . assets data

# Step 5: Verify everything is there
ls -la

# Done! Your app is now live at:
# https://berashithministry.co.za/app/app.html
```

## 🔄 Update Workflow (After Making Changes Locally)

**On your Windows machine:**
```bash
cd "c:\Ai PROJEKTE\Berashith_Deseaces\app"
git add .
git commit -m "Description of your changes"
git push origin master
```

**Then on cPanel terminal:**
```bash
cd ~/public_html/app
git pull origin master
```

## ✅ Verification Checklist

After running the commands above:

- [ ] Cloning completed without errors
- [ ] No permission denied messages
- [ ] `ls -la` shows all files (app.html, assets, data, etc.)
- [ ] Website loads at https://berashithministry.co.za/app/app.html
- [ ] Search functionality works
- [ ] Header image displays
- [ ] Footer shows correctly

## 🆘 If Something Goes Wrong

**Can't access cPanel Terminal?**
- Try SSH access instead (usually available in same area)
- Or use cPanel File Manager to upload files manually

**Git command not found?**
- Ask your hosting provider if Git is installed
- If not, they may need to enable it

**Permission errors?**
- Use cPanel File Manager to change permissions to 644 (files) and 755 (directories)

**Files not updating?**
- Clear browser cache (Ctrl+Shift+Delete)
- Wait 5 minutes for propagation
- Check that permissions are correct

## 📞 Support

For issues with your hosting provider's cPanel:
- Contact their support - they're usually very helpful
- Reference: "I need to deploy a git repository to public_html"

---

**You're all set! Deploy now and your app goes live! 🚀**

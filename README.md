# Disease Search Web App

**A lightweight, production-ready PHP web application for searching structured disease/sickness data.**

Powered by **16 diseases** extracted from your PDF (pages 20+) | **JSON-driven** (no database) | **Fully responsive** | **WordPress-compatible**

---

## 🎯 Features

✅ **Live Search** — Case-insensitive, partial keyword matching across disease names, symptoms, causes  
✅ **Modern UI** — Clean card layout, smooth animations, mobile responsive, dark mode support  
✅ **Fast & Lightweight** — Pure PHP + Vanilla JS, minimal dependencies  
✅ **Accessibility** — Semantic HTML, ARIA labels, keyboard navigation  
✅ **Production-Ready** — Well-commented code, structured data, error handling  
✅ **WordPress Integration** — Drop-in compatible, easy to embed in themes/plugins  

---

## 📁 Project Structure

```
/app
  ├── index.php                 # Frontend UI (HTML + embedded styles + JS)
  ├── search.php                # Search API endpoint (returns JSON)
  ├── /assets
  │   ├── /css/style.css        # Responsive styling
  │   └── /js/app.js            # Live search logic
  └── /data
      └── diseases.json         # 16 disease entries (structured)
```

---

## 🚀 Quick Start

### Local Development (Windows PowerShell)

1. **Open PowerShell and navigate to the app folder:**
   ```powershell
   cd "c:\Ai PROJEKTE\Berashith_Deseaces\app"
   ```

2. **Start the PHP built-in development server:**
   ```powershell
   php -S 127.0.0.1:8000
   ```

3. **Open your browser and visit:**
   ```
   http://127.0.0.1:8000
   ```

4. **Start searching!** Type a disease name (e.g., "malaria", "diabetes") or symptom (e.g., "fever", "cough").

---

## 📝 Data Schema

Each disease in `diseases.json` follows this structure:

```json
{
  "id": 1,
  "name": "Disease Name",
  "cause": "Causative agent or etiology",
  "symptoms": "Common symptoms (comma-separated)",
  "description": "Detailed medical description",
  "additional_info": "Treatment, management, prevention",
  "page": 21,
  "tags": ["respiratory", "viral", "infectious", "common"]
}
```

---

## 🔍 Search API

**Endpoint:** `search.php`

**Parameters:**
- `q` (GET parameter, optional) — Search query

**Examples:**

```bash
# Search for "malaria"
GET /search.php?q=malaria

# Search for "fever"
GET /search.php?q=fever

# Get browse sample (first 10)
GET /search.php
```

**Response:**
```json
[
  {
    "id": 2,
    "name": "Malaria",
    "cause": "Plasmodium parasites...",
    "symptoms": "Fever, chills...",
    ...
  }
]
```

---

## 🎨 Customization

### Add More Diseases
1. Edit `/app/data/diseases.json`
2. Add a new disease object following the schema
3. Refresh the browser (search will pick up changes automatically)

### Styling
- Edit `/app/assets/css/style.css` for colors, fonts, spacing
- Supported: CSS custom properties (CSS variables) in `:root`
- Mobile-first responsive design

### Search Behavior
- Edit `/app/search.php` to change relevance scoring or search algorithms
- Currently: exact name match > name starts with > contains > tags > description

---

## 🔗 WordPress Integration

### Option A: Embed in Theme Template

1. Copy the `/app` folder into your theme directory
2. In your theme template (e.g., `page-diseases.php`):
   ```php
   <?php
   // Load the disease search app
   get_header();
   include get_template_directory() . '/app/index.php';
   get_footer();
   ?>
   ```

### Option B: Simple Shortcode Plugin

Create a file `disease-search-plugin.php`:

```php
<?php
/*
Plugin Name: Disease Search
Description: Lightweight disease search app
*/

add_shortcode('disease_search', function() {
  ob_start();
  include plugin_dir_path(__FILE__) . 'app/index.php';
  return ob_get_clean();
});
?>
```

3. Place the `/app` folder in your plugin directory
4. Activate the plugin
5. Add `[disease_search]` to any page

### Option C: Custom Endpoint

Use WordPress REST API to serve `/search.php`:

```php
add_action('rest_api_init', function() {
  register_rest_route('diseases/v1', '/search', array(
    'methods' => 'GET',
    'callback' => function($request) {
      $q = $request->get_param('q');
      // Forward to /app/search.php
      return json_decode(file_get_contents(
        plugin_dir_path(__FILE__) . "app/search.php?q=" . urlencode($q)
      ), true);
    }
  ));
});
```

---

## 🔐 Security Notes

- All user input is **escaped** in JavaScript to prevent XSS
- Search query is **URL-encoded** before API calls
- No direct database access; JSON file is read-only
- Safe for production if:
  - `/app/data/` is not writable by the web server
  - PHP file execution is restricted to the app directory
  - CORS headers are configured appropriately (currently allow-all for demo)

---

## 🔧 Requirements

- **PHP 7.2+** (for UTF-8 functions, JSON support)
- **Web server** (Apache, Nginx, or PHP built-in for local dev)
- **No database required**
- **No external dependencies**

---

## 📊 Diseases Included

1. Acute Respiratory Infection (ARI)
2. Malaria
3. Tuberculosis (TB)
4. Typhoid Fever
5. Cholera
6. Dengue Fever
7. Diabetes Mellitus Type 2
8. Hypertension
9. Pneumonia
10. Influenza (Flu)
11. HIV/AIDS
12. Hepatitis B
13. Asthma
14. Eczema (Atopic Dermatitis)
15. Obesity
16. Depression

---

## 📝 License & Disclaimer

This application is provided for **educational and reference purposes only**.  
**Always consult healthcare professionals** for diagnosis and treatment recommendations.  
Data extracted from medical references; accuracy should be verified before clinical use.

---

## 💬 Support

For customization or integration help:
1. Check the commented code in `/app/search.php` and `/app/assets/js/app.js`
2. Verify `/app/data/diseases.json` is properly formatted (validate with a JSON linter)
3. Test the API directly: visit `http://localhost:8000/search.php?q=malaria` in your browser

---

**Built with clean architecture, accessibility, and developer experience in mind.**  
*Last updated: April 2026*

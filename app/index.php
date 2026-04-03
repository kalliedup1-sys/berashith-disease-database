<?php
/**
 * index.php - Disease Search App Frontend
 * Clean, modern UI with live search capability
 */
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Disease Search — Find Health Information Instantly</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <!-- Hero Section -->
    <header class="hero">
      <h1>🏥 Disease Search</h1>
      <p class="lead">Quickly find structured, evidence-based disease information</p>
      
      <!-- Search Bar -->
      <div class="search-wrapper">
        <div class="search-box">
          <input 
            id="searchInput" 
            type="search" 
            placeholder="Search diseases, symptoms, causes..." 
            aria-label="Search diseases and conditions"
            autocomplete="off"
          >
          <span class="search-icon">🔍</span>
        </div>
      </div>
    </header>

    <!-- Results Section -->
    <main id="results" class="results-grid"></main>

    <!-- Footer -->
    <footer class="footer">
      <p>📊 <strong>16</strong> diseases | ⚡ JSON-powered | 🔓 No database | 📱 Fully responsive</p>
      <p style="font-size:12px; color:#999; margin-top:8px;">
        Data extracted from medical reference. Always consult healthcare professionals for diagnosis and treatment.
      </p>
    </footer>
  </div>

  <script src="assets/js/app.js"></script>
</body>
</html>

module.exports = {
  // Disable PHP support since PHP isn't properly installed
  php: false,
  
  // Server configuration
  host: "127.0.0.1",
  port: 5500,
  
  // Open index-static.html by default (the standalone version)
  open: "/app/index-static.html",
  
  // Watch these file extensions
  extensions: [".html", ".css", ".js", ".json"],
  
  // Live reload enabled
  liveReload: true,
  
  // Navigation fallback
  navigateFallback: "/app/index-static.html"
};

<?php
/**
 * Deploy files from GitHub directly (no git required)
 * Usage: Run this once in cPanel, then delete it
 */

$files = [
    'app.html' => 'https://raw.githubusercontent.com/kalliedup1-sys/berashith-disease-database/master/app/app.html',
    'diseases-complete-new.js' => 'https://raw.githubusercontent.com/kalliedup1-sys/berashith-disease-database/master/app/diseases-complete-new.js'
];

echo "Starting deployment from GitHub...\n\n";

foreach ($files as $filename => $url) {
    echo "Downloading: $filename\n";
    echo "From: $url\n";
    
    $content = file_get_contents($url);
    
    if ($content === false) {
        echo "❌ ERROR: Failed to download $filename\n";
        echo "Error: " . error_get_last()['message'] . "\n\n";
        continue;
    }
    
    // Save to current directory
    $bytes = file_put_contents($filename, $content);
    
    if ($bytes === false) {
        echo "❌ ERROR: Failed to save $filename\n\n";
        continue;
    }
    
    echo "✅ SUCCESS: Downloaded and saved $filename (" . filesize($filename) . " bytes)\n\n";
}

echo "Deployment complete!\n";
echo "Files downloaded to: " . getcwd() . "\n";
?>

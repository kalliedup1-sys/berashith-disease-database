<?php
/**
 * PDF Text Extraction and Parsing
 * Extracts all diseases from PDF and converts to JSON
 */

$pdf_path = 'C:\\Ai PROJEKTE\\Berashith_Deseaces\\doc\\Online_Sicknesses__Diseases_FINAL_2026.pdf';

if (!file_exists($pdf_path)) {
    die("PDF not found: $pdf_path\n");
}

// Try to read PDF using shell command
$temp_txt = sys_get_temp_dir() . 'diseases_extracted.txt';

// Try different PDF extraction tools
$commands = [
    "pdftotext \"$pdf_path\" \"$temp_txt\"",  // Linux/Mac with poppler
    "powershell -Command \"Add-Type -AssemblyName System.Windows.Forms; [System.Windows.Forms.SendKeys]::SendWait('%{F4}')\"" // Windows
];

foreach ($commands as $cmd) {
    @shell_exec($cmd . ' 2>&1');
    if (file_exists($temp_txt)) {
        break;
    }
}

// If extraction failed, provide instructions
if (!file_exists($temp_txt)) {
    ?>
<!DOCTYPE html>
<html>
<head>
    <title>PDF Extraction - Manual Upload</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .box { background: #f0f0f0; padding: 20px; border-radius: 8px; margin: 20px 0; }
        h2 { color: #667eea; }
        .code { background: #222; color: #0f0; padding: 15px; border-radius: 5px; font-family: monospace; overflow-x: auto; }
        button { background: #667eea; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; }
        textarea { width: 100%; height: 400px; font-family: monospace; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>📄 Disease Data Extraction</h1>
    
    <div class="box">
        <h2>Step 1: Extract Text from PDF</h2>
        <p>Your system doesn't have PDF extraction tools installed. Here's how to extract the text:</p>
        
        <h3>Option A: Using Adobe Reader (Easiest)</h3>
        <ol>
            <li>Open: C:\Ai PROJEKTE\Berashith_Deseaces\doc\Online_Sicknesses__Diseases_FINAL_2026.pdf</li>
            <li>Select All (Ctrl+A)</li>
            <li>Copy (Ctrl+C)</li>
            <li>Paste below ↓</li>
        </ol>
        
        <h3>Option B: Export to Text</h3>
        <ol>
            <li>In Adobe Reader: Tools → Export PDF → Text</li>
            <li>Save as diseases_text.txt</li>
            <li>Upload here</li>
        </ol>
    </div>

    <div class="box">
        <h2>Step 2: Paste or Upload Text Content</h2>
        <form method="POST" enctype="multipart/form-data">
            <h3>Upload Text File:</h3>
            <input type="file" name="textfile" accept=".txt" />
            <button type="submit" name="action" value="upload">Upload & Process</button>
        </form>
        
        <h3>OR Paste Text Content:</h3>
        <form method="POST">
            <textarea name="textcontent" placeholder="Paste all PDF text content here..."></textarea>
            <button type="submit" name="action" value="paste">Process Pasted Text</button>
        </form>
    </div>

    <?php
    // Handle file upload or pasted content
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $text_content = '';
        
        if ($_POST['action'] === 'upload' && isset($_FILES['textfile'])) {
            $text_content = file_get_contents($_FILES['textfile']['tmp_name']);
        } elseif ($_POST['action'] === 'paste' && isset($_POST['textcontent'])) {
            $text_content = $_POST['textcontent'];
        }
        
        if ($text_content) {
            // Parse diseases from text
            $diseases = parseDiseases($text_content);
            generateJSON($diseases);
        }
    }
    
    function parseDiseases($text) {
        $diseases = [];
        
        // Split by disease blocks - look for patterns like "NAME\nDESCRIPTION\nGENERAL\nROOTS\nRECOMMENDATIONS"
        $lines = explode("\n", $text);
        $current_disease = null;
        $current_field = null;
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Detect field headers
            if (strtoupper($line) === 'NAME') {
                if ($current_disease) {
                    $diseases[] = $current_disease;
                }
                $current_disease = ['name' => '', 'description' => '', 'general' => '', 'roots' => '', 'recommendations' => ''];
                $current_field = 'name';
            } elseif (strtoupper($line) === 'DESCRIPTION') {
                $current_field = 'description';
            } elseif (strtoupper($line) === 'GENERAL') {
                $current_field = 'general';
            } elseif (strtoupper($line) === 'ROOTS') {
                $current_field = 'roots';
            } elseif (strtoupper($line) === 'RECOMMENDATIONS') {
                $current_field = 'recommendations';
            } elseif ($current_disease && $current_field) {
                $current_disease[$current_field] .= $line . ' ';
            }
        }
        
        if ($current_disease) {
            $diseases[] = $current_disease;
        }
        
        return $diseases;
    }
    
    function generateJSON($diseases) {
        $json_data = [];
        foreach ($diseases as $index => $disease) {
            $json_data[] = [
                'id' => $index + 1,
                'name' => trim($disease['name']),
                'description' => trim($disease['description']),
                'general' => trim($disease['general']),
                'roots' => trim($disease['roots']),
                'recommendations' => trim($disease['recommendations'])
            ];
        }
        
        $json = json_encode($json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        echo "<div class='box'>";
        echo "<h2>✓ Generated JSON (" . count($json_data) . " diseases found)</h2>";
        echo "<textarea>" . htmlspecialchars($json) . "</textarea><br><br>";
        echo "<button onclick=\"downloadJSON()\">Download diseases.json</button>";
        echo "<button onclick=\"copyJSON()\">Copy JSON</button>";
        echo "</div>";
        
        echo "<script>
        function downloadJSON() {
            const json = document.querySelector('textarea').value;
            const blob = new Blob([json], {type: 'application/json'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'diseases.json';
            a.click();
        }
        function copyJSON() {
            const json = document.querySelector('textarea').value;
            navigator.clipboard.writeText(json);
            alert('Copied!');
        }
        </script>";
    }
    ?>
</body>
</html>
    <?php
} else {
    echo "PDF extraction succeeded!\n";
}
?>

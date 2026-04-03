<?php
// PDF Extraction Script using PHP
// Requires: TCPDF or similar PDF library

$pdf_path = 'C:\\Ai PROJEKTE\\Berashith_Deseaces\\doc\\Online_Sicknesses__Diseases_FINAL_2026.pdf';

// Check if PDF exists
if (!file_exists($pdf_path)) {
    die("PDF file not found: $pdf_path\n");
}

echo "PDF file found: $pdf_path\n";
echo "File size: " . filesize($pdf_path) . " bytes\n";

// Try using pdftotext command (Windows)
$output_file = 'C:\\Ai PROJEKTE\\Berashith_Deseaces\\extracted_text.txt';

// Check if pdftotext is available
$command = "pdftotext \"$pdf_path\" \"$output_file\" 2>&1";
echo "Running command: $command\n";

$output = shell_exec($command);
echo "Output: $output\n";

if (file_exists($output_file)) {
    echo "✓ Successfully extracted text!\n";
    $text = file_get_contents($output_file);
    echo "Extracted " . strlen($text) . " characters\n";
    echo "First 500 characters:\n";
    echo substr($text, 0, 500);
} else {
    echo "✗ Text extraction failed\n";
    echo "pdftotext may not be installed.\n";
    echo "Install with: choco install poppler (requires Chocolatey)\n";
}
?>

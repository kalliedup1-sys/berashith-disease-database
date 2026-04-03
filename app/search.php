<?php
/**
 * search.php - Lightweight API endpoint for disease search
 * Accepts: GET parameter 'q' (query string)
 * Returns: JSON array of matching disease objects
 * Features: case-insensitive, partial keyword matching, sorted by relevance
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Load diseases.json
$json_path = __DIR__ . '/data/diseases.json';

if (!file_exists($json_path)) {
    http_response_code(404);
    echo json_encode(['error' => 'Data file not found']);
    exit;
}

$json_raw = @file_get_contents($json_path);
if (!$json_raw) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to read data file']);
    exit;
}

$diseases = json_decode($json_raw, true);
if (!is_array($diseases)) {
    http_response_code(500);
    echo json_encode(['error' => 'Invalid data format']);
    exit;
}

// Get query parameter
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$limit = 50;

// If no query, return first 10 items (browse mode)
if (empty($query)) {
    echo json_encode(array_slice($diseases, 0, 10));
    exit;
}

// Convert query to lowercase for comparison
$query_lower = mb_strtolower($query, 'UTF-8');
$query_len = mb_strlen($query_lower, 'UTF-8');

$results = [];
$scored_results = [];

// Search and score results
foreach ($diseases as $disease) {
    $score = 0;
    
    // Name match (highest weight)
    if (!empty($disease['name'])) {
        $name_lower = mb_strtolower($disease['name'], 'UTF-8');
        if ($name_lower === $query_lower) {
            $score += 1000; // Exact name match
        } elseif (strpos($name_lower, $query_lower) === 0) {
            $score += 500; // Name starts with query
        } elseif (mb_strpos($name_lower, $query_lower) !== false) {
            $score += 300; // Name contains query
        }
    }
    
    // Symptoms match
    if (!empty($disease['symptoms']) && $score < 200) {
        $symptoms_lower = mb_strtolower($disease['symptoms'], 'UTF-8');
        if (mb_strpos($symptoms_lower, $query_lower) !== false) {
            $score += 150;
        }
    }
    
    // Cause match
    if (!empty($disease['cause']) && $score < 200) {
        $cause_lower = mb_strtolower($disease['cause'], 'UTF-8');
        if (mb_strpos($cause_lower, $query_lower) !== false) {
            $score += 100;
        }
    }
    
    // Tags match
    if (!empty($disease['tags']) && is_array($disease['tags'])) {
        foreach ($disease['tags'] as $tag) {
            $tag_lower = mb_strtolower($tag, 'UTF-8');
            if (strpos($tag_lower, $query_lower) !== false) {
                $score += 50;
                break;
            }
        }
    }
    
    // Description match
    if (!empty($disease['description']) && $score < 50) {
        $desc_lower = mb_strtolower($disease['description'], 'UTF-8');
        if (mb_strpos($desc_lower, $query_lower) !== false) {
            $score += 25;
        }
    }
    
    if ($score > 0) {
        $disease['_score'] = $score;
        $scored_results[] = $disease;
    }
}

// Sort by score (descending)
usort($scored_results, function($a, $b) {
    return $b['_score'] - $a['_score'];
});

// Limit and remove scores before returning
$results = array_slice($scored_results, 0, $limit);
foreach ($results as &$r) {
    unset($r['_score']);
}

echo json_encode($results);
exit;
?>

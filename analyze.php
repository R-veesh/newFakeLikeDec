<?php
// Allow cross-origin (for localhost)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Receive JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['names'])) {
    echo json_encode(['error' => 'No names received']);
    exit;
}

$names = $data['names'];
$total = count($names);
$realCount = 0;
$fakeCount = 0;
$fakeNames = [];

foreach ($names as $name) {
    $name = trim($name);
    if (isFakeName($name)) {
        $fakeCount++;
        $fakeNames[] = $name;
    } else {
        $realCount++;
    }
}

echo json_encode([
    'total' => $total,
    'real' => $realCount,
    'fake' => $fakeCount,
    'fakeNames' => $fakeNames
]);

function isFakeName($name) {
    // Fake if contains many non-English letters
    if (preg_match('/^[A-Za-z ]+$/', $name)) {  // Non-ASCII characters
        return true;
    }

    // Fake if too short
    if (strlen($name) < 3) {
        return true;
    }

    // Fake if many spaces (suspicious)
    if (substr_count($name, ' ') > 2) {
        return true;
    }

    // Add more fake detection rules if you want
    return false;
}
?>

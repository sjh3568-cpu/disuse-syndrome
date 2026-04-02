<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$dataFile = __DIR__ . '/data/results.json';

$input = json_decode(file_get_contents('php://input'), true);
$idx = $input['index'] ?? null;

if ($idx === null || !is_int($idx)) {
    http_response_code(400);
    echo json_encode(['error' => 'index required']);
    exit;
}

$fp = fopen($dataFile, 'c+');
if (!$fp) {
    http_response_code(500);
    echo json_encode(['error' => 'Cannot open data file']);
    exit;
}

flock($fp, LOCK_EX);

$existing = [];
$size = filesize($dataFile);
if ($size > 0) {
    $content = fread($fp, $size);
    $existing = json_decode($content, true) ?: [];
}

if ($idx < 0 || $idx >= count($existing)) {
    flock($fp, LOCK_UN);
    fclose($fp);
    http_response_code(400);
    echo json_encode(['error' => 'Invalid index']);
    exit;
}

array_splice($existing, $idx, 1);

ftruncate($fp, 0);
rewind($fp);
fwrite($fp, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

flock($fp, LOCK_UN);
fclose($fp);

echo json_encode(['success' => true, 'count' => count($existing)]);

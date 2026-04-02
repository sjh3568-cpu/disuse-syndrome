<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$dataDir  = __DIR__ . '/data';
$dataFile = $dataDir . '/results.json';

if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
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

$existing[] = $input;

ftruncate($fp, 0);
rewind($fp);
fwrite($fp, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

flock($fp, LOCK_UN);
fclose($fp);

echo json_encode(['success' => true, 'count' => count($existing)]);

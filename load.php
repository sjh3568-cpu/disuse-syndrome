<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$dataFile = __DIR__ . '/data/results.json';

if (!file_exists($dataFile)) {
    echo json_encode([]);
    exit;
}

$fp = fopen($dataFile, 'r');
flock($fp, LOCK_SH);
$size = filesize($dataFile);
$content = $size > 0 ? fread($fp, $size) : '[]';
flock($fp, LOCK_UN);
fclose($fp);

$data = json_decode($content, true) ?: [];
echo json_encode($data, JSON_UNESCAPED_UNICODE);

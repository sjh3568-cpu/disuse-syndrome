<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$dataFile = __DIR__ . '/data/results.json';

// data 폴더 없으면 생성
if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0755, true);
}

// POST 요청만 허용
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'msg' => 'POST only']);
    exit;
}

$input = file_get_contents('php://input');
$data  = json_decode($input, true);

if (!$data || empty($data['name'])) {
    echo json_encode(['ok' => false, 'msg' => 'invalid data']);
    exit;
}

// 기존 데이터 읽기
$results = [];
if (file_exists($dataFile)) {
    $results = json_decode(file_get_contents($dataFile), true) ?: [];
}

// 새 결과 추가
$results[] = [
    'name'  => htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'),
    'date'  => $data['date'],
    'score' => (int)$data['score'],
    'total' => (int)$data['total'],
    'items' => $data['items']   // 문항별 정오
];

// 저장
file_put_contents($dataFile, json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode(['ok' => true]);

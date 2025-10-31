<?php
// app/api.php

require_once 'database.php';
require_once 'host.php';

header('Content-Type: application/json');

$dbStatus = getDatabaseStatus();
$hostInfo = getHostInfo();

$response = [
    'container' => $hostInfo,
    'database' => [
        'connected' => $dbStatus['connected'],
    ],
];

if ($dbStatus['connected']) {
    $response['database']['version'] = $dbStatus['db_version'];
} else {
    http_response_code(503);
    $response['database']['error'] = isset($dbStatus['error']) ? $dbStatus['error'] : 'Erro desconhecido.';
}

echo json_encode($response);
?>

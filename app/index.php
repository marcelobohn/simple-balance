<?php
// app/index.php

require_once 'database.php';
require_once 'host.php';

$hostInfo = getHostInfo();

echo "<h1>Hello from PHP Container: " . htmlspecialchars($hostInfo['hostname']) . "</h1>";
echo "<p>Try refreshing the page to see the hostname change (Load Balancing).</p>";
$phpVersion = isset($hostInfo['php_version']) ? $hostInfo['php_version'] : PHP_VERSION;
echo "<p>PHP Version: " . htmlspecialchars($phpVersion) . "</p>";

$dbStatus = getDatabaseStatus();

if ($dbStatus['connected']) {
    echo "<h3>✅ Conexão PostgreSQL SUCESSO!</h3>";
    echo "<p>Versão do Banco de Dados: " . htmlspecialchars($dbStatus['db_version']) . "</p>";
} else {
    echo "<h3>❌ Conexão PostgreSQL FALHOU!</h3>";
    $error = isset($dbStatus['error']) ? $dbStatus['error'] : 'Erro desconhecido.';
    echo "<p>Erro: " . htmlspecialchars($error) . "</p>";
}
?>

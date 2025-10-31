<?php
// app/database.php

$host = 'postgres_db'; // Nome do serviço no docker-compose
$port = '5432';
$dbname = 'mydatabase';
$user = 'myuser';
$password = 'mypassword';

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Teste de consulta simples
    $result = $conn->query("SELECT version()");
    $db_version = $result->fetchColumn();

    echo "<h3>✅ Conexão PostgreSQL SUCESSO!</h3>";
    echo "<p>Versão do Banco de Dados: " . htmlspecialchars($db_version) . "</p>";

} catch (PDOException $e) {
    echo "<h3>❌ Conexão PostgreSQL FALHOU!</h3>";
    echo "<p>Erro: " . $e->getMessage() . "</p>";
}
?>

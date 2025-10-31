<?php
// app/database.php

function getDatabaseStatus(): array
{
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
        $dbVersion = $result->fetchColumn();

        return [
            'connected' => true,
            'db_version' => $dbVersion,
        ];
    } catch (PDOException $e) {
        return [
            'connected' => false,
            'error' => $e->getMessage(),
        ];
    }
}
?>

<?php
// app/index.php

echo "<h1>Hello from PHP Container: " . gethostname() . "</h1>";
echo "<p>Try refreshing the page to see the hostname change (Load Balancing).</p>";

// Inclui o teste do banco de dados
include 'database.php';

?>

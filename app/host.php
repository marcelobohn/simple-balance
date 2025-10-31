<?php
// app/host.php

function getHostInfo(): array
{
    return [
        'hostname' => gethostname(),
        'php_version' => PHP_VERSION,
    ];
}
?>

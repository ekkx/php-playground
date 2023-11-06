<?php

$dsn = 'mysql:host=mysql;dbname=todo;';
$username = 'root';
$password = 'root';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection Error: ' . $e->getMessage();
}

<?php
$dbCredentials = require(__DIR__ . '/../config/database.php');

try {
    $database = new PDO('mysql:dbname=' . $dbCredentials['database'] . ';host=' . $dbCredentials['host'], $dbCredentials['user'], $dbCredentials['password']);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
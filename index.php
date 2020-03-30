<?php
require(__DIR__ . '/inc/database.php');

$database->exec('CREATE TABLE IF NOT EXISTS results (id INTEGER PRIMARY KEY, result VARCHAR)');
$resultRows = $database->query('SELECT * FROM results ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

$players = require(__DIR__ . '/config/players.php');
$settings = require(__DIR__ . '/config/settings.php');

$groups = array_unique(array_column($players, 'group'));
$results = array_column($resultRows, 'result');

$regex = "/(.*) (\d-\d) (.*)/";

include(__DIR__ . '/inc/process_results.php');
include(__DIR__ . '/inc/sort_players.php');
include(__DIR__ . '/view/index.php');
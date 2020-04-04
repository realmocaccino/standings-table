<?php
require(__DIR__ . '/includes/database.php');

$database->exec('CREATE TABLE IF NOT EXISTS results (id INTEGER PRIMARY KEY, result VARCHAR)');
$resultRows = $database->query('SELECT * FROM results ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

$players = require(__DIR__ . '/configs/players.php');
$settings = require(__DIR__ . '/configs/settings.php');

$groups = array_unique(array_column($players, 'group'));
$results = array_column($resultRows, 'result');

$quarterFinalists = [];

$regex = "/(.*) (\d-\d) (.*)/";

include(__DIR__ . '/includes/process_results.php');
include(__DIR__ . '/includes/sort_players.php');
include(__DIR__ . '/includes/define_brackets.php');
include(__DIR__ . '/views/index.php');
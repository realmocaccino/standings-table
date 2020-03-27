<?php
require(__DIR__ . '/../inc/database.php');

$stmt = $database->prepare("DELETE FROM results WHERE id = ?");
$stmt->execute([$_GET['result_id']]);

header('Location: ..');
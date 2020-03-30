<?php
require(__DIR__ . '/../includes/database.php');

if(isset($_GET['result_id']) and $_GET['result_id']) {
    $stmt = $database->prepare("DELETE FROM results WHERE id = ?");
    $stmt->execute([$_GET['result_id']]);
}

header('Location: ..');
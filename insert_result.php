<?php
require(__DIR__ . '/inc/database.php');

$players = require(__DIR__ . '/config/players.php');
$playerNames = array_column($players, 'name');

if(isset($_POST['result']) and $_POST['result']) {
    $result = $_POST['result'];
    
    $regex = "/(.*) (\d-\d) (.*)/";

    preg_match($regex, $result, $matches);

    $errorMessage = null;

    if($matches) {
        list(, $playerName1, $score, $playerName2) = $matches;

        list($score1, $score2) = explode('-', $score);

        if(!$playerName1 || !$playerName2) {
            $errorMessage = 'Two players must be reported';
        }
        
        $player1 = $players[array_search($playerName1, $playerNames)];
        $player2 = $players[array_search($playerName2, $playerNames)];

        if(!$player1) {
            $errorMessage = 'Player ' . $playerName1 . ' doesn\'t exist';
        }
        
        if(!$player2) {
            $errorMessage = 'Player ' . $playerName2 . ' doesn\'t exist';
        }
        
        if($player1['group'] != $player2['group']) {
            $errorMessage = 'Players aren\'t of the same group';
        }
        
        if($playerName1 == $playerName2) {
            $errorMessage = 'Players are the same';
        }
        
        if(!isset($score1) || !isset($score2)) {
            $errorMessage = 'Wrong format of the score';
        }
        
        if($score1 > 3 || $score1 < 0 || $score2 > 3 || $score2 < 0) {
            $errorMessage = 'Score can\'t be greater than 3 or lesser than 0';
        }
    } else {
        $errorMessage = 'Wrong format';
    }

    if(!$errorMessage) {
        $stmt = $database->prepare("INSERT INTO results (result) VALUES (?)");
        $stmt->execute([trim($result)]);
    }
}

header('Location: .' . ($errorMessage ? '/?message=' . $errorMessage . '&result=' . $result : null));
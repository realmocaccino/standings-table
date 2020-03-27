<?php
require(__DIR__ . '/inc/database.php');

$resultRows = $database->query('SELECT * FROM results ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

$players = require(__DIR__ . '/config/players.php');
$settings = require(__DIR__ . '/config/settings.php');

$groups = array_unique(array_column($players, 'group'));
$playerNames = array_column($players, 'name');
$results = array_column($resultRows, 'result');

$regex = "/(.*) (\d-\d) (.*)/";

foreach($results as $result) {
    preg_match($regex, $result, $matches);

    if($matches) {
        list(, $playerName1, $score, $playerName2) = $matches;
        list($score1, $score2) = explode('-', $score);

        if($score1 > $score2) {
            $winnerName = $playerName1;
            $winnerGames = $score1;
            $loserName = $playerName2;
            $loserGames = $score2;
        } else {
            $winnerName = $playerName2;
            $winnerGames = $score2;
            $loserName = $playerName1;
            $loserGames = $score1;
        }
        
        $winnerPlayer = &$players[array_search($winnerName, $playerNames)];
        $loserPlayer = &$players[array_search($loserName, $playerNames)];

        if($winnerPlayer and $loserPlayer) {
            $winnerPlayer['sw']++;

            $winnerPlayer['gw'] = $winnerPlayer['gw'] + $winnerGames;
            $loserPlayer['gw'] = $loserPlayer['gw'] + $loserGames;
            
            $winnerPlayer['gl'] = $winnerPlayer['gl'] + $loserGames;
            $loserPlayer['gl'] = $loserPlayer['gl'] + $winnerGames;
            
            $winnerPlayer['gd'] = $winnerPlayer['gw'] - $winnerPlayer['gl'];
            $loserPlayer['gd'] = $loserPlayer['gw'] - $loserPlayer['gl'];

            $winnerPlayer['sp']++;
            $loserPlayer['sp']++;
            
            $winnerPlayer['pe'] = floor(($winnerPlayer['sw'] / $winnerPlayer['sp']) * 100). '%';
            $loserPlayer['pe'] = floor(($loserPlayer['sw'] / $loserPlayer['sp']) * 100). '%';
        }
    }
}

uasort($players, function($a, $b) use($results, $regex) {
    if($a['sw'] == $b['sw']) {
        if($a['gd'] == $b['gd']) {
            if($a['gw'] == $b['gw']) {
                $result = preg_grep("/{$b['name']} (\d-\d) {$a['name']}/", $results);
                
                if($result) {
                    $result = array_values($result)[0];
                    
                    preg_match($regex, $result, $matches);
                    
                    list(, , $score) = $matches;
                    list($score1, $score2) = explode('-', $score);

                    if($score1 > $score2) {
                        return 1;
                    } else {
                        return -1;
                    }
                }
            }
            
            return ($a['gw'] < $b['gw']) ? 1 : -1;
        }
    
        return ($a['gd'] < $b['gd']) ? 1 : -1;
    }
    
    return ($a['sw'] < $b['sw']) ? 1 : -1;
});

include(__DIR__ . '/view/index.php');
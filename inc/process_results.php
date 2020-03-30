<?php
$playerNames = array_column($players, 'name');

foreach($results as $result) {
    preg_match($regex, $result, $matches);

    if($matches) {
        list(, $playerName1, $score, $playerName2) = $matches;
        
        if($score != '0-0') {
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
        } else {
            $player1 = &$players[array_search($playerName1, $playerNames)];
            $player2 = &$players[array_search($playerName2, $playerNames)];

            $player1['sp']++;
            $player2['sp']++;

            $player1['pe'] = floor(($player1['sw'] / $player1['sp']) * 100). '%';
            $player2['pe'] = floor(($player2['sw'] / $player2['sp']) * 100). '%';
        }
    }
}
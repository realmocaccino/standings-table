<?php
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
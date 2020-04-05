<!doctype html>
<html>
    <head>
        <title><?php echo $settings['tournament_secondary_name']; ?> Standings - <?php echo $settings['tournament_primary_name']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/styles.css">
        <link rel="stylesheet" href="public/css/tabs.css">
        <script src="public/js/scripts.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <img id="logo" src="public/img/logo.jpg">
                    <h3><?php echo $settings['tournament_primary_name']; ?></h3>
                    <em><?php echo $settings['tournament_secondary_name']; ?></em>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="radio" name="tabs" id="tab1" checked>
                    <label for="tab1">Groups stage</label>
                    <input type="radio" name="tabs" id="tab2">
                    <label for="tab2">Quarter-finals</label>
                    <input type="radio" name="tabs" id="tab3">
                    <label for="tab3">Relegation</label>
                    <div class="row tab content1">
                        <div class="col-lg-8 col-12">
                            <div class="row">
                                <?php foreach($groups as $group): ?>
                                    <?php $pos = 1; ?>
                                    <div class="col-lg-6 col-12">
                                        <table class="table group">
                                            <tr>
                                                <th colspan="8" class="text-left">Group <?php echo $group; ?></th>
                                            </tr>
                                            <tr>
                                                <th width="8%">Pos</th>
                                                <th class="text-left">Name</th>
                                                <th width="8%">SW</th>
                                                <th width="8%">SP</th>
                                                <th width="8%">GW</th>
                                                <th width="8%">GL</th>
                                                <th width="8%">GD</th>
                                                <th width="8%">%</th>
                                            </tr>
                                            <?php foreach(array_filter($players, function($var) use($group) { return $var['group'] == $group; }) as $player): ?>
                                                <?php $quarterFinalists[$pos . $group] = $player['name']; ?>
                                                <tr class="position-<?php echo $pos; ?>">
                                                    <td><strong><?php echo $pos++; ?>º</strong></td>
                                                    <td class="text-left playerName" title="Click to insert player name in result input"><?php echo $player['name']; ?></td>
                                                    <td><strong><?php echo $player['sw']; ?></strong></td>
                                                    <td><?php echo $player['sp']; ?></td>
                                                    <td><?php echo $player['gw']; ?></td>
                                                    <td><?php echo $player['gl']; ?></td>
                                                    <td><strong><?php echo $player['gd']; ?></strong></td>
                                                    <td><?php echo $player['pe']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="8" class="caption align-bottom text-right">SW = Series Won | SP = Series played | GW = Games Won | GL = Games Lost | GD = Games Difference</td>
                                            </tr>
                                        </table>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <h5>
                                        <label for="result-search-input">
                                            Results
                                        </label>
                                    </h5>
                                    <hr class="results-hr">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="results" <?php if(!$isAdmin) { ?> class="results-long" <?php } ?>>
                                        <div class="input-group">
                                           <input type="text" id="result-search-input" class="form-control" placeholder="Search for result(s)">
                                        </div>
                                        <table class="table">
                                            <?php if($results): ?>
                                            <?php foreach($resultRows as $result): ?>
                                            <?php if($result['result']): ?>
                                            <tr>
                                                <td width="85%">
                                                    <?php
                                                        preg_match($regex, $result['result'], $matches);
                                                        
                                                        if($matches) {
                                                            list($score1, $score2) = explode('-', $matches[2]);
                                                            
                                                            if($score1 > $score2) {
                                                                echo preg_replace("/(.*) (\d)-(\d) (.*)/", "<strong><span class='playerName'>$1</span> $2</strong>-$3 <span class='playerName'>$4</span>", $result['result']);
                                                            } elseif($score2 > $score1) {
                                                                echo preg_replace("/(.*) (\d)-(\d) (.*)/", "<span class='playerName'>$1</span> $2-<strong>$3 <span class='playerName'>$4</span></strong>", $result['result']);
                                                            } else {
                                                                echo preg_replace("/(.*) (\d)-(\d) (.*)/", "<span class='playerName'>$1</span> $2-$3 <span class='playerName'>$4</span>", $result['result']);
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td width="15%">
                                                    <?php if($isAdmin) { ?>
                                                        <a href="actions/delete_result.php?result_id=<?php echo $result['id']; ?>" class="text-danger">delete</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="2">No results entered yet</td>
                                            </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                    <?php if($isAdmin) { ?>
                                        <h5>
                                            <label for="result-insert-input">Insert a result</label>
                                        </h5>
                                        <hr class="results-hr">
                                        <form method="post" action="actions/insert_result.php">
                                            <div class="input-group">
                                               <input type="text" id="result-insert-input" class="form-control" name="result" placeholder="Ex: dzon 3-1 mocaccino" pattern="(.*) [0-3]-[0-3] (.*)" <?php if(isset($_GET['result'])) { ?> value="<?php echo $_GET['result']; ?>" <?php } ?> required>
                                               <span class="input-group-btn">
                                                    <input type="submit" class="btn btn-primary float-right" value="Send">
                                               </span>
                                            </div>
                                            <?php if(isset($_GET['message'])): ?>
                                                <div class="invalid-feedback d-block"><?php echo $_GET['message']; ?></div>
                                            <?php endif; ?>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row tab content2">
                        <div class="col-12">
                            <h2>Quarter-finals</h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><span class="badge badge-primary badge-pill">QF1</span> <?php echo $quarterFinalists['1A'] . ' <strong>vs</strong> ' . $quarterFinalists['4B']; ?></li>
                                <li class="list-group-item"><span class="badge badge-primary badge-pill">QF2</span> <?php echo $quarterFinalists['2B'] . ' <strong>vs</strong> ' . $quarterFinalists['3A']; ?></li>
                                <li class="list-group-item"><span class="badge badge-primary badge-pill">QF3</span> <?php echo $quarterFinalists['1B'] . ' <strong>vs</strong> ' . $quarterFinalists['4A']; ?></li>
                                <li class="list-group-item"><span class="badge badge-primary badge-pill">QF4</span> <?php echo $quarterFinalists['2A'] . ' <strong>vs</strong> ' . $quarterFinalists['3B']; ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row tab content3">
                        <div class="col-12">
                            <h2>Relegation</h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><span class="badge badge-primary badge-pill">R1</span> <?php echo $quarterFinalists['7A'] . ' <strong>vs</strong> ' . $quarterFinalists['8B']; ?></li>
                                <li class="list-group-item"><span class="badge badge-primary badge-pill">R2</span> <?php echo $quarterFinalists['7B'] . ' <strong>vs</strong> ' . $quarterFinalists['8A']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
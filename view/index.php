<!doctype html>
<html>
    <head>
        <title><?php echo $settings['name']; ?> Standings - TnT Championship 2020.1</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/styles.css">
        <script src="public/js/scripts.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <img id="logo" src="public/img/logo.jpg">
                    <h3>Tooth and Tail Championship 2020.1</h3>
                    <em><?php echo $settings['name']; ?></em>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <h5>Standings</h5>
                        </div>
                    </div>
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
                            <div id="results">
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
                                                        echo preg_replace("/(.*) (\d)-(\d) (.*)/", "<strong>$1 $2</strong>-$3 $4", $result['result']);
                                                    } else {
                                                        echo preg_replace("/(.*) (\d)-(\d) (.*)/", "$1 $2-<strong>$3 $4</strong>", $result['result']);
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td width="15%"><a href="delete_result.php?result_id=<?php echo $result['id']; ?>" class="text-danger">delete</a></td>
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
                            <h5>
                                <label for="result-insert-input">Insert a result</label>
                            </h5>
                            <hr class="results-hr">
                            <form method="post" action="insert_result.php">
                                <div class="input-group">
                                   <input type="text" id="result-insert-input" class="form-control" name="result" placeholder="Ex: dzon 3-1 mocaccino" pattern="(.*) [0-3]-[0-3] (.*)" <?php if(isset($_GET['result'])) { ?> value="<?php echo $_GET['result']; ?>" <?php } ?> required>
                                   <span class="input-group-btn">
                                        <input type="submit" class="btn btn-primary float-right" value="Send">
                                   </span>
                                </div>
                                <?php if(isset($_GET['message'])) { ?>
                                    <div class="invalid-feedback d-block"><?php echo $_GET['message']; ?></div>
                               <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php

session_start();

if (@$_POST['user'] == 'indica' && @$_POST['pass'] == 'Z9a2c8w3.120987') {
    $_SESSION['login'] = 1;
}

$db_host = 'mysql01-farm36.kinghost.net';
$db_base = 'xt';
$db_user = 'xt';
$db_pass = 'ZqM0Ncxpzn';

function select($sql) {
    global $pdo;
    $return = [];
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->columnCount() > 0) {
        while ($row = @$statement->fetch(PDO::FETCH_OBJ)) {
            $return[] = $row;
        }
    }
    return $return;
}

$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <title>!indica | log</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/x-icon"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;300;400;700&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
    <?php
    $qtd_indica = select("SELECT count(*) AS qtd FROM `indica`");
    $streamer_usando = select("SELECT * FROM (SELECT `caller` AS canal, count(*) AS qtd FROM `logs` GROUP BY `caller`) sub WHERE sub.canal != '' ORDER BY sub.qtd DESC");
    $streamer_indicado = select("SELECT * FROM (SELECT channel AS canal, count(*) AS qtd FROM `logs` GROUP BY channel) sub WHERE sub.canal != '' ORDER BY sub.qtd DESC");
    $jogo_jogado = select("SELECT * FROM (SELECT i.game, count(*) AS qtd FROM (SELECT DISTINCT channel, game FROM `logs`) AS i GROUP BY i.game) sub  WHERE sub.game != '' ORDER BY sub.qtd DESC");
    if (!$_SESSION['login']) : ?>
        <div style="margin:40px auto;display:block;width:300px;text-align:center;">
            <form method="post">
                Login <input type="text" name="user"><br><br>
                Senha <input type="text" name="pass"><br><br>
                <button type="submit">Entrar</button>
            </form>
        </div>
    <?php else : ?>
        <h2>STREAMERS USANDO !INDICA</h2>
        <table>
        <tr><th>#</th><th>CANAL</th><th>QTD</th></tr>
        <?php foreach ($streamer_usando as $i => $s) : ?>
            <tr><td><?php echo $i + 1?></td><td><a target="_blank" href="https://twitch.tv/<?php echo $s->canal ?>"><?php echo $s->canal ?></a></td><td><?php echo $s->qtd ?></td></tr>
        <?php endforeach ?>
        </table>
        <h2>STREAMERS !INDICADOS</h2>
        <table>
        <tr><th>#</th><th>CANAL</th><th>QTD</th></tr>
        <?php foreach ($streamer_indicado as $i => $s) : ?>
            <tr><td><?php echo $i + 1 ?></td><td><a target="_blank" href="https://twitch.tv/<?php echo $s->canal ?>"><?php echo $s->canal ?></a></td><td><?php echo $s->qtd ?></td></tr>
        <?php endforeach ?>
        </table>
        <h2>JOGO MAIS !INDICADO</h2>
        <table>
        <tr><th>#</th><th>JOGO</th><th>QTD</th></tr>
        <?php foreach ($jogo_jogado as $i => $s) : ?>
            <tr><td><?php echo $i + 1 ?></td><td><a target="_blank" href="https://www.twitch.tv/directory/game/<?php echo $s->game ?>"><?php echo $s->game ?></a></td><td><?php echo $s->qtd ?></td></tr>
        <?php endforeach ?>
        </table>
    <?php endif ?>
</body>
</html>

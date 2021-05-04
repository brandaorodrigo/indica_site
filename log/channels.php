<?php

include '../api/config.php';

$pdo = new PDO('mysql:host=' . $db_host .';dbname=' . $db_base, $db_user, $db_pass);

function select($pdo, $sql, $first = false) {
    $return = [];
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->columnCount() > 0) {
        while ($row = @$statement->fetch(PDO::FETCH_OBJ)) {
            if ($first) {
                return $row;
            }
            $return[] = $row;
        }
    }
    return $return;
}

$sql = "SELECT user, image_logo FROM channels WHERE `user` IN ((SELECT `caller` FROM `logs` GROUP BY `caller`)) ORDER BY `date` DESC";
$channels = select($pdo, $sql);

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <title>!indica</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/x-icon"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100;300;400;700&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
    <?php foreach ($channels as $i => $c) : ?>
        <?php if (!strstr($c->image_logo, 'default')) : ?>
            <a target="_blank" href="https://twitch.tv/<?php echo $c->user ?>"><img src="<?php echo $c->image_logo ?>" style="width:4%"/></a>
        <?php endif ?>
    <?php endforeach ?>
</body>
</html>

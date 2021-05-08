<?php

require_once 'db.php';

$sql =
"SELECT
    channels.user,
    channels.image_logo,
    images.image_custom
FROM
    `channels`
LEFT JOIN
    `images`
ON
    images.id = channels.id
WHERE
    channels.game != '(nenhum jogo, ainda)'
AND
    channels.user IN ((SELECT logs.caller FROM `logs` GROUP BY logs.caller))
ORDER BY
    channels.date DESC
";
$channels = select($pdo, $sql);

foreach ($channels as $key => $value) {
    if ($channels[$key]->image_custom) {
        $channels[$key]->image_logo = $value->image_custom;
    }
}

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <title>!indica | mosaic</title>
        <link rel="icon" href="favicon.png" sizes="16x16" type="image/x-icon"/>
        <style>
            body {
                background: #111;
                margin: 0;
                padding: 0;
            }
            a {
                width: 10%;
                padding: 0;
                margin: 0;
                float:left;
                display: block;
                background:#fff;
            }
            img {
                margin: 0 auto;
                display: block;
                width: 100%;
            }
            article {
                background:#444;
                max-width: 960px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
    <article>
    <?php foreach ($channels as $i => $c) : ?>
        <?php if (!strstr($c->image_logo, 'default')) : ?>
            <a target="_blank" href="https://twitch.tv/<?php echo $c->user ?>"><img src="<?php echo $c->image_logo ?>" alt="" onerror="this.onerror = null; this.src = '../api/no_profile.jpg';"/></a>
        <?php endif ?>
    <?php endforeach ?>
    </article>
</body>
</html>

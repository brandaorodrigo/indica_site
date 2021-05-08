<?php

require_once '../api/config.php';

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

<?php

require_once 'libs/models/Ram.php';

$pdo = new PDO('mysql:dbname=bubble-agency;host=127.0.0.1;charset=utf8', 'root', '');

$stm = $pdo->prepare('INSERT INTO ram (login, mdp) VALUES(:login, :mdp)');

$hashed_mdp = password_hash($argv[2], PASSWORD_DEFAULT);

$ok = $stm->execute([
    ':login' => $argv[1],
    ':mdp' => $hashed_mdp,
]);

var_dump($ok);

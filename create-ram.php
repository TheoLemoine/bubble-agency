<?php

require_once 'libs/models/Ram.php';
require_once 'libs/get_pdo.php';

$pdo = get_pdo();

$stm = $pdo->prepare('INSERT INTO ram (login, mdp) VALUES(:login, :mdp)');

$hashed_mdp = password_hash($argv[2], PASSWORD_DEFAULT);

$ok = $stm->execute([
    ':login' => $argv[1],
    ':mdp' => $hashed_mdp,
]);

var_dump($ok);

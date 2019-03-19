<?php

require_once 'libs/models/Ram.php';

$login = 'RAM test';
$mdp = 'test';

$pdo = new PDO('mysql:dbname=bubble-agency;host=127.0.0.1;charset=utf8', 'root', '');

$stm = $pdo->prepare('INSERT INTO ram (login, mdp) VALUES(:login, :mdp)');

$hashed_mdp = password_hash($mdp, PASSWORD_DEFAULT);

$ok = $stm->execute([
    ':login' => $login,
    ':mdp' => $hashed_mdp,
]);

var_dump($ok);

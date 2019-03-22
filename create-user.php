<?php

require_once 'libs/models/Ram.php';
require_once 'libs/models/User.php';
require_once 'libs/get_pdo.php';

$pdo = get_pdo();

$stm = $pdo->prepare('INSERT INTO user (nom, prenom, mail, mdp, ram_id, validated ) VALUES(:nom, :prenom, :mail, :mdp, :ram_id, :validated)');

$hashed_mdp = password_hash($argv[4] ?: 'password', PASSWORD_DEFAULT);

$ok = $stm->execute([
    ':nom' => $argv[1] ?: 'nom',
    ':prenom' => $argv[2] ?: 'prenom',
    ':mail' => $argv[3] ?: 'defaultmail@test.com',
    ':mdp' => $hashed_mdp,
    ':ram_id' => $argv[5] ?: '1',
    ':validated' => $argv[6] ?: '0',
]);

var_dump($ok);

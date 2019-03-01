<?php


require_once '../../libs/get_pdo.php';

session_start();

if(!($_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_POST['mdp'])
    && isset($_POST['nom'])
    && isset($_POST['prenom'])
    && isset($_POST['mail'])
    && isset($_POST['ram'])))
{
    header('Location: ../index.php');
    die;
}

if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
{
    header('Location: connect.php');
    die;
}

$pdo = get_pdo();

$stm = $pdo->prepare('INSERT INTO user (mdp, nom, prenom, mail, ram_id, validated) 
                                VALUES(:mdp, :nom, :prenom, :mail, :ram, 0)');

$ok = $stm->execute([
    ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
    ':nom' => $_POST['nom'],
    ':prenom' => $_POST['prenom'],
    ':mail' => $_POST['mail'],
    ':ram' => intval($_POST['ram']),
]);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Votre compte à bien été ajouté</h1>
</body>
</html>

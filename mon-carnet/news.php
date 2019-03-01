<?php

require_once '../libs/get_pdo.php';
require_once '../libs/models/User.php';
require_once '../libs/models/Post.php';

session_start();

if(!isset($_SESSION['user']))
{
    header('Location: connect.php');
    die;
}

$pdo = get_pdo();

// get all users in the RAM
$stm = $pdo->prepare('SELECT * FROM post WHERE ram_id=:ram_id LIMIT 1');
$stm->execute([
    ':ram_id' => $_SESSION['user']->ram_id,
]);
$post = $stm->fetchObject(Post::class);

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
    <h1><?= htmlspecialchars($post->titre) ?></h1>
    <p>
        <?= htmlspecialchars($post->texte) ?>
    </p>
</body>
</html>

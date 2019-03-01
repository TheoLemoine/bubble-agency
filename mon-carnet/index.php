<?php

require_once '../libs/models/User.php';
require_once '../libs/models/Post.php';
require_once '../libs/get_pdo.php';

session_start();

$pdo = get_pdo();

// redirect if not connected
if(!isset($_SESSION['user']))
{
    header('Location: ./users/connect.php');
    die;
}

// fetch posts linked
$stm = $pdo->prepare('SELECT * FROM post WHERE ram_id=:ram_id');
$stm->execute([
    ':ram_id' => $_SESSION['user']->ram_id,
]);
$posts = $stm->fetchAll(PDO::FETCH_CLASS, Post::class);

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
    <h1>Vous etes connectés en tant que <?= htmlspecialchars($_SESSION['user']->prenom . ' ' . $_SESSION['user']->nom) ?></h1>
    <small><a href="users/edit.php">Modifier vos informations</a></small>
    <div>
        <?php if($_SESSION['user']->validated == 1) : ?>
            <?php foreach ($posts as $post) : ?>
                <a href="news.php?id=<?= $post->id ?>">
                    <div>
                        <h2><?= htmlspecialchars($post->titre) ?></h2>
                        <p>
                            <?= substr(htmlspecialchars($post->texte), 0, 200) . '...'?>
                        </p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else : ?>
            Votre Compte n'a pas encore été validé
        <?php endif; ?>
    </div>
</body>
</html>

<?php

require_once '../libs/models/Ram.php';
require_once '../libs/models/User.php';
require_once '../libs/get_pdo.php';

session_start();

$pdo = get_pdo();

if($_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_POST['ram'])
    && isset($_POST['mdp']))
{
    $stm = $pdo->prepare('SELECT * FROM ram WHERE id=:id');
    $stm->execute([
        ':id' => $_POST['ram'],
    ]);
    $ram = $stm->fetchObject(Ram::class);

    if(password_verify($_POST['mdp'], $ram->mdp)) {
        $_SESSION['ram'] = $ram;
    }
}

if(!isset($_SESSION['ram']))
{
    header('Location: connect.php');
    die;
}

// get all users in the RAM

$stm = $pdo->prepare('SELECT * FROM user WHERE ram_id=:ram_id AND validated  = 0');
$stm->execute([
    ':ram_id' => $_SESSION['ram']->id,
]);
$users = $stm->fetchAll(PDO::FETCH_CLASS, User::class);

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
    <h1>Vous etes connécté a la ram <?= htmlspecialchars($_SESSION['ram']->login) ?></h1>

    <div>
        <h2>Ass mat à valider</h2>
        <table>
            <tr>
                <th>nom</th>
                <th>prénom</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= htmlspecialchars($user->nom) ?></td>
                    <td><?= htmlspecialchars($user->prenom) ?></td>
                    <td><a href="users/validate.php?uid=<?= htmlspecialchars($user->id) ?>">valider</a></td>
                    <td><a href="users/delete.php?uid=<?= htmlspecialchars($user->id) ?>">supprimer</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="users.php">Voir tout les utilisateurs</a>
    </div>

    <div>
        <h2>faire un post</h2>
        <form action="posts/add.php" method="POST">

            <label for="">
                titre <br>
                <input type="text" name="titre"><br>
            </label>

            <label for="">
                texte <br>
                <textarea name="texte" cols="30" rows="10"></textarea><br>
            </label>

            <button type="submit">Ajouter l'article</button>
        </form>
    </div>
</body>
</html>

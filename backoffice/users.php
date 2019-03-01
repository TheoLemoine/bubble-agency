<?php

require_once '../libs/models/Ram.php';
require_once '../libs/models/User.php';
require_once '../libs/get_pdo.php';

session_start();

$pdo = get_pdo();

if(!isset($_SESSION['ram']))
{
    header('Location: connect.php');
    die;
}

// get all users in the RAM

$stm = $pdo->prepare('SELECT * FROM user WHERE ram_id=:ram_id');
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
    <table>
        <tr>
            <th>nom</th>
            <th>prénom</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= htmlspecialchars($user->nom) ?></td>
                <td><?= htmlspecialchars($user->prenom) ?></td>
                <td><a href="users/delete.php?uid=<?= htmlspecialchars($user->id) ?>">supprimer</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

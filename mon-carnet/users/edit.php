<?php

require_once '../../libs/get_pdo.php';
require_once '../../libs/models/User.php';
require_once '../../libs/models/Ram.php';

session_start();
$pdo = get_pdo();

if(!isset($_SESSION['user']))
{
    header('Location: connect.php');
    die;
}

// verify changes
$stm = $pdo->prepare('SELECT * FROM user WHERE id=:id');
$stm->execute([
    ':id' => $_SESSION['user']->id,
]);
$user = $stm->fetchObject(User::class);

if($_SERVER['REQUEST_METHOD'] == 'POST'
    // everything is set
    && isset($_POST['nom'])
    && isset($_POST['prenom'])
    && isset($_POST['mail'])
    && isset($_POST['ram'])
    // something has changed
    && $user->nom != $_POST['nom']
    && $user->prenom != $_POST['prenom']
    && $user->mail != $_POST['mail']
    && $user->ram != $_POST['ram']
    // mail is still valid
    && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)
)
{

    $stm = $pdo->prepare('UPDATE user SET nom=:nom, prenom=:prenom, mail=:mail, ram_id=:ram, validated=0 WHERE id=:id');
    $ok = $stm->execute([
        ':nom' => $_POST['nom'],
        ':prenom' => $_POST['prenom'],
        ':mail' => $_POST['mail'],
        ':ram' => intval($_POST['ram']),
        ':id' => $_SESSION['user']->id,
    ]);

    $stm = $pdo->prepare('SELECT * FROM user WHERE id=:id');
    $stm->execute([
        ':id' => $_SESSION['user']->id,
    ]);
    $_SESSION['user'] = $stm->fetchObject(User::class);
}

$rams = $pdo
        ->query('SELECT * FROM ram')
        ->fetchAll(PDO::FETCH_CLASS, Ram::class);

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
    <a href="../index.php">Home</a>

    <?php if (isset($ok) && $ok) : ?>
        <div>Vos modifications on bien été prises en compte</div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="">
            nom <br>
            <input type="text" name="nom" value="<?= htmlspecialchars($_SESSION['user']->nom) ?>"><br>
        </label>

        <label for="">
            prenom <br>
            <input type="text" name="prenom" value="<?= htmlspecialchars($_SESSION['user']->prenom) ?>"><br>
        </label>

        <label for="">
            mail <br>
            <input type="email" name="mail" value="<?= htmlspecialchars($_SESSION['user']->mail) ?>"><br>
        </label>

        <label for="">
            ram <br>
            <select name="ram">
                <?php foreach ($rams as $ram) : ?>
                    <option value="<?= $ram->id ?>" <?= $ram->id === $_SESSION['user']->ram_id ? 'selected' : '' ?>><?= htmlspecialchars($ram->login) ?></option>
                <?php endforeach; ?>
            </select><br>
        </label>

        <button type="submit">Modifier vous information</button>
    </form>
</body>
</html>

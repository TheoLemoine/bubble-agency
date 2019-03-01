<?php

require_once '../../libs/models/Ram.php';
require_once '../../libs/models/User.php';
require_once '../../libs/get_pdo.php';

session_start();

$pdo = get_pdo();

// validate connection
if($_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_POST['mail'])
    && isset($_POST['mdp']))
{
    $stm = $pdo->prepare('SELECT * FROM user WHERE mail=:mail');
    $stm->execute([
        ':mail' => $_POST['mail'],
    ]);
    $user = $stm->fetchObject(User::class);

    if(!$user)
    {
        $error_msg = 'Ce compte n\'existe pas';
        unset($_SESSION['user']);
    }
    else if (!password_verify($_POST['mdp'], $user->mdp))
    {
        $error_msg = 'Le mot de passe est incorrect';
        unset($_SESSION['user']);
    }
    else
    {
        $_SESSION['user'] = $user;
        header('Location: ../index.php');
    }
}

// select all rams in a ram variable
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
    <title>Connection</title>
</head>
<body>
    <div>
        <h1>Connection</h1>
        <?php if(isset($error_msg)) : ?>
            <div><?= $error_msg ?></div>
        <?php endif; ?>
        <form action="connect.php" method="POST">
            <label for="">
                mail <br>
                <input type="email" name="mail"><br>
            </label>

            <label for="">
                mdp <br>
                <input type="password" name="mdp"><br>
            </label>

            <button type="submit">Se connecter</button>
        </form>
    </div>

    <div>
        <h1>Inscription</h1>
        <form action="validate.php" method="POST">
            <label for="">
                nom <br>
                <input type="text" name="nom"><br>
            </label>

            <label for="">
                prenom <br>
                <input type="text" name="prenom"><br>
            </label>

            <label for="">
                mail <br>
                <input type="email" name="mail"><br>
            </label>

            <label for="">
                mdp <br>
                <input type="password" name="mdp"><br>
            </label>

            <label for="">
                ram <br>
                <select name="ram">
                    <?php foreach ($rams as $ram) : ?>
                        <option value="<?= $ram->id ?>"><?= htmlspecialchars($ram->login) ?></option>
                    <?php endforeach; ?>
                </select><br>
            </label>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>

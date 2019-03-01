<?php

require_once '../libs/models/Ram.php';
require_once '../libs/get_pdo.php';

session_start();

// select all rams in a ram variable

$rams = get_pdo()
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
<div>
    <h1>Connection</h1>
    <form action="index.php" method="POST">
        <label for="">
            ram <br>
            <select name="ram">
                <?php foreach ($rams as $ram) : ?>
                    <option value="<?= $ram->id ?>"><?= htmlspecialchars($ram->login) ?></option>
                <?php endforeach; ?>
            </select><br>
        </label>

        <label for="">
            mdp <br>
            <input type="password" name="mdp"><br>
        </label>

        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>
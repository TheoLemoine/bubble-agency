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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon Carnet d'assmat - Identifiez vous</title>
    <link rel="stylesheet" href="../css/style-backoffice-connect.css">
    <link rel="icon" type="image/png" href="../../../images/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../../../images/favicon/favicon-16x16.png" sizes="16x16" />
  </head>

  <body>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- HEADER  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <header>

        <img src="../images/logo/logo-app.svg">
        <h1>Mon Carnet d'assmat</h1>

    </header>

    <!-- --------------------------------------------------------------- -->
    <!-- --------------------------- MAIN  ----------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <main>

      <div class="content">
        <h2>Connection</h2>
        <form action="index.php" method="POST" class="form">
          <label for="">RAM<select name="ram">
                <?php foreach ($rams as $ram) : ?>
                    <option value="<?= $ram->id ?>"><?= htmlspecialchars($ram->login) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

          <label for="">Mot de passe
            <input type="password" name="mdp"><br>
        </label>

          <button type="submit">Se connecter</button>
        </form>
      </div>

    </main>

  </body>

  </html>

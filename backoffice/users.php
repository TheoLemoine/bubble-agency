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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon Carnet d'Assmat - Espace RAM</title>
    <link rel="stylesheet" href="../css/style-backoffice-users.css">
    <link rel="icon" type="image/png" href="../images/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../images/favicon/favicon-16x16.png" sizes="16x16" />
  </head>

  <body>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- HEADER  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <header>

      <div class="title">
        <img src="../images/logo/logo-app.svg">
        <h1>Mon Carnet d'Assmat</h1>
      </div>

      <h2><?= htmlspecialchars($_SESSION['ram']->login) ?></h2>

    </header>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- MAIN  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <main>

      <nav>
        <a href="index.php">Accueil</a>
        <a href="#" class="active">Liste des assmats</a>
      </nav>

        <h3>Liste des assmats</h3>
        <div class="cadre">
          <div class="line">
            <strong>Nom / Prénom</strong>
          </div>
          <?php foreach ($users as $user) : ?>
          <div class="line">
            <div>
              <span>
                <?= htmlspecialchars($user->nom) ?>
                </span>
              <span>
                <?= htmlspecialchars($user->prenom) ?>
                </span>
            </div>
            <div>
              <a href="users/delete.php?uid=<?= htmlspecialchars($user->id) ?>" class="supprimer">Supprimer</a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

    </main>

  </body>

  </html>

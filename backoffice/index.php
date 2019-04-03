<?php

require_once '../libs/models/Ram.php';
require_once '../libs/models/User.php';
require_once '../libs/models/Post.php';
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

// get all posts in ram
$stm = $pdo->prepare('SELECT * FROM post WHERE ram_id=:ram_id');
$stm->execute([
    ':ram_id' => $_SESSION['ram']->id,
]);
$posts = $stm->fetchAll(PDO::FETCH_CLASS, Post::class);

?>

<!doctype html>
  <html lang="fr">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon Carnet d'Assmat - Espace RAM</title>
    <link rel="stylesheet" href="../css/style-backoffice-accueil.css">
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

      <h2>RAM de Bry-sur-Marne</h2>

    </header>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- MAIN  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <main>

      <nav>
        <a href="#" class="active">Accueil</a>
        <a href="users.php">Liste des assmats</a>
      </nav>

      <p class="first-line">Vous êtes connecté(e) au
        <?= htmlspecialchars($_SESSION['ram']->login) ?>
      </p>

      <div class="fat">
        <div class="assmat">
          <h3>Assmat à valider</h3>
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
              <div class="valider-refuser">
                <a href="users/validate.php?uid=<?= htmlspecialchars($user->id) ?>"><img src="../images/imgbody/valider.svg"></a>
                <a href="users/delete.php?uid=<?= htmlspecialchars($user->id) ?>"><img src="../images/imgbody/refuser.svg"></a>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <a href="users.php" class="voirtout">Voir toutes les assmats</a>
        </div>

        <div class="ecrire-article">
          <h3>Ecrire un article</h3>
          <form action="posts/add.php" method="POST" class="cadre">
            <label for="">Titre<br/><br/>
                <input type="text" name="titre">
            </label>
            <label for="">Texte<br/><br/>
                <textarea name="texte" cols="30" rows="10"></textarea><br>
            </label>

            <button type="submit">Ajouter l'article</button>
          </form>
        </div>
      </div>

    </main>

    <h2>Tous les articles</h2>

    <div class="box-article">
      <?php foreach ($posts as $post) : ?>
      <div class="article-publie">
        <h3>
          <?= htmlspecialchars($post->titre) ?>
        </h3>
        <p>
          <?= htmlspecialchars($post->texte) ?>
        </p>
        <a href="posts/erase.php?uid=<?= htmlspecialchars($post->id) ?>" class="supprimer">Supprimer</a>
      </div>
       
      <?php endforeach; ?>
    </div>




  </body>

  </html>

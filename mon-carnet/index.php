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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon Carnet d'assmat - Le blog</title>
    <link rel="stylesheet" href="../css/style-blog.css">
    <link rel="icon" type="image/png" href="../images/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../images/favicon/favicon-16x16.png" sizes="16x16" />
  </head>

  <body>

    <!-- --------------------------------------------------------------- -->
    <!-- ------------------------- HEADER  ----------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <header>

      <a href="../index.html" class="logo">
        <img src="../images/logo/logo-app.svg" alt="logo">
      </a>

      <h1 class="h1">
        <img src="../images/losanges/losange-violet-creux.svg" alt="" class="losange-titre">
        <span>Bienvenue  <?= htmlspecialchars($_SESSION['user']->prenom) ?></span>
      </h1>

      <div class="parametres">
        <a href="../index.html" class="site">Retour au site</a>
        <a href="users/edit.php">Modifier vos informations</a>
      </div>

    </header>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- MAIN  ------------------------------ -->
    <!-- --------------------------------------------------------------- -->

    <main>

      <p>Vous etes connecté(e) en tant que
        <?= htmlspecialchars($_SESSION['user']->prenom . ' ' . $_SESSION['user']->nom) ?>
      </p>

      <div class="box-article">
          <?php if($_SESSION['user']->validated == 1) : ?>
          <?php foreach ($posts as $post) : ?>
          <a href="news.php?id=<?= $post->id ?>">
            <div class="article">
              <h2>
                <?= htmlspecialchars($post->titre) ?>
              </h2>
              <p>
                <?= substr(htmlspecialchars($post->texte), 0, 200) . '...'?>
              </p>
            </div>
          </a>
          <?php endforeach; ?>
          <?php else : ?> Votre Compte n'a pas encore été validé
          <?php endif; ?>
      </div>
      
    </main>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- FOOTER  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <footer>
      <img src="../images/vagues/vague-rose-haut.svg" class="vague" alt="">

      <h3><span>Téléchargez l'application</span><img src="../images/losanges/losange-violet-creux.svg" class="losange-titre-footer" alt=""></h3>
      <div class="store">
        <a href="#"><img src="../images/store/google-play.png" alt="lien google play"></a>
        <a href="#"><img src="../images/store/play-store.png" alt="lien play store"></a>
      </div>
      <a href="https://www.facebook.com/BubbleAgency77/" target="_blank"><img src="../images/icones-footer/facebook.svg" class="facebook" alt="lien facebook"></a>

      <p class="end">Conçu, créé, designé et dévelopé par Bubble Agency, tout droits réservés.</p>
    </footer>

  </body>

  </html>

<?php

require_once '../libs/get_pdo.php';
require_once '../libs/models/User.php';
require_once '../libs/models/Post.php';

session_start();

if(!isset($_SESSION['user']))
{
    header('Location: connect.php');
    die;
}

$pdo = get_pdo();

// get all users in the RAM
$stm = $pdo->prepare('SELECT * FROM post WHERE id=:id LIMIT 1');
$stm->execute([
    ':id' => $_GET['id'],
]);
$post = $stm->fetchObject(Post::class);

if($_SESSION['user']->ram_id !== $post->ram_id)
{
    header('Location: index.php');
    die;
}

?>

<!doctype html>
  <html lang="fr">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Venez découvrir les actualités de votre RAM et découvrez notre application Mon Carnet d'Assmat">
    <meta name="keywords" content="carnet, carnets, carnet d'assmat, mon carnet d'assmat, mon carnet, assmat, assmats, asmat, asmats, assitantes, assistante, asistante, asistantes, maternel, maternelle, maternels, maternelles, maternnelle, maternnel, assitant maternel, assistante maternelle, assistants maternels, assistantes maternelles, RAM, relais, relais d'assistantes maternelles, relais d'assistante maternelle, blog, lié au RAM, article, articles, nouveauté, nouveautée, nouveautés, nouveautées, enfant, enfants, enfance, nourrice, nounou, nourice, gestion, gestionner, organisation, organiser, quotidien, quotidienne, app, application, mobile, application mobile">
    <title>Mon Carnet d'Assmat - Nouveautés du RAM</title>
    <link rel="stylesheet" href="../css/style-article.css">
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
        <span>Nouveautés du RAM</span>
      </h1>

      <div class="parametres">
        <a href="../index.html" class="site">Retour au site</a>
<!--        <a href="users/edit.php">Modifier vos informations</a>-->
      </div>

    </header>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- MAIN  ------------------------------ -->
    <!-- --------------------------------------------------------------- -->

    <main>

      <a href="index.php" class="retour-accueil">Retour</a>
      
      <div class="box">
        <h2>
          <?= htmlspecialchars($post->titre) ?>
        </h2>
        <p class="content">
          <?= htmlspecialchars($post->texte) ?>
        </p>
      </div>

    </main>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- FOOTER  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <footer>
      <img src="../images/vagues/vague-rose-haut.svg" class="vague" alt="">

    <h3><span class="footer-h3">Téléchargez l'application</span><img src="../images/losanges/losange-violet-creux.svg" class="losange-titre-footer" alt=""></h3>
    <div class="store">
      <a href="#"><img src="../images/store/google-play.png" alt="lien google play" class="footer-store"></a>
      <a href="https://www.facebook.com/BubbleAgency77/" target="_blank"><img src="../images/icones-footer/facebook.svg" class="facebook" alt="lien facebook"></a>
      <a href="#"><img src="../images/store/play-store.png" alt="lien play store" class="footer-store"></a>
    </div>

      <p class="end">Conçu, créé, designé et dévelopé par Bubble Agency, tout droits réservés.</p>
    </footer>

  </body>

  </html>

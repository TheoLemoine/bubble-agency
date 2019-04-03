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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Venez découvrir les actualités de votre RAM et découvrez notre application Mon Carnet d'Assmat">
    <meta name="keywords" content="carnet, carnets, carnet d'assmat, mon carnet d'assmat, mon carnet, assmat, assmats, asmat, asmats, assitantes, assistante, asistante, asistantes, maternel, maternelle, maternels, maternelles, maternnelle, maternnel, assitant maternel, assistante maternelle, assistants maternels, assistantes maternelles, RAM, relais, relais d'assistantes maternelles, relais d'assistante maternelle, blog, lié au RAM, article, articles, nouveauté, nouveautée, nouveautés, nouveautées, enfant, enfants, enfance, nourrice, nounou, nourice, gestion, gestionner, organisation, organiser, quotidien, quotidienne, app, application, mobile, application mobile">
    <title>Mon Carnet d'Assmat - Identifiez-vous</title>
    <link rel="stylesheet" href="../../css/style-inscriptionconnexion.css">
    <link rel="icon" type="image/png" href="../../images/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../../images/favicon/favicon-16x16.png" sizes="16x16" />
  </head>

  <body>

    <!-- --------------------------------------------------------------- -->
    <!-- ------------------------- HEADER  ----------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <header>

      <a href="../../index.html" class="logo">
        <img src="../../images/logo/logo-app.svg" alt="logo">
      </a>

      <h1 class="h1">
        <img src="../../images/losanges/losange-violet-creux.svg" alt="" class="losange-titre">
        <span>Accéder au blog</span>
      </h1>

      <div class="retour">
        <a href="../../index.html" class="site">Retour au site</a>
      </div>

    </header>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- MAIN  ------------------------------ -->
    <!-- --------------------------------------------------------------- -->

    <main>

      <div class="form-zone-big">
        <div class="form-zone-small">
          <p class="membre1">Déjà membre ?</p>
          <img src="../../images/imgbody/fleche-blog.svg" class="fleche1" alt="">
          <p class="quefaire">Identifiez-vous</p>
          <?php if(isset($error_msg)) : ?>
          <div>
            <?= $error_msg ?>
          </div>
          <?php endif; ?>
          <form action="connect.php" method="POST">
                <input type="email" name="mail" placeholder="Adresse mail">
                <input type="password" name="mdp" placeholder="Mot de passe">
            <button type="submit">Se connecter</button>
          </form>
        </div>
        <div class="form-zone-small">
          <p class="membre2">Pas encore membre ?</p>
          <img src="../../images/imgbody/fleche-blog.svg" class="fleche2" alt="">
          <p class="quefaire">Inscrivez-vous gratuitement</p>
          <form action="validate.php" method="POST">
                <input type="text" name="nom" placeholder="Nom">
                <input type="text" name="prenom" placeholder="Prénom">
                <input type="email" name="mail" placeholder="Adresse mail">
                <input type="password" name="mdp" placeholder="Mot de passe">
                <select name="ram">
                    <?php foreach ($rams as $ram) : ?>
                        <option value="<?= $ram->id ?>"><?= htmlspecialchars($ram->login) ?></option>
                    <?php endforeach; ?>
                </select>
            <button type="submit">S'inscrire</button>
          </form>
        </div>
      </div>

    </main>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- FOOTER  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <footer>
      <img src="../../images/vagues/vague-orange-haut.svg" class="vague" alt="">

    <h2><span class="footer-h3">Téléchargez l'application</span><img src="../../images/losanges/losange-violet-creux.svg" class="losange-titre-footer" alt=""></h2>
    <div class="store">
      <a href="#"><img src="../../images/store/google-play.png" alt="lien google play" class="footer-store"></a>
      <a href="https://www.facebook.com/BubbleAgency77/" target="_blank"><img src="../../images/icones-footer/facebook.svg" class="facebook" alt="lien facebook"></a>
      <a href="#"><img src="../../images/store/play-store.png" alt="lien play store" class="footer-store"></a>
    </div>

      <p class="end">Conçu, créé, designé et dévelopé par Bubble Agency, tout droits réservés.</p>
    </footer>

  </body>

  </html>
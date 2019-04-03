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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Venez découvrir les actualités de votre RAM et découvrez notre application Mon Carnet d'Assmat">
    <meta name="keywords" content="carnet, carnets, carnet d'assmat, mon carnet d'assmat, mon carnet, assmat, assmats, asmat, asmats, assitantes, assistante, asistante, asistantes, maternel, maternelle, maternels, maternelles, maternnelle, maternnel, assitant maternel, assistante maternelle, assistants maternels, assistantes maternelles, RAM, relais, relais d'assistantes maternelles, relais d'assistante maternelle, blog, lié au RAM, article, articles, nouveauté, nouveautée, nouveautés, nouveautées, enfant, enfants, enfance, nourrice, nounou, nourice, gestion, gestionner, organisation, organiser, quotidien, quotidienne, app, application, mobile, application mobile">
    <title>Mon Carnet d'Assmat - Le blog</title>
    <link rel="stylesheet" href="../../css/style-edit-infos.css">
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
        <span>Modifiez vos informations</span>
      </h1>

      <div class="parametres">
        <a href="../../index.html" class="site">Retour au site</a>
      </div>

    </header>

    <!-- --------------------------------------------------------------- -->
    <!-- ------------------------- HEADER  ----------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <main>

      <a href="../index.php" class="retour-accueil">Retour</a>

      <div class="box">
        <?php if (isset($ok) && $ok) : ?>
        <div>Vos modifications on bien été prises en compte</div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" name="nom" value="<?= htmlspecialchars($_SESSION['user']->nom) ?>">
            <input type="text" name="prenom" value="<?= htmlspecialchars($_SESSION['user']->prenom) ?>">
            <input type="email" name="mail" value="<?= htmlspecialchars($_SESSION['user']->mail) ?>">
            <select name="ram">
                <?php foreach ($rams as $ram) : ?>
                    <option value="<?= $ram->id ?>" <?= $ram->id === $_SESSION['user']->ram_id ? 'selected' : '' ?>><?= htmlspecialchars($ram->login) ?></option>
                <?php endforeach; ?>
            </select>

          <button type="submit">Modifier mes infos</button>
        </form>
      </div>

    </main>

    <!-- --------------------------------------------------------------- -->
    <!-- -------------------------- FOOTER  ---------------------------- -->
    <!-- --------------------------------------------------------------- -->

    <footer>
      <img src="../../images/vagues/vague-orange-haut.svg" class="vague" alt="">

     <h3><span class="footer-h3">Téléchargez l'application</span><img src="../../images/losanges/losange-violet-creux.svg" class="losange-titre-footer" alt=""></h3>
    <div class="store">
      <a href="#"><img src="../../images/store/google-play.png" alt="lien google play" class="footer-store"></a>
      <a href="https://www.facebook.com/BubbleAgency77/" target="_blank"><img src="../../images/icones-footer/facebook.svg" class="facebook" alt="lien facebook"></a>
      <a href="#"><img src="../../images/store/play-store.png" alt="lien play store" class="footer-store"></a>
    </div>

      <p class="end">Conçu, créé, designé et dévelopé par Bubble Agency, tout droits réservés.</p>
    </footer>

  </body>

  </html>


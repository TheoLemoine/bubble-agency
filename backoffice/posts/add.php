<?php


require_once '../../libs/get_pdo.php';

session_start();

if(!isset($_SESSION['ram']))
{
    header('Location: ../connect.php');
    die;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_POST['titre'])
    && isset($_POST['texte']))
{
    $pdo = get_pdo();

    $stm = $pdo->prepare('INSERT INTO post (titre, texte, ram_id) VALUES(:titre, :texte, :ram_id)');

    $ok = $stm->execute([
        ':titre' => $_POST['titre'],
        ':texte' => $_POST['texte'],
        ':ram_id' => intval($_SESSION['ram']->id),
    ]);
}

header('Location: ../index.php');

?>
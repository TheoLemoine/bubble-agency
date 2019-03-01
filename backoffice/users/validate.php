<?php


require_once '../../libs/get_pdo.php';
require_once '../../libs/models/Ram.php';

session_start();

if(isset($_GET['uid']) && isset($_SESSION['ram']))
{
    $pdo = get_pdo();

    $stm = $pdo->prepare('UPDATE user SET validated=1 WHERE id=:id');

    $stm->execute([
        ':id' => intval($_GET['uid']),
    ]);
}

header('Location: ../index.php');

?>
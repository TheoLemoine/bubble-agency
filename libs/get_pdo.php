<?php

function get_pdo(): PDO
{
    $conf = [
        'dbname' => 'basti1101767',
        'host' => '185.98.131.91',
        'charset' => 'utf8',
        'user' => 'basti1101767',
        'pass' => 'kmxdv3cz5z',
    ];

    return new PDO('mysql:dbname=' . $conf['dbname']. ';host=' . $conf['host']. ';charset=' . $conf['charset'], $conf['user'], $conf['pass']);
}
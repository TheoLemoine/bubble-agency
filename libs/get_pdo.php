<?php

function get_pdo(): PDO
{
    $conf = [
        'dbname' => 'bubble-agency',
        'host' => 'localhost',
        'charset' => 'utf8',
        'user' => 'root',
        'pass' => '',
    ];

    return new PDO('mysql:dbname=' . $conf['dbname']. ';host=' . $conf['host']. ';charset=' . $conf['charset'], $conf['user'], $conf['pass']);
}
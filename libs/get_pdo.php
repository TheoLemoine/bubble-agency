<?php

function get_pdo(): PDO
{
    return new PDO('mysql:dbname=bubble-agency;host=127.0.0.1;charset=utf8', 'root', '');
}
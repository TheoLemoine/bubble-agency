<?php

require_once 'libs/get_pdo.php';

get_pdo()
    ->query(
        file_get_contents('database.sql')
    );
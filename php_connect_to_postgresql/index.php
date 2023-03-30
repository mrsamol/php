<?php

include_once('connect.php');

$pdo = connectToPostgreSQL('127.0.0.1', '5432', 'mylearn', 'postgres', '123');

$data = getDataFromPostgreSQL($pdo, 'tbl_users');

var_dump($data);
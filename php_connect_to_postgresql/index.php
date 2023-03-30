<?php

include_once('connect.php');

$pdo = connectToPostgreSQL('127.0.0.1', '5432', 'mylearn', 'postgres', '123');

$data = getDataFromPostgreSQL($pdo, 'tbl_users');
$result = [];
if (!empty($data)) {
    foreach($data as $value){
        $result[] = $value;
    }
    echo $result[0]['email'];
} else {
    echo "No data found";
}
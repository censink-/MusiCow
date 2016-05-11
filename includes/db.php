<?php
$db_user = "root";
$db_pass = "1337";
$db_host = "localhost";
$db_name = "PRJ02_2";

$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$db) {
    $d['code'] = 503;
}
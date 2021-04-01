<?php
$user = 'std_983_exam';
$pass = '12345678';
try {
    $dbh = new PDO('mysql:host=std-mysql;dbname=std_983_exam', $user, $pass);

    $dbh->query("SET NAMES utf-8");
} catch (Exception $e) {
    echo ($e->getMessage());
}
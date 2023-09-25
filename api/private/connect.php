<?php
session_start(); //abrindo uma sessao
header('Content-Type: application/json; charset=utf-8');

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$database = 'aulaphp';

$mysqli = mysqli_connect($host, $user, $pass, $database);
if(mysqli_connect_error()){
    echo 'Error a conectar ao banco' . mysqli_connect_error();
}

?>
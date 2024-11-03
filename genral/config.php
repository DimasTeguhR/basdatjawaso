<?php
$host = "localhost";
$user = "root";
$password= "";
$dbName = "jawaso";

$connectSQL = mysqli_connect($host , $user , $password , $dbName);

session_start(); 
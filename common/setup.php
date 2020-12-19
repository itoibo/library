<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqlServer = "localhost";
$database = "library";
$mysqlUser = "libraryadmin";
$mysqlPassword = "libraryadmin";

$connexionObject = new PDO("mysql:host=$mysqlServer;dbname=$database", $mysqlUser, $mysqlPassword);
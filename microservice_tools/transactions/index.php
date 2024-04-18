<?php
require '../vendor/autoload.php';
require_once 'connection.php';

$connection = Connection::getInstance();


$pdoConnection = $connection->getConnection('pdo');
// Create a persistent connection

dd($pdoConnection);
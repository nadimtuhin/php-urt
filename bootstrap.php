<?php
require ('vendor/autoload.php');
require ('functions.php');

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$host = getenv('host');
$port = getenv('port');
$connectionTimeout = getenv('connection_timeout');
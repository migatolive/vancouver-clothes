<?php
require '..\..\vendor\autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$name = $_ENV['DB_NAME'];

$conn_string = "host=$host dbname=$name user=$user password=$pass options='--search_path=vancouver'";
$conn = pg_connect($conn_string);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
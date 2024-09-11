<?php
require 'utils/connection.php';

header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No hay una sesión activa.']);
    exit();
}

$query = "SELECT * FROM products";
$result = pg_query($conn, $query);

$products = array();
while ($row = pg_fetch_assoc($result)) {
    $products[] = $row;
}

echo json_encode(['products' => $products, 'user_id' => $_SESSION['user_id']]);

pg_close($conn);
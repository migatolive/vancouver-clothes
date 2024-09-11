<?php
require 'utils/connection.php';

header('Content-Type: application/json');

$name = $_POST['name'];
$price = $_POST['price'];

$query = "INSERT INTO products (name, price) VALUES ($1, $2)";
$result = pg_query_params($conn, $query, array($name, $price));

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Producto agregado']);
} else {
    echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
}

pg_close($conn);
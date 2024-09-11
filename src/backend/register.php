<?php
require 'utils/connection.php';

header('Content-Type: application/json');

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$query = "INSERT INTO users (email, password) VALUES ($1, $2)";
$result = pg_query_params($conn, $query, array($email, $password));

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
}

pg_close($conn);
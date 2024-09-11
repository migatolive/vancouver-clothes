<?php
require 'utils/connection.php';

header('Content-Type: application/json');

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT id, password FROM users WHERE email = $1";
$result = pg_query_params($conn, $query, array($email));

if ($result) {
    if (pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
}

pg_close($conn);
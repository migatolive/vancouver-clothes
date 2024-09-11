<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'utils/connection.php';

header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? null;
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener elementos del carrito
    $query = "SELECT p.id as product_id, p.name, oi.quantity, p.price, (oi.quantity * p.price) as total
              FROM order_items oi
              JOIN products p ON oi.product_id = p.id
              JOIN orders o ON oi.order_id = o.id
              WHERE o.user_id = $1";
    $result = pg_query_params($conn, $query, array($user_id));

    $cartItems = array();
    while ($row = pg_fetch_assoc($result)) {
        $cartItems[] = $row;
    }

    echo json_encode(['success' => true, 'cartItems' => $cartItems]);
    pg_close($conn);
    exit();
}

if ($action == 'add') {
    // Verificar si el usuario tiene un pedido activo
    $query = "SELECT id FROM orders WHERE user_id = $1";
    $result = pg_query_params($conn, $query, array($user_id));

    if (pg_num_rows($result) > 0) {
        $order = pg_fetch_assoc($result);
        $order_id = $order['id'];
    } else {
        // Crear un nuevo pedido si no existe
        $query = "INSERT INTO orders (user_id, created_at) VALUES ($1, CURRENT_TIMESTAMP) RETURNING id";
        $result = pg_query_params($conn, $query, array($user_id));
        $order = pg_fetch_assoc($result);
        $order_id = $order['id'];
    }

    // Verificar si el producto ya está en el carrito
    $query = "SELECT quantity FROM order_items WHERE order_id = $1 AND product_id = $2";
    $result = pg_query_params($conn, $query, array($order_id, $product_id));

    if (pg_num_rows($result) > 0) {
        // Incrementar la cantidad del producto existente
        $query = "UPDATE order_items SET quantity = quantity + $1 WHERE order_id = $2 AND product_id = $3";
        $result = pg_query_params($conn, $query, array($quantity, $order_id, $product_id));
    } else {
        // Agregar el producto a la tabla order_items
        $query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ($1, $2, $3)";
        $result = pg_query_params($conn, $query, array($order_id, $product_id, $quantity));
    }

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito']);
    } else {
        echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
    }
}

if ($action == 'remove') {
    if ($product_id === null) {
        echo json_encode(['success' => false, 'message' => 'ID del producto no proporcionado']);
        exit();
    }

    // Verificar si el producto_id es un número válido
    if (!is_numeric($product_id)) {
        echo json_encode(['success' => false, 'message' => 'ID del producto no es válido']);
        exit();
    }

    // Eliminar el producto de la tabla order_items
    $query = "DELETE FROM order_items WHERE order_id = (SELECT id FROM orders WHERE user_id = $1) AND product_id = $2";
    $result = pg_query_params($conn, $query, array($user_id, $product_id));

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito']);
    } else {
        echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
    }
}

pg_close($conn);
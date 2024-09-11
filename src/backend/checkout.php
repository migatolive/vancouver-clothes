<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require 'utils/connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../backend/utils/');
$dotenv->load();

$stripeSecretKey = $_ENV['STRIPE_SECRET'];
$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? null;

$stripe = new \Stripe\StripeClient($stripeSecretKey);

header('Content-Type: application/json');

if ($action == 'createPaymentIntent') {
    $amount = $_POST['amount'] ?? 0;
    $token = $_POST['token'] ?? null;

    if ($amount <= 0) {
        echo json_encode(['success' => false, 'message' => 'El monto debe ser mayor a 0']);
        exit();
    }

    try {
        $paymentIntent = $stripe->paymentIntents->create([
            'payment_method_types' => ['card'],
            'amount' => $amount,
            'currency' => 'ars',
            'payment_method_data' => [
                'type' => 'card',
                'card' => [
                    'token' => $token
                ]
            ],
        ]);

        echo json_encode(['success' => true, 'paymentIntent' => $paymentIntent]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $error = $e->getError();
        $message = $error->message;
        $code = $error->code;
        echo json_encode(['success' => false, 'message' => $message, 'code' => $code]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}

if ($action == 'saveShippingAddress') {
    $data = json_decode($_POST['address'], true);
    $line1 = $data['address']['line1'];
    $line2 = $data['address']['line2'];
    $city = $data['address']['city'];
    $state = $data['address']['state'];
    $zip_code = $data['address']['postal_code'];

    $query = "INSERT INTO shipments (user_id, line1, line2, city, state, zip_code) VALUES ($1, $2, $3, $4, $5, $6)";
    $result = pg_query_params($conn, $query, array($user_id, $line1, $line2, $city, $state, $zip_code));
}

if ($action == 'confirmPaymentIntent') {
    try {
            $stripe->paymentIntents->confirm(
            $_POST['paymentIntentId'],
            [
                'payment_method' => $_POST['paymentMethodId'],
                'return_url' => 'http://localhost:8000/cart.html',
            ]
        );
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $error = $e->getError();
        $message = $error->message;
        $code = $error->code;
        echo json_encode(['success' => false, 'message' => $message, 'code' => $code]);
    }
}

if ($action == 'dropOrderTable') {
    // Obtener la id de la orden del usuario
    $query = "SELECT id FROM orders WHERE user_id = $1";
    $result = pg_query_params($conn, $query, array($user_id));
    $order = pg_fetch_assoc($result);
    $order_id = $order['id'];

    // Eliminar los elementos de la orden
    $query = "DELETE FROM order_items WHERE order_id = $1";
    $result = pg_query_params($conn, $query, array($order_id));

    if ($result) {
        // Eliminar la orden
        $query = "DELETE FROM orders WHERE id = $1";
        $result = pg_query_params($conn, $query, array($order_id));

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Orden dropeada con éxito']);
        } else {
            echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
    }

    pg_close($conn);
    exit();
}


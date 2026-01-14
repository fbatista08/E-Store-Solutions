<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
        exit();
    }

    $customerInfo = $data['customerInfo'] ?? [];
    $cartItems = $data['cartItems'] ?? [];
    $paymentDetails = $data['paymentDetails'] ?? [];
    $totalAmount = $data['totalAmount'] ?? 0;
    $orderNumber = $data['orderNumber'] ?? '';

    if (empty($customerInfo) || empty($cartItems) || empty($totalAmount) || empty($orderNumber)) {
        echo json_encode(['success' => false, 'message' => 'Missing required order data']);
        exit();
    }

    try {
        $pdo = getDatabase();
        $pdo->beginTransaction();

        // Inserir pedido na tabela 'orders'
        $stmt = $pdo->prepare("
            INSERT INTO orders (customer_name, customer_email, customer_phone, total_amount, status, order_number)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $customerInfo['name'] ?? 'N/A',
            $customerInfo['email'] ?? 'N/A',
            $customerInfo['phone'] ?? 'N/A',
            $totalAmount, // Armazenar em reais
            'pending',
            $orderNumber
        ]);
        $order_id = $pdo->lastInsertId();

        // Inserir itens do pedido na tabela 'order_items'
        $stmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price, product_name, product_image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        foreach ($cartItems as $item) {
            $stmt->execute([
                $order_id,
                $item['id'] ?? 'N/A',
                $item['quantity'] ?? 0,
                $item['price'] ?? 0, // Armazenar em reais
                $item['name'] ?? 'N/A',
                $item['image'] ?? 'N/A'
            ]);
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Order placed successfully', 'order_id' => $order_id]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

<?php
session_start();
require_once __DIR__ . "/admin_panel/config.php";

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["user_id"];
    $address = $_POST["address"] ?? "";
    $number = $_POST["number"] ?? "";
    $complement = $_POST["complement"] ?? "";
    $neighborhood = $_POST["neighborhood"] ?? "";
    $city = $_POST["city"] ?? "";
    $state = $_POST["state"] ?? "";
    $zip_code = $_POST["zip_code"] ?? "";

    try {
        $pdo = getDatabase();
        $stmt = $pdo->prepare("UPDATE users SET address = :address, number = :number, complement = :complement, neighborhood = :neighborhood, city = :city, state = :state, zip_code = :zip_code WHERE id = :id");
        $stmt->execute([
            ':address' => $address,
            ':number' => $number,
            ':complement' => $complement,
            ':neighborhood' => $neighborhood,
            ':city' => $city,
            ':state' => $state,
            ':zip_code' => $zip_code,
            ':id' => $userId
        ]);

        echo json_encode(['success' => true, 'message' => 'Endereço atualizado com sucesso']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar endereço: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>

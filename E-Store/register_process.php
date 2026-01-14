<?php
session_start();
require_once __DIR__ . "/admin_panel/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $cpf = $_POST["cpf"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";
    $address = $_POST["address"] ?? "";
    $number = $_POST["number"] ?? "";
    $complement = $_POST["complement"] ?? "";
    $neighborhood = $_POST["neighborhood"] ?? "";
    $city = $_POST["city"] ?? "";
    $state = $_POST["state"] ?? "";
    $zip_code = $_POST["zip_code"] ?? "";

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: cadastro.php?error=" . urlencode("Todos os campos são obrigatórios."));
        exit;
    }

    if ($password !== $confirm_password) {
        header("Location: cadastro.php?error=" . urlencode("As senhas não coincidem."));
        exit;
    }

    $pdo = getDatabase();

    // Verificar se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        header("Location: cadastro.php?error=" . urlencode("Este e-mail já está cadastrado."));
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user'; // Definir como usuário comum por padrão

    // Inserir novo usuário no banco de dados
    $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, cpf, password, address, number, complement, neighborhood, city, state, zip_code, role) VALUES (:name, :email, :phone, :cpf, :password, :address, :number, :complement, :neighborhood, :city, :state, :zip_code, :role)");
    if ($stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":phone" => $phone,
        ":cpf" => $cpf,
        ":password" => $hashed_password,
        ":address" => $address,
        ":number" => $number,
        ":complement" => $complement,
        ":neighborhood" => $neighborhood,
        ":city" => $city,
        ":state" => $state,
        ":zip_code" => $zip_code,
        ":role" => $role
    ])) {
        // Redirecionar para a página de login com mensagem de sucesso
        header("Location: login.php?success=" . urlencode("Cadastro realizado com sucesso! Faça login."));
        exit;
    } else {
        header("Location: cadastro.php?error=" . urlencode("Erro ao cadastrar usuário."));
        exit;
    }
}

header("Location: cadastro.php");
exit;
?>

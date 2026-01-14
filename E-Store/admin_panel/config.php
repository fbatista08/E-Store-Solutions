<?php
// Configurações do banco de dados MySQL/MariaDB
define('DB_HOST', 'localhost');
define('DB_NAME', 'database');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configurações de sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função para conectar ao banco de dados
function getDatabase() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erro na conexão com o banco de dados: ' . $e->getMessage());
    }
}

// Função para verificar se o usuário está logado
function getUserByEmail($email) {
    $pdo = getDatabase();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

function isAdmin() {
    return isset($_SESSION["user_role"]) && $_SESSION["user_role"] === 'admin';
}

// Função para redirecionar se não estiver logado
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit;
    }
}

// Função para formatar preço
function formatPrice($price) {
    return 'R$ ' . number_format($price, 2, ',', '.');
}

// Função para converter preço para centavos
function priceTocents($price) {
    return (int) ($price * 100);
}
?>

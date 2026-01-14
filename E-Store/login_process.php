<?php
session_start();

require_once __DIR__ . "/admin_panel/config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["e-mail"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = getUserByEmail($email);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_email"] = $user["email"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_role"] = $user["role"];

        if ($user["role"] === "admin") {
            header("Location: admin_panel/index.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $message = "Email ou senha inválidos.";
        header("Location: login.php?error=" . urlencode($message));
        exit;
    }
}

header("Location: login.php");
exit;
?>

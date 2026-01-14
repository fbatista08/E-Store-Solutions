<?php
session_start();
require_once __DIR__ . "/admin_panel/config.php";

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["user_id"];
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $cpf = $_POST["cpf"] ?? "";
    $address = $_POST["address"] ?? "";
    $number = $_POST["number"] ?? "";
    $complement = $_POST["complement"] ?? "";
    $neighborhood = $_POST["neighborhood"] ?? "";
    $city = $_POST["city"] ?? "";
    $state = $_POST["state"] ?? "";
    $zip_code = $_POST["zip_code"] ?? "";

    $pdo = getDatabase();
    
    // Processar upload de foto de perfil
    $profilePhotoPath = null;
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/profile_photos/';
        
        // Criar diretório se não existir
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Validar tipo de arquivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = $_FILES['profile_photo']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            // Gerar nome único para o arquivo
            $fileExtension = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
            $fileName = 'user_' . $userId . '_' . time() . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;
            
            // Mover arquivo para o diretório de uploads
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetPath)) {
                $profilePhotoPath = 'uploads/profile_photos/' . $fileName;
            }
        }
    }
    
    // Atualizar dados do usuário
    if ($profilePhotoPath) {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, phone = :phone, cpf = :cpf, address = :address, number = :number, complement = :complement, neighborhood = :neighborhood, city = :city, state = :state, zip_code = :zip_code, profile_photo = :profile_photo WHERE id = :id");
        $stmt->execute(params:[
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':cpf' => $cpf,
            ':address' => $address,
            ':number' => $number,
            ':complement' => $complement,
            ':neighborhood' => $neighborhood,
            ':city' => $city,
            ':state' => $state,
            ':zip_code' => $zip_code,
            ':profile_photo' => $profilePhotoPath,
            ':id' => $userId
        ]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, phone = :phone, cpf = :cpf, address = :address, number = :number, complement = :complement, neighborhood = :neighborhood, city = :city, state = :state, zip_code = :zip_code WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':cpf' => $cpf,
            ':address' => $address,
            ':number' => $number,
            ':complement' => $complement,
            ':neighborhood' => $neighborhood,
            ':city' => $city,
            ':state' => $state,
            ':zip_code' => $zip_code,
            ':id' => $userId
        ]);
    }

    // Atualizar as informações da sessão
    $_SESSION["user_name"] = $name;
    $_SESSION["user_email"] = $email;

    header("Location: perfil.php");
    exit;
}
?>

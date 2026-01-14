<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div id="login-container">
        <!-- ===== Logo da Loja ===== -->
        <div class="img-container">
            <div><img src="images/logo.png" alt="logo e-store solution"></div>
        </div>
        
        <h1>Login</h1>
            <form class="loginform" action="login_process.php" method="post">
                <!-- ===== Usuario ===== -->
                <label for="e-mail">E-mail:</label>
                <input type="email" name="e-mail" id="email" placeholder="Digite seu email" required>

                <!-- ===== Senha ===== -->
                <label for="password">Senha:</label>
                <input type="password" name="password" id="senha" placeholder="Digite sua senha" required>

                <!-- ===== Botões ===== -->
                <button type="submit">Entrar</button>
            </form>
                        <p id="mensagem-login" class="mensagem">
                <?php
                if (isset($_GET['error'])) {
                    echo htmlspecialchars($_GET['error']);
                }
                ?>
            </p>

            <!-- ===== link para cadastro ===== -->
            <p class="cadastro-link">Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
            
        <script src="script.js"></script>
        </div>
</body>
</html>
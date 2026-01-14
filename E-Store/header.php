<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/admin_panel/config.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" a href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>E-Store Solutions</title>
</head>

<body>
    <header class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="logo">
                <img src="images/logo.png" alt="E-Store Solutions" class="logo-img">
            </a>

            <!-- Botão Hamburguer -->
            <button class="hamburger" id="hamburger">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Menu de navegação -->
            <nav class="nav-menu" id="nav-menu">
                <ul class="nav-list">
                    <li><a href="index.php" class="nav-link">Início</a></li>
                    <li><a href="moveis.php" class="nav-link">Móveis</a></li>
                    <li><a href="eletrodomesticos.php" class="nav-link">Eletrodomésticos</a></li>
                    <li><a href="computadores.php" class="nav-link">Computadores</a></li>
                    <li><a href="perifericos.php" class="nav-link">Periféricos</a></li>
                </ul>
            </nav>


            <div class="nav-icons">
                <!-- Nova Estrutura da Barra de Pesquisa -->
                <div class="search-container-toggle">
                    <button class="search-toggle-button" id="search-toggle">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="search-box-toggled" id="search-box-toggled">
                        <input type="text" placeholder="Pesquisar produtos...">
                        <button class="search-button-inner">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <?php if (isLoggedIn()): ?>
                    <div class="user-menu-container">
                        <a href="#" class="icon-link user-icon">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
                        </a>
                        <div class="user-dropdown-menu">
                            <a href="perfil.php">Minha Conta</a>
                            <?php if (isAdmin()): ?>
                                <a href="admin_panel/index.php">Dashboard</a>
                            <?php endif; ?>
                            <a href="logout.php">Sair</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="icon-link">
                        <i class="fas fa-user"></i> Login
                    </a>
                <?php endif; ?>

                <div class="cart-container">
                    <a href="checkout.php" class="icon-link cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                    <div class="cart-dropdown">
                        <div class="cart-header">
                            <h3>Carrinho de Compras</h3>
                        </div>
                        <div class="cart-items">
                            <div class="empty-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <p>Seu carrinho está vazio</p>
                            </div>
                        </div>
                        <div class="cart-footer">
                            <div class="cart-total">
                                Total: R$ 0,00
                            </div>
                            <button class="checkout-btn">Finalizar Compra</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>


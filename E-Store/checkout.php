<?php
session_start();
require_once __DIR__ . "/admin_panel/config.php";

$user = null;
if (isLoggedIn()) {
    $userId = $_SESSION["user_id"];
    $pdo = getDatabase();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([":id" => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

$userName = $user["name"] ?? "";
$userEmail = $user["email"] ?? "";
$userPhone = $user["phone"] ?? "";
$userCpf = $user["cpf"] ?? "";
$userAddress = $user["address"] ?? "";
$userNumber = $user["number"] ?? "";
$userComplement = $user["complement"] ?? "";
$userNeighborhood = $user["neighborhood"] ?? "";
$userCity = $user["city"] ?? "";
$userState = $user["state"] ?? "";
$userZipCode = $user["zip_code"] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Checkout - E-Store Solutions</title>
</head>
<body>
    <header class="navbar">
        <div class="navbar-container">
            <a href="index.html" class="logo">
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
                                <strong>Total: R$ 0,00</strong>
                            </div>
                            <button class="checkout-btn">Finalizar Compra</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <div class="container">
            <a href="index.html"><i class="fas fa-home"></i> Início</a>
            <span class="separator">></span>
            <span class="current">Checkout</span>
        </div>
    </div>

    <main class="checkout-main">
        <div class="container">
            <div class="checkout-header">
                <h1><i class="fas fa-shopping-cart"></i> Finalizar Compra</h1>
                <div class="checkout-steps">
                    <div class="step active">
                        <span class="step-number">1</span>
                        <span class="step-text">Carrinho</span>
                    </div>
                    <div class="step active">
                        <span class="step-number">2</span>
                        <span class="step-text">Dados</span>
                    </div>
                    <div class="step active">
                        <span class="step-number">3</span>
                        <span class="step-text">Pagamento</span>
                    </div>
                </div>
            </div>

            <div class="checkout-content">
                <!-- Resumo do Pedido -->
                <div class="checkout-section">
                    <div class="section-header">
                        <h2><i class="fas fa-list"></i> Resumo do Pedido</h2>
                    </div>
                    <div class="order-summary">
                        <div class="order-items" id="checkout-items">
                            <!-- Os itens do carrinho serão inseridos aqui via JavaScript -->
                        </div>
                        <div class="order-totals">
                            <div class="total-line">
                                <span>Subtotal:</span>
                                <span id="subtotal">R$ 0,00</span>
                            </div>
                            <div class="total-line">
                                <span>Frete:</span>
                                <span id="shipping-cost">R$ 0,00</span>
                            </div>
                            <div class="total-line discount-line" id="discount-line" style="display: none;">
                                <span>Desconto:</span>
                                <span id="discount-amount">R$ 0,00</span>
                            </div>
                            <div class="total-line final-total">
                                <span>Total:</span>
                                <span id="final-total">R$ 0,00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados de Entrega -->
                <div class="checkout-section">
                    <div class="section-header">
                        <h2><i class="fas fa-truck"></i> Dados de Entrega</h2>
                    </div>
                    <form class="checkout-form" id="delivery-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullName">Nome Completo *</label>
                                <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($userName); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail *</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Telefone *</label>
                                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($userPhone); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF *</label>
                                <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($userCpf); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="cep">CEP *</label>
                                <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($userZipCode); ?>" required>
                                <button type="button" class="cep-search-btn" id="cep-search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label for="address">Endereço *</label>
                                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userAddress); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="number">Número *</label>
                                <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($userNumber); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="complement">Complemento</label>
                                <input type="text" id="complement" name="complement" value="<?php echo htmlspecialchars($userComplement); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="neighborhood">Bairro *</label>
                                <input type="text" id="neighborhood" name="neighborhood" value="<?php echo htmlspecialchars($userNeighborhood); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="city">Cidade *</label>
                                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($userCity); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="state">Estado *</label>
                                <select id="state" name="state" required>
                                    <option value="">Selecione o estado</option>
                                    <option value="AC" <?php echo ($userState == 'AC') ? 'selected' : ''; ?>>Acre</option>
                                    <option value="AL" <?php echo ($userState == 'AL') ? 'selected' : ''; ?>>Alagoas</option>
                                    <option value="AP" <?php echo ($userState == 'AP') ? 'selected' : ''; ?>>Amapá</option>
                                    <option value="AM" <?php echo ($userState == 'AM') ? 'selected' : ''; ?>>Amazonas</option>
                                    <option value="BA" <?php echo ($userState == 'BA') ? 'selected' : ''; ?>>Bahia</option>
                                    <option value="CE" <?php echo ($userState == 'CE') ? 'selected' : ''; ?>>Ceará</option>
                                    <option value="DF" <?php echo ($userState == 'DF') ? 'selected' : ''; ?>>Distrito Federal</option>
                                    <option value="ES" <?php echo ($userState == 'ES') ? 'selected' : ''; ?>>Espírito Santo</option>
                                    <option value="GO" <?php echo ($userState == 'GO') ? 'selected' : ''; ?>>Goiás</option>
                                    <option value="MA" <?php echo ($userState == 'MA') ? 'selected' : ''; ?>>Maranhão</option>
                                    <option value="MT" <?php echo ($userState == 'MT') ? 'selected' : ''; ?>>Mato Grosso</option>
                                    <option value="MS" <?php echo ($userState == 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                                    <option value="MG" <?php echo ($userState == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option>
                                    <option value="PA" <?php echo ($userState == 'PA') ? 'selected' : ''; ?>>Pará</option>
                                    <option value="PB" <?php echo ($userState == 'PB') ? 'selected' : ''; ?>>Paraíba</option>
                                    <option value="PR" <?php echo ($userState == 'PR') ? 'selected' : ''; ?>>Paraná</option>
                                    <option value="PE" <?php echo ($userState == 'PE') ? 'selected' : ''; ?>>Pernambuco</option>
                                    <option value="PI" <?php echo ($userState == 'PI') ? 'selected' : ''; ?>>Piauí</option>
                                    <option value="RJ" <?php echo ($userState == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
                                    <option value="RN" <?php echo ($userState == 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                                    <option value="RS" <?php echo ($userState == 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                                    <option value="RO" <?php echo ($userState == 'RO') ? 'selected' : ''; ?>>Rondônia</option>
                                    <option value="RR" <?php echo ($userState == 'RR') ? 'selected' : ''; ?>>Roraima</option>
                                    <option value="SC" <?php echo ($userState == 'SC') ? 'selected' : ''; ?>>Santa Catarina</option>
                                    <option value="SP" <?php echo ($userState == 'SP') ? 'selected' : ''; ?>>São Paulo</option>
                                    <option value="SE" <?php echo ($userState == 'SE') ? 'selected' : ''; ?>>Sergipe</option>
                                    <option value="TO" <?php echo ($userState == 'TO') ? 'selected' : ''; ?>>Tocantins</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Forma de Pagamento -->
                <div class="checkout-section">
                    <div class="section-header">
                        <h2><i class="fas fa-credit-card"></i> Forma de Pagamento</h2>
                    </div>
                    <div class="payment-methods">
                        <div class="payment-option">
                            <input type="radio" id="credit-card" name="payment-method" value="credit-card" checked>
                            <label for="credit-card" class="payment-label">
                                <i class="fas fa-credit-card"></i>
                                <span>Cartão de Crédito</span>
                                <div class="card-brands">
                                    <i class="fab fa-cc-visa"></i>
                                    <i class="fab fa-cc-mastercard"></i>
                                    <i class="fab fa-cc-amex"></i>
                                </div>
                            </label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="debit-card" name="payment-method" value="debit-card">
                            <label for="debit-card" class="payment-label">
                                <i class="fas fa-credit-card"></i>
                                <span>Cartão de Débito</span>
                            </label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="pix" name="payment-method" value="pix">
                            <label for="pix" class="payment-label">
                                <i class="fas fa-qrcode"></i>
                                <span>PIX</span>
                                <span class="discount-badge">5% de desconto</span>
                            </label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="boleto" name="payment-method" value="boleto">
                            <label for="boleto" class="payment-label">
                                <i class="fas fa-barcode"></i>
                                <span>Boleto Bancário</span>
                                <span class="discount-badge">3% de desconto</span>
                            </label>
                        </div>
                    </div>

                    <!-- Formulário do Cartão de Crédito -->
                    <div class="payment-form" id="credit-card-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="card-number">Número do Cartão *</label>
                                <input type="text" id="card-number" name="card-number" placeholder="0000 0000 0000 0000" maxlength="19">
                                <div class="card-brand-icon" id="card-brand"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="card-name">Nome no Cartão *</label>
                                <input type="text" id="card-name" name="card-name" placeholder="Como está impresso no cartão">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="card-expiry">Validade *</label>
                                <input type="text" id="card-expiry" name="card-expiry" placeholder="MM/AA" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="card-cvv">CVV *</label>
                                <input type="text" id="card-cvv" name="card-cvv" placeholder="000" maxlength="4">
                                <div class="cvv-help">
                                    <i class="fas fa-question-circle"></i>
                                    <div class="tooltip">3 dígitos no verso do cartão</div>
                                </div>
                            </div>
                        </div>
                        <div class="installments-section">
                            <label for="installments">Parcelamento *</label>
                            <select id="installments" name="installments">
                                <option value="1">1x sem juros</option>
                            </select>
                        </div>
                    </div>

                    <!-- Formulário do Cartão de Débito -->
                    <div class="payment-form" id="debit-card-form" style="display: none;">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="debit-number">Número do Cartão *</label>
                                <input type="text" id="debit-number" name="debit-number" placeholder="0000 0000 0000 0000" maxlength="19">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="debit-name">Nome no Cartão *</label>
                                <input type="text" id="debit-name" name="debit-name" placeholder="Como está impresso no cartão">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="debit-expiry">Validade *</label>
                                <input type="text" id="debit-expiry" name="debit-expiry" placeholder="MM/AA" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="debit-cvv">CVV *</label>
                                <input type="text" id="debit-cvv" name="debit-cvv" placeholder="000" maxlength="4">
                            </div>
                        </div>
                    </div>

                    <!-- Informações PIX -->
                    <div class="payment-form" id="pix-form" style="display: none;">
                        <div class="pix-info">
                            <div class="pix-icon">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div class="pix-text">
                                <h3>Pagamento via PIX</h3>
                                <p>Após confirmar o pedido, você receberá o código PIX para pagamento.</p>
                                <p><strong>Desconto de 5% aplicado automaticamente!</strong></p>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Boleto -->
                    <div class="payment-form" id="boleto-form" style="display: none;">
                        <div class="boleto-info">
                            <div class="boleto-icon">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <div class="boleto-text">
                                <h3>Boleto Bancário</h3>
                                <p>O boleto será gerado após a confirmação do pedido.</p>
                                <p>Prazo de vencimento: 3 dias úteis</p>
                                <p><strong>Desconto de 3% aplicado automaticamente!</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cupom de Desconto -->
                <div class="checkout-section">
                    <div class="section-header">
                        <h2><i class="fas fa-tag"></i> Cupom de Desconto</h2>
                    </div>
                    <div class="coupon-section">
                        <div class="coupon-input">
                            <input type="text" id="coupon-code" placeholder="Digite seu cupom de desconto">
                            <button type="button" id="apply-coupon" class="coupon-btn">
                                <i class="fas fa-check"></i> Aplicar
                            </button>
                        </div>
                        <div class="coupon-message" id="coupon-message"></div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="checkout-actions">
                    <a href="index.html" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Continuar Comprando
                    </a>
                    <button type="button" id="finish-order" class="btn-primary">
                        <i class="fas fa-check"></i> Finalizar Pedido
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Confirmação -->
    <div class="modal" id="confirmation-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-check-circle"></i> Pedido Confirmado!</h2>
            </div>
            <div class="modal-body">
                <p>Seu pedido foi realizado com sucesso!</p>
                <div class="order-number">
                    <strong>Número do Pedido: <span id="order-number"></span></strong>
                </div>
                <p>Você receberá um e-mail com os detalhes do pedido e instruções de pagamento.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary" onclick="closeModal()">
                    <i class="fas fa-home"></i> Voltar ao Início
                </button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="checkout.js"></script>
</body>
</html>

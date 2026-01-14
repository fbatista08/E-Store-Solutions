<?php
session_start();
require_once __DIR__ . "/admin_panel/config.php";

// Redirecionar se o usuário não estiver logado
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
// Obter informações do usuário logado do banco de dados
$userId = $_SESSION["user_id"] ?? null;
$user = null;
if ($userId) {
    $pdo = getDatabase();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ===================================================================================
// CORREÇÃO E DEBUG: Garante que o perfil carregado é o da sessão e adiciona depuração
// ===================================================================================
if (!$user) {
    // Se o usuário não for encontrado (ID inválido na sessão), destrói a sessão e redireciona
    session_destroy();
    header("Location: login.php?error=" . urlencode("Sessão de usuário inválida. Por favor, faça login novamente."));
    exit;
}

// DEBUG: Exibir o ID da sessão e o nome do usuário carregado para diagnóstico
echo "<!-- DEBUG INFO: Session ID: " . htmlspecialchars($userId) . " | Loaded User: " . htmlspecialchars($user["name"]) . " | Email: " . htmlspecialchars($user["email"]) . " -->";
// ===================================================================================

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
// Por enquanto, usaremos apenas os dados da sessão.

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="perfil.css">
    <link rel="stylesheet" href="media.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

                <a href="perfil.php" class="icon-link">
                    <i class="fas fa-user"></i>
                </a>

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

        <!--============================-->
        <!-- ===== Aréa De Perfil ===== -->
        <!--============================-->
    <main class="perfil-container">
        <section class="user-info">
            <div class="perfil-header">
                <?php
                // Exibir foto de perfil do banco de dados ou foto padrão
                $profilePhoto = $user["profile_photo"] ?? "";
                $photoSrc = !empty($profilePhoto) && file_exists($profilePhoto) ? $profilePhoto : "images/foto de perfil vazio.jpg";
                ?>
                <img src="<?php echo htmlspecialchars($photoSrc); ?>" alt="Foto de perfil" class="foto-perfil" id="photo-profile">
                <div class="user-details">
                    <h1 id="nomeDisplay"><?php echo htmlspecialchars($userName); ?></h1>
                    <p id="emailDisplay"><?php echo htmlspecialchars($userEmail); ?></p>
                    <button class="editar-perfil" id="btnEditarPerfil">
                        <i class="material-icons">edit</i>
                        Editar Perfil
                    </button>
                    
                </div>
                
            </div>
        </section>

        <section class="order-history">
            <h2>Últimos Pedidos</h2>
            <div class="order-list">
                <div class="order-items">
                    <div class="order-details">
                        <h4>Pedido #123456</h4>
                        <p>Data: 20/08/2025</p>
                        <span class="order-status delivered">
                            Entregue
                        </span>
                    </div>
                </div>
                <div class="order-items">
                    <div class="order-details">
                        <h4>Pedido #789012</h4>
                        <p>Data: 25/08/2025</p>
                        <span class="order-status processing">Em Processamento</span>
                    </div>
                </div>
            </div>
            <a href="checkout.php" class="view-all-link">Ver todos</a>

        </section>

        <section class="shipping-addresses">
            <h2>Endereços de Entrega</h2>
            <div class="address-item">
                <?php
                // Exibir o endereço do banco de dados
                $enderecoLinha1 = "";
                $enderecoLinha2 = "";
                
                if (!empty($userAddress) || !empty($userNumber)) {
                    $enderecoLinha1 = $userAddress;
                    if (!empty($userNumber)) {
                        $enderecoLinha1 .= ", " . $userNumber;
                    }
                    if (!empty($userComplement)) {
                        $enderecoLinha1 .= " - " . $userComplement;
                    }
                    
                    $enderecoLinha2Parts = [];
                    if (!empty($userNeighborhood)) {
                        $enderecoLinha2Parts[] = $userNeighborhood;
                    }
                    if (!empty($userCity)) {
                        $enderecoLinha2Parts[] = $userCity;
                    }
                    if (!empty($userState)) {
                        $enderecoLinha2Parts[] = $userState;
                    }
                    if (!empty($userZipCode)) {
                        $enderecoLinha2Parts[] = $userZipCode;
                    }
                    $enderecoLinha2 = implode(" - ", $enderecoLinha2Parts);
                } else {
                    $enderecoLinha1 = "Rua Exemplo, 123/ complemento";
                    $enderecoLinha2 = "Centro - Cidade/ Estado - CEP";
                }
                ?>
                <p id="endereco-display1"><?php echo htmlspecialchars($enderecoLinha1); ?></p>
                <p id="endereco-display2"><?php echo htmlspecialchars($enderecoLinha2); ?></p>
            </div>  
            <button class="add" id="btn-endereco">
                <i class="material-icons">add_location</i>
                Adicionar Novo Endereço
            </button>
        </section>

        <section class="payment-item">
            <h2 id="payment-items">Formas de Pagamento</h2>

            <div class="payment-item">
                <p id="payment-method1">MasterCard ****</p>
                <p id="payment-method2">Validade: 12/28</p>
            </div>
            <button class="add" id="btn-form-payment">
                <i class="material-icons">add_circle_outline</i>
                Adicionar Nova Forma de Pagamento
            </button>
        </section>

        <section class="accont-settings">
            <h2>Configurações de Conta</h2>

            <ul>
                <li>
                    <a href="#" onclick="abrirModal()">
                        <i class="material-icons">email</i>
                        Alterar Email
                    </a>
                </li>
                <li>
                    <a href="logout.php" id="logout-btn">
                        <i class="material-icons">exit_to_app</i>
                        Sair da Conta
                    </a>
                </li>
            </ul>
        </section>

        <!-- ===== Formulário oculto da forma de pagamento ===== -->
        <!-- Modal sobrepondo a tela -->
    <div id="form-modal" class="modal-overlay" style="Display:none;">
    <div class="modal-content">
      <h3>Atualize sua forma de pagamento:</h3>
      <form id="payment-form">
          <label for="method">Método de pagamento:</label>
        <input type="text" id="method" name="method" placeholder="Exemplo: Cartão de Crédito" required />

        <label for="details">Detalhes:</label>
        <input type="text" id="details" name="details" placeholder="Exemplo: **** 1234" required />

        <label for="expiry">Data de validade:</label>
        <input type="month" id="expiry" name="expiry" required />

        <div class="modal-buttons">
          <button type="submit" class="modal-btn">Atualizar</button>
          <button type="button" id="close-modal-btn" class="modal-btn">Cancelar</button>
        </div>
       </form>

    </div>

    </div>

    <!-- Modal para formulário de endereço -->
    <div id="formularioEndereco" class="modal-overlay" style="display:none;">
      <div class="modal-content">
          <h3>Alterar Endereço</h3>
          <form id="formEndereco">
              <label for="ruaEnd">Rua:</label>
              <input type="text" id="ruaEnd" name="rua" placeholder="Digite sua rua" required>

              <label for="numeroEnd">Número:</label>
              <input type="text" id="numeroEnd" name="numero" placeholder="Ex: 123" required>

              <label for="complementoEnd">Complemento:</label>
              <input type="text" id="complementoEnd" name="complemento" placeholder="Apto, Bloco...">

              <label for="cidadeEnd">Cidade:</label>
              <input type="text" id="cidadeEnd" name="cidade" placeholder="Digite sua Cidade" required>

              <label for="estadoEnd">Estado:</label>
              <select name="estado" id="estadoEnd" required>
                  <option value="">Selecione</option>
                  <option value="AC">Acre</option>
                  <option value="AL">Alagoas</option>
                  <option value="AP">Amapá</option>
                  <option value="AM">Amazonas</option>
                  <option value="BA">Bahia</option>
                  <option value="CE">Ceará</option>
                  <option value="DF">Distrito Federal</option>
                  <option value="ES">Espírito Santo</option>
                  <option value="GO">Goiás</option>
                  <option value="MA">Maranhão</option>
                  <option value="MT">Mato Grosso</n>
                  <option value="MS">Mato Grosso do Sul</option>
                  <option value="MG">Minas Gerais</option>
                  <option value="PA">Pará</option>
                  <option value="PB">Paraíba</option>
                  <option value="PR">Paraná</option>
                  <option value="PE">Pernambuco</option>
                  <option value="PI">Piauí</option>
                  <option value="RJ">Rio de Janeiro</option>
                  <option value="RN">Rio Grande do Norte</option>
                  <option value="RS">Rio Grande do Sul</option>
                  <option value="RO">Rondônia</option>
                  <option value="RR">Roraima</option>
                  <option value="SC">Santa Catarina</option>
                  <option value="SP">São Paulo</option>
                  <option value="SE">Sergipe</option>
                  <option value="TO">Tocantins</option>
              </select>

              <label for="cepEnd">CEP:</label>
              <input type="text" id="cepEnd" name="cep" placeholder="00000-000" maxlength="9" required>

              <div class="modal-buttons">
                  <button type="submit" class="modal-btn">Salvar</button>
                  <button type="button" class="modal-btn" id="btn-fechar-end">Cancelar</button>
              </div>
          </form>
      </div>
    </div>

  
    </main>

    <!--==========================-->
    <!-- Modal para editar perfil -->
    <!--==========================-->
    <div id="modalEditarPerfil" class="modal-overlay" style="display:none;">
        <div class="modal-content perfil-modal-content">
            <span class="close-modal" id="fecharEditarPerfil">&times;</span>
            <h3>Editar Perfil</h3>
            <form id="formEditarPerfil" method="POST" action="update_profile.php" enctype="multipart/form-data">
                <label for="inputFotoPerfil">Foto de Perfil</label>
                <input type="file" id="inputFotoPerfil" name="profile_photo" accept="image/*" />
                <img id="previewFotoPerfil" alt="Preview da Foto" class="preview-foto-perfil" />
        
                <label for="inputNomePerfil">Nome</label>
                <input type="text" id="inputNomePerfil" name="name" placeholder="Seu nome" value="<?php echo htmlspecialchars($userName); ?>" required />
        
                <label for="inputEmailPerfil">Email</label>
                <input type="email" id="inputEmailPerfil" name="email" placeholder="seu@email.com" value="<?php echo htmlspecialchars($userEmail); ?>" required />

                <label for="inputTelefonePerfil">Telefone</label>
                <input type="text" id="inputTelefonePerfil" name="phone" placeholder="(XX) XXXXX-XXXX" value="<?php echo htmlspecialchars($userPhone); ?>" />

                <label for="inputCpfPerfil">CPF</label>
                <input type="text" id="inputCpfPerfil" name="cpf" placeholder="XXX.XXX.XXX-XX" value="<?php echo htmlspecialchars($userCpf); ?>" />

                <label for="inputEnderecoPerfil">Endereço</label>
                <input type="text" id="inputEnderecoPerfil" name="address" placeholder="Rua, Avenida, etc." value="<?php echo htmlspecialchars($userAddress); ?>" />

                <label for="inputNumeroPerfil">Número</label>
                <input type="text" id="inputNumeroPerfil" name="number" placeholder="Número" value="<?php echo htmlspecialchars($userNumber); ?>" />

                <label for="inputComplementoPerfil">Complemento</label>
                <input type="text" id="inputComplementoPerfil" name="complement" placeholder="Apartamento, Bloco, etc." value="<?php echo htmlspecialchars($userComplement); ?>" />

                <label for="inputBairroPerfil">Bairro</label>
                <input type="text" id="inputBairroPerfil" name="neighborhood" placeholder="Bairro" value="<?php echo htmlspecialchars($userNeighborhood); ?>" />

                <label for="inputCidadePerfil">Cidade</label>
                <input type="text" id="inputCidadePerfil" name="city" placeholder="Cidade" value="<?php echo htmlspecialchars($userCity); ?>" />

                <label for="inputEstadoPerfil">Estado</label>
                <select id="inputEstadoPerfil" name="state">
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

                <label for="inputCepPerfil">CEP</label>
                <input type="text" id="inputCepPerfil" name="zip_code" placeholder="00000-000" value="<?php echo htmlspecialchars($userZipCode); ?>" />
        
                <button type="submit" class="btn-salvar-perfil">Salvar</button>
            </form>
        </div>
    </div>


    <!--====================================-->
    <!--============= Rodapé ===============-->
    <!--====================================-->
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h3>Sobre Nós</h3>
                <p>Somos uma loja online dedicada a oferecer produtos de alta qualidade com o melhor atendimento. Nossa missão é trazer inovação e satisfação para nossos clientes.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h3>Links Úteis</h3>
                <ul>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Termos de Uso</a></li>
                    <li><a href="#">Trocas e Devoluções</a></li>
                    <li><a href="#">Perguntas Frequentes</a></li>
                    <li><a href="#">Entre em Contato</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h3>Contato</h3>
                <p><i class="fas fa-map-marker-alt"></i> R. Força Pública, 89 - Centro, Guarulhos - SP, 07012-030</p>
                <p><i class="fas fa-envelope"></i> contato@estore.com.br</p>
                <p><i class="fas fa-phone"></i> (XX) XXXX-XXXX</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 E-Store Solutions. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="./js/carrinho.js"></script>
    <script src="./js/forma-de-pagamento.js"></script>
    <script src="./js/menu-hamburguer.js"></script>
    <script src="./js/sair-da-conta.js"></script>
    <script src="./js/endereco.js"></script>
    <script src="./js/modal-editar-perfil.js"></script>
    <script src="./js/header.js"></script>
    
    <script>
        // Garantir que o modal funcione mesmo se houver problemas com outros scripts
        document.addEventListener("DOMContentLoaded", function() {
            const btnEditarPerfil = document.getElementById("btnEditarPerfil");
            const modalEditarPerfil = document.getElementById("modalEditarPerfil");
            const fecharEditarPerfil = document.getElementById("fecharEditarPerfil");

            if (btnEditarPerfil && modalEditarPerfil && fecharEditarPerfil) {
                // Abrir modal
                btnEditarPerfil.addEventListener("click", function(e) {
                    e.preventDefault();
                    modalEditarPerfil.style.display = "flex";
                });

                // Fechar modal
                fecharEditarPerfil.addEventListener("click", function() {
                    modalEditarPerfil.style.display = "none";
                });
            }
        });
    </script>
</body>
</html>

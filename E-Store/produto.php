<?php include 'header.php'; ?>
<link rel="stylesheet" href="produto.css">

<div class="breadcrumb">
    <a href="index.php">Voltar</a>
    <span id="breadcrumb-category"></span>
    <span id="breadcrumb-product"></span>
</div>

<main class="product-page">
    <div class="product-container">
        <!-- Galeria de Imagens -->
        <div class="product-gallery">
            <div class="main-image-container">
                <img id="main-product-image" src="" alt="Produto">
                <span class="product-badge-detail">Usado</span>
            </div>
            <div class="thumbnail-gallery" id="thumbnail-gallery">
                <!-- Thumbnails serão inseridas dinamicamente -->
            </div>
        </div>

        <!-- Informações do Produto -->
        <div class="product-details">
            <div class="product-header">
                <span class="badge-destaque" id="badge-destaque">MAIS VENDIDO</span>
                <h1 class="product-title" id="product-title"></h1>
                <div class="product-rating">
                    <span class="rating-number" id="rating-number">4.9</span>
                    <div class="stars" id="product-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="reviews-count" id="reviews-count">(50)</span>
                </div>
                <p class="product-condition">
                    <span id="product-condition">Novo</span> | <span id="product-sold">+500 vendidos</span>
                </p>
            </div>

            <div class="product-pricing">
                <div class="price-section">
                    <div class="current-price" id="current-price">R$ 0,00</div>
                    <div class="price-details">
                        <span class="installment" id="installment-info">21x R$ 147,57 sem juros</span>
                        <span class="payment-method">com cartão Mercado Pago</span>
                    </div>
                    <a href="#" class="payment-link">Ver os meios de pagamento</a>
                </div>
            </div>

            <!-- Variações do Produto (se houver) -->
            <div class="product-variations" id="product-variations">
                <!-- Variações serão inseridas dinamicamente -->
            </div>

            <!-- Quantidade -->
            <div class="quantity-section">
                <label>Quantidade:</label>
                <div class="quantity-selector">
                    <button class="qty-btn" id="qty-minus">-</button>
                    <input type="number" id="quantity" value="1" min="1" max="50">
                    <button class="qty-btn" id="qty-plus">+</button>
                </div>
                <span class="stock-info" id="stock-info">(+50 disponíveis)</span>
            </div>

            <!-- Botões de Ação -->
            <div class="action-buttons">
                <button class="btn-primary" id="btn-buy-now">Comprar agora</button>
                <button class="btn-secondary" id="btn-add-cart">Adicionar ao carrinho</button>
            </div>

            <!-- Informações de Entrega -->
            <div class="delivery-info">
                <div class="delivery-badge">
                    <span class="badge-free-shipping">FRETE GRÁTIS ACIMA DE R$ 19</span>
                </div>
                <div class="delivery-details">
                    <p class="delivery-title">Receba grátis amanhã</p>
                    <p class="delivery-time">Comprando dentro das próximas <strong id="time-remaining">13 h 10 min</strong></p>
                    <a href="#" class="delivery-link">Mais detalhes e formas de entrega</a>
                </div>

            <!-- Estoque -->
            <div class="stock-section">
                <p class="stock-title">Estoque disponível</p>
                <p class="stock-warehouse">Armazenado e enviado por <strong>E-Store</strong></p>
            </div>
        </div>
    </div>

    <!-- Descrição do Produto -->
    <div class="product-description-section">
        <h2>O que você precisa saber sobre este produto</h2>
        <div class="description-content" id="product-description">
            <!-- Descrição será inserida dinamicamente -->
        </div>
    </div>
</main>

<footer>
    <div class="footer-container">
        <div class="footer-section about">
            <h3>Sobre Nós</h3>
            <p>Somos uma loja online dedicada a oferecer produtos de alta qualidade com o melhor atendimento. Nossa
                missão é trazer inovação e satisfação para nossos clientes.</p>
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

<script src="script.js"></script>
<script src="produto.js"></script>

</body>
</html>

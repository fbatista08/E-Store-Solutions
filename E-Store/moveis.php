<?php include 'header.php'; ?>
    <link rel="stylesheet" a href="moveis.css">

  <!-- Page Header -->
  <section class="header">
    <h1>Móveis para seu Lar e Escritório</h1>
    <p>Conforto, qualidade e design em cada peça</p>
</section>

<!-- Products Section -->
<section class="products">
    <div class="products-header">
        <h2>Nossos Móveis</h2>
        <select>
            <option>Ordenar por</option>
            <option>Preço: Menor para Maior</option>
            <option>Preço: Maior para Menor</option>
            <option>Mais Recentes</option>
            <option>Mais Populares</option>
        </select>
    </div>

    <div class="grid">
        <!-- Produto 1 -->
        <div class="product-card fade-up">
            <div class="product-img">
                <img src="images/cadeira.png" alt="Cadeira de Escritório">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Cadeira Ergonômica de Escritório</h3>
                <p>Cadeira de escritório com o tamanho ajustável.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 399,99</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="7" data-name="Cadeira Ergonômica de Escritório" data-price="399.99" data-image="images/cadeira.png">Adicionar ao Carrinho</button>                
                </div>
            </div>
        </div>

        <!-- Produto 2 -->
        <div class="product-card fade-up delay-1">
            <div class="product-img">
                <img src="images/mesa.png" alt="Mesa Escrivaninha Para Escritório Reforçada">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Mesa Escrivaninha Para Escritório Reforçada</h3>
                <p>Fabricado em MDP 15mm, tampos com cantos arredondados.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 500,00</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="8" data-name="Mesa Escrivaninha Para Escritório Reforçada" data-price="500.00" data-image="images/mesa.png">Adicionar ao Carrinho</button>                
                </div>
            </div>
        </div>

        <!-- Produto 3 -->
        <div class="product-card fade-up delay-2">
            <div class="product-img">
                <img src="images/armario1.png" alt="Armário">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Armário de Aço com 02 Portas de Abrir e Fechadura</h3>
                <p>Armário de Aço com 02 (duas) portas de abrir e tres prateleiras mais a base.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 550,00</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="9" data-name="Armário de Aço com 02 Portas de Abrir e Fechadura" data-price="550.00" data-image="images/armario1.png">Adicionar ao Carrinho</button>                
                </div>
            </div>
        </div>

        <!-- Produto 4 -->
        <div class="product-card fade-up delay-3">
            <div class="product-img">
                <img src="images/escrivaninha.png" alt="Mesa Escrivaninha">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Mesa Escrivaninha</h3>
                <p>A Mesa Para Escritório Com Borda ABS Com 3 Gavetas 150 X 58 Cm, Com Um Design Reto E Discreto</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 499,90</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="10" data-name="Mesa Escrivaninha para Escritório" data-price="499.90" data-image="images/escrivaninha.png">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>

        <!-- Produto 5 -->
        <div class="product-card fade-up delay-4">
            <div class="product-img">
                <img src="images/armario2.png" alt="ESTANTE DE AÇO MINI">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Estante de Aço Mini</h3>
                <p>Estante de aço mini com 3 prateleiras 45x27cm 45kg coluna bipartida para escritório branca.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 130,00</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="11" data-name="Estante de Aço Mini" data-price="130.00" data-image="images/armario2.png">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>

        <!-- Produto 6 -->
        <div class="product-card fade-up delay-5">
            <div class="product-img">
                <img src="images/cadeira3.png" alt="Cadeira de Escritório ">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Cadeira de Escritório </h3>
                <p>Cadeira de Escritório Giratória com Regulagem de Altura em Tecido Preto e Confortável</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 320,00</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="12" data-name="Cadeira de Escritório" data-price="320.00" data-image="images/cadeira3.png">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    <div class="pagination">
        <a href="moveis.html" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">Próximo</a>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="features-container">
        <div class="features-header">
            <h2>Por que escolher nossos móveis?</h2>
            <p class="features-subtitle">Descubra as vantagens que fazem a diferença na sua escolha</p>
        </div>
        <div class="features-grid">
            <div class="feature-card fade-up">
                <div class="card-background"></div>
                <div class="card-content">
                    <div class="icon-wrapper">
                        <div class="icon-bg"></div>
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3>Qualidade Premium</h3>
                    <p>Materiais duráveis e acabamento impecável em cada peça, garantindo longevidade e beleza.</p>
                </div>
            </div>
            <div class="feature-card fade-up delay-1">
                <div class="card-background"></div>
                <div class="card-content">
                    <div class="icon-wrapper">
                        <div class="icon-bg"></div>
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Entrega Rápida</h3>
                    <p>Entrega em todo o Brasil em até 7 dias úteis, com acompanhamento em tempo real.</p>
                </div>
            </div>
            <div class="feature-card fade-up delay-2">
                <div class="card-background"></div>
                <div class="card-content">
                    <div class="icon-wrapper">
                        <div class="icon-bg"></div>
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Garantia Extendida</h3>
                    <p>Até 3 anos de garantia contra defeitos de fabricação, com suporte técnico especializado.</p>
                </div>
            </div>
        </div>
    </div>
</section>

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

<script src="script.js"></script>
<script src="product-redirect.js"></script>

</body>
</html>
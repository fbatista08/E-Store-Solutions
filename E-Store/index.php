<?php include 'header.php'; ?>

    <!-- Banner Promocional -->
    <section class="banner-section">
        <div class="banner-container">
            <div class="banner-content">
                <div class="banner-text">
                    <h1>Produtos Usados com Qualidade</h1>
                    <p>Encontre móveis, computadores e materiais de escritório seminovos com até 70% de desconto</p>
                    <div class="banner-features">
                        <span class="feature"><i class="fas fa-shipping-fast"></i> Entrega Rápida</span>
                        <span class="feature"><i class="fas fa-shield-alt"></i> Garantia</span>
                        <span class="feature"><i class="fas fa-tags"></i> Melhores Preços</span>
                    </div>
                </div>
                <div class="banner-image">
                    <img src="images/banner.png" alt="Produtos Usados">
                </div>
            </div>
        </div>
    </section>

    <main class="main-content">
        <h2 class="section-title">Nossas Categorias</h2>
        <section class="categories">
            <div class="card">
                <div class="icon-wrapper purple">
                    <i class="fas fa-couch"></i>
                </div>
                <h3>Móveis</h3>
                <p>Sofás, mesas, cadeiras e mais</p>
            </div>

            <div class="card">
                <div class="icon-wrapper blue">
                    <i class="fas fa-chair"></i>
                </div>
                <h3>Eletrodomésticos</h3>
                <p>Eletrodomésticos com desempenho garantido</p>
            </div>

            <div class="card">
                <div class="icon-wrapper green">
                    <i class="fas fa-desktop"></i>
                </div>
                <h3>Computadores</h3>
                <p>Desktops, notebooks e acessórios</p>
            </div>

            <div class="card">
                <div class="icon-wrapper yellow">
                    <i class="fas fa-mouse-pointer"></i>
                </div>
                <h3>Periféricos</h3>
                <p>Teclados, mouses e muito mais</p>
            </div>
            <br>
            <br>
            <br>
        </section>

        <!-- Seção de Produtos Usados -->
        <section class="products-section">
            <h2 class="section-title">Produtos em Destaque</h2>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-image">
                        <img src="images/computador1.png" alt="Computador Dell Optiplex 3000">
                        <span class="product-badge">Usado</span>
                    </div>
                    <div class="product-info">
                        <h3>Computador Dell Optiplex 3000</h3>
                        <p class="product-description">Intel I3 12100, RAM 16gb, SSD 256gb + HD 1TB, Video Radeon 550,
                            Kit Tecldo e Mouse.</p>
                        <div class="product-price">
                            <span class="current-price">R$ 1.499,90</span>
                        </div>
                        <button class="product-btn add-to-cart-btn" data-id="1"
                            data-name="Computador Dell Optiplex 3000" data-price="1499.90"
                            data-image="images/computador1.png">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="images/monitor2.png" alt="Monitor Gamer Samsung 24” FHD">
                        <span class="product-badge">Usado</span>
                    </div>
                    <div class="product-info">
                        <h3>Monitor Gamer Samsung 24” FHD</h3>
                        <p class="product-description">Monitor Samsung 24” FHD, 75Hz, HDMI, VGA, Freesync, Ajuste de
                            Inclinação, Preto, Série T350.</p>
                        <div class="product-price">
                            <span class="current-price">R$ 630,00</span>
                        </div>
                        <button class="product-btn add-to-cart-btn" data-id="2" data-name="Monitor Samsung 24 FHD"
                            data-price="630.00" data-image="images/monitor2.png">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="images/computador3.png" alt="Computador Home Completo HD701">
                        <span class="product-badge">Usado</span>
                    </div>
                    <div class="product-info">
                        <h3>Computador Home Completo HD701</h3>
                        <p class="product-description">Computador Home Completo Pichau HD701, Intel Core i5, 8GB DDR3,
                            SSD 120GB + Monitor.</p>
                        <div class="product-price">
                            <span class="current-price">R$ 1.499,90</span>
                        </div>
                        <button class="product-btn add-to-cart-btn" data-id="3"
                            data-name="Computador Home Completo HD701" data-price="1499.90"
                            data-image="images/computador3.png">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="images/kit1.png" alt="Kit de Teclado e Mouse para Escritório C3Tech">
                        <span class="product-badge">Usado</span>
                    </div>
                    <div class="product-info">
                        <h3>Kit de Teclado e Mouse para Escritório C3Tech</h3>
                        <p class="product-description">Kit de Teclado e Mouse para Escritório C3Tech, com Conexão USB,
                            ABNT2, Preto, KT200BK - C3Tch.</p>
                        <div class="product-price">
                            <span class="current-price">R$ 220,00</span>
                        </div>
                        <button class="product-btn add-to-cart-btn" data-id="4"
                            data-name="Kit de Teclado e Mouse para Escritório C3Tech" data-price="220.00"
                            data-image="images/kit1.png">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="images/mouse1.png" alt="Mouse Hp 100 1600dpi Usb Preto">
                        <span class="product-badge">Usado</span>
                    </div>
                    <div class="product-info">
                        <h3>Mouse Hp 100 1600dpi Usb Preto</h3>
                        <p class="product-description">Um sensor óptico preciso, com 1.600 DPI, permite o uso na maioria
                            das superfícies. Com conexão USB rápida.</p>
                        <div class="product-price">
                            <span class="current-price">R$ 65,00</span>
                        </div>
                        <button class="product-btn add-to-cart-btn" data-id="5"
                            data-name="Mouse Hp 100 1600dpi Usb Preto" data-price="65.00"
                            data-image="images/mouse1.png">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="images/teclado1.jpg" alt="Teclado sem fio Logitech K270 Preto">
                        <span class="product-badge">Usado</span>
                    </div>
                    <div class="product-info">
                        <h3>Teclado sem fio Logitech K270 Preto</h3>
                        <p class="product-description">Teclado sem fio Logitech K270, Teclas de Mídia de Fácil Acesso,
                            Conexão USB, Pilhas Inclusas e Layout ABNT2</p>
                        <div class="product-price">
                            <span class="current-price">R$ 170,00</span>
                        </div>
                        <button class="product-btn add-to-cart-btn" data-id="6"
                            data-name="Teclado sem fio Logitech K270" data-price="170.00"
                            data-image="images/teclado1.png">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Page Header -->
    <section class="header-index">
        <h1>As melhores ofertas você encontra aqui</h1>
        <p>Produtos usados, porém em ótimo estado, com até 50% de desconto.</p>
    </section>

    <section class="testimonial-section">
        <h2>O que nossos clientes dizem</h2>
        <div class="testimonial-container">

            <div class="testimonial-card">
                <div class="card-header">
                    <img src="images/mulher1.jpg" alt="Ana Silva" class="user-avatar">
                    <div class="user-info">
                        <h3>Ana Silva</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>Produto chegou antes do prazo e em perfeito estado. Recomendo muito a E-Store Solutions!</p>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="card-header">
                    <img src="images/homem1.jpeg" alt="Carlos Oliveira" class="user-avatar">
                    <div class="user-info">
                        <h3>Carlos Oliveira</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>Excelente atendimento e produtos de qualidade. Já comprei várias vezes e sempre fico satisfeito.
                    </p>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="card-header">
                    <img src="images/mulher2.jpg" alt="Mariana Costa" class="user-avatar">
                    <div class="user-info">
                        <h3>Mariana Costa</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>Adorei a experiência de compra! Site fácil de usar e entrega super rápida. Com certeza voltarei a
                        comprar.</p>
                </div>
            </div>

        </div>
    </section>

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
    <script src="product-redirect.js"></script>

</body>
</html>
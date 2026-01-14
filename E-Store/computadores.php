<?php include 'header.php'; ?>
    <link rel="stylesheet" a href="computadores.css">

 <!-- Page Header -->
 <section class="header">
    <h1>Computadores para seu Lar e Escritório</h1>
    <p>Computadores usados, mas com a qualidade que você precisa</p>
</section>

<!-- Products Section -->
<section class="products">
    <div class="products-header">
        <h2>Nossos Computadores e Monitores</h2>
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
                <img src="images/computador1.png" alt="Computador Dell Optiplex 3000">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Computador Dell Optiplex 3000</h3>
                <p>Intel I3 12100, RAM 16gb, SSD 256gb + HD 1TB, Video Radeon 550, Kit Tecldo e Mouse.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 1499,90</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="1" data-name="Computador Dell Optiplex 3000" data-price="1499.90" data-image="images/computador1.png">Adicionar ao Carrinho</button>                
                </div>
            </div>
        </div>

        <!-- Produto 2 -->
        <div class="product-card fade-up delay-1">
            <div class="product-img">
                <img src="images/monitor2.png" alt="Monitor Samsung">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Monitor Gamer Samsung 24” FHD</h3>
                <p>Monitor Samsung 24” FHD, 75Hz, HDMI, VGA, Freesync, Ajuste de Inclinação, Preto, Série T350.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 630,00</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="2" data-name="Monitor Samsung 24 FHD" data-price="630.00" data-image="images/monitor2.png">Adicionar ao Carrinho</button>                
                </div>
            </div>
        </div>

        <!-- Produto 3 -->
        <div class="product-card fade-up delay-2">
            <div class="product-img">
                <img src="images/computador3.png" alt="Computador Home Completo HD701">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Computador Home Completo HD701</h3>
                <p>Computador Home Completo Pichau HD701, Intel Core i5, 8GB DDR3, SSD 120GB + Monitor.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 1.499,90</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="3" data-name="Computador Home Completo HD701" data-price="1499.90" data-image="images/computador3.png">Adicionar ao Carrinho</button>                
                </div>
            </div>
        </div>

        <!-- Produto 4 -->
        <div class="product-card fade-up delay-3">
            <div class="product-img">
                <img src="images/monitor1.png" alt="Monitor ACER E200Q">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Monitor ACER E200Q</h3>
                <p>Monitor ACER E200Q, 19.5 POL, TN, HD, 6MS, 75HZ, HDMI/VGA</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 599,90</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="19" data-name="Monitor ACER E200Q" data-price="599.90" data-image="images/monitor1.png">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>

        <!-- Produto 5 -->
        <div class="product-card fade-up delay-4">
            <div class="product-img">
                <img src="images/notebook1.png" alt="Notebook Dell Inspirion 15 3000">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Notebook Dell Inspiron 15 3000</h3>
                <p>i15-3501-A40P Intel Core i5 1135G7 15,6" 4GB SSD 256 GB Windows 10.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 2.399,90</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="20" data-name="Notebook Dell Inspirion 15 3000" data-price="2399.90" data-image="images/notebook1.png">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>

        <!-- Produto 6 -->
        <div class="product-card fade-up delay-5">
            <div class="product-img">
                <img src="images/monitor3.png" alt="Monitor Bluecase">
                <div class="badge">Usado</div>
            </div>
            <div class="product-info">
                <h3>Monitor Bluecase 20"</h3>
                <p>Monitor Bluecase 20" LED, HDMI e VGA, preto - BM20K4HVW.</p>
                <div class="product-footer">
                    <div class="product-price"><span>R$ 350,00</span></div>
                    <button class="product-btn add-to-cart-btn" data-id="21" data-name="Monitor Bluecase" data-price="350.00" data-image="images/monitor3.png">Adicionar ao Carrinho</button>
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
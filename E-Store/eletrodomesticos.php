<?php include 'header.php'; ?>
    <link rel="stylesheet" a href="eletrodomesticos.css">

    <!-- Page Header -->
    <section class="header">
        <h1>Eletrodomésticos com Vida Nova</h1>
        <p>Eletrodomésticos usados com desempenho garantido, que facilitam sua rotina.</p>
    </section>

    <!-- Products Section -->
    <section class="products">
        <div class="products-header">
            <h2>Nossos Eletrodomésticos</h2>
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
                    <img src="images/microondas.png" alt="Micro-ondas 30 Litros LG">
                    <div class="badge">Usado</div>
                </div>
                <div class="product-info">
                    <h3>Micro-ondas 30 Litros LG</h3>
                    <p> O micro-ondas LG possui uma tecnologia projetada para garantir o cozimento e descongelamento dos
                        alimentos.</p>
                    <div class="product-footer">
                        <div class="product-price"><span>R$ 700,00</span></div>
                        <button class="product-btn add-to-cart-btn" data-id="13" data-name="Micro-ondas 30 Litros LG"
                            data-price="700.00" data-image="images/microondas.png">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <!-- Produto 2 -->
            <div class="product-card fade-up delay-1">
                <div class="product-img">
                    <img src="images/ventilador1.png" alt="Ventilador de Parede">
                    <div class="badge">Usado</div>
                </div>
                <div class="product-info">
                    <h3>Ventilador de Parede</h3>
                    <p>Ventilador de Parede 50cm VENTI50P Preto com Grade em Pintura Epóxi Preta.</p>
                    <div class="product-footer">
                        <div class="product-price"><span>R$ 620,00</span></div>
                        <button class="product-btn add-to-cart-btn" data-id="14"
                            data-name="Ventilador de Parede" data-price="620.00"
                            data-image="images/ventilador1.png">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <!-- Produto 3 -->
            <div class="product-card fade-up delay-1">
                <div class="product-img">
                    <img src="images/fogao1.png" alt="Fogão Mueller MFI4BA">
                    <div class="badge">Usado</div>
                </div>
                <div class="product-info">
                    <h3>Fogão Mueller MFI4BA</h3>
                    <p>Fogão Mueller MFI4BA Acendimento Manual 4 Bocas Mesa Inox Forno 48,1L.</p>
                    <div class="product-footer">
                        <div class="product-price"><span>R$ 620,00</span></div>
                        <button class="product-btn add-to-cart-btn" data-id="15" data-name="Fogão Mueller MFI4BA"
                            data-price="620.00" data-image="images/fogao1.png">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <!-- Produto 4 -->
            <div class="product-card fade-up delay-3">
                <div class="product-img">
                    <img src="images/geladeira.png" alt="Geladeira Industrial 4 Portas">
                    <div class="badge">Usado</div>
                </div>
                <div class="product-info">
                    <h3>Geladeira Industrial 4 Portas</h3>
                    <p>Geladeira Industrial 4 Portas 765L Galva Kofisa, isolamento térmico 100% injetado em poliuretano de alta densidade.</p>
                    <div class="product-footer">
                        <div class="product-price"><span>R$ 3.250,00</span></div>
                        <button class="product-btn add-to-cart-btn" data-id="16"
                            data-name="Geladeira Industrial 4 Portas" data-price="3250.00"
                            data-image="images/geladeira.png">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <!-- Produto 5 -->
            <div class="product-card fade-up delay-4">
                <div class="product-img">
                    <img src="images/filtro.png" alt="Purificador de Água">
                    <div class="badge">Usado</div>
                </div>
                <div class="product-info">
                    <h3>Purificador de Água</h3>
                    <p>Purificador de Água Natural e Gelada Electrolux PA31G</p>
                    <div class="product-footer">
                        <div class="product-price"><span>R$ 349,99</span></div>
                        <button class="product-btn add-to-cart-btn" data-id="17"
                            data-name="Purificador de Água" data-price="349.99"
                            data-image="images/filtro.png">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>

            <!-- Produto 6 -->
            <div class="product-card fade-up delay-5">
                <div class="product-img">
                    <img src="images/tv.png" alt="Smart TV LED 32 Philco">
                    <div class="badge">Usado</div>
                </div>
                <div class="product-info">
                    <h3>Smart TV LED 32" Philco</h3>
                    <p>Smart TV LED 32" Philco PTV32G52S HD e Áudio Dolby Conversor Digital Integrado 2 HDMI 1 USB Wi-Fi com Netflix.</p>
                    <div class="product-footer">
                        <div class="product-price"><span>R$ 949,99</span></div>
                        <button class="product-btn add-to-cart-btn" data-id="18"
                            data-name="Smart TV LED 32 Philco" data-price="949.99"
                            data-image="images/tv.png">Adicionar ao Carrinho</button>
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
// Base de dados de produtos
const productsDatabase = {
    // ============= COMPUTADORES (Index e Computadores.php) =============
    "1": {
        id: "1",
        name: "Computador Dell Optiplex 3000",
        price: 1499.90,
        image: "images/computador1.png",
        images: ["images/computador1.png"],
        category: "Computadores",
        description: "Computador Dell Optiplex 3000 completo e pronto para uso. Ideal para trabalho, estudos e entretenimento.",
        specs: [
            "Processador Intel I3 12100",
            "Memória RAM 16GB DDR4",
            "SSD 256GB + HD 1TB",
            "Placa de Vídeo Radeon 550",
            "Kit Teclado e Mouse inclusos",
            "Windows 10 Pro instalado"
        ],
        condition: "Usado",
        sold: "+200 vendidos",
        rating: 4.8,
        reviews: 45
    },
    "2": {
        id: "2",
        name: "Monitor Gamer Samsung 24\" FHD",
        price: 630.00,
        image: "images/monitor2.png",
        images: ["images/monitor2.png"],
        category: "Computadores",
        description: "Monitor Samsung 24 polegadas Full HD com taxa de atualização de 75Hz, ideal para jogos e trabalho.",
        specs: [
            "Tela 24 polegadas Full HD (1920x1080)",
            "Taxa de atualização 75Hz",
            "Tecnologia FreeSync",
            "Conexões HDMI e VGA",
            "Ajuste de inclinação",
            "Série T350"
        ],
        condition: "Usado",
        sold: "+350 vendidos",
        rating: 4.9,
        reviews: 78
    },
    "3": {
        id: "3",
        name: "Computador Home Completo HD701",
        price: 1499.90,
        image: "images/computador3.png",
        images: ["images/computador3.png"],
        category: "Computadores",
        description: "Computador completo Pichau HD701 com monitor incluído. Perfeito para uso doméstico e escritório.",
        specs: [
            "Processador Intel Core i5",
            "Memória RAM 8GB DDR3",
            "SSD 120GB",
            "Monitor LED incluído",
            "Windows 10 instalado",
            "Teclado e Mouse inclusos"
        ],
        condition: "Usado",
        sold: "+150 vendidos",
        rating: 4.7,
        reviews: 32
    },
    
    // ============= PERIFÉRICOS (Index e Perifericos.php) =============
    "4": {
        id: "4",
        name: "Kit de Teclado e Mouse para Escritório C3Tech",
        price: 220.00,
        image: "images/kit1.png",
        images: ["images/kit1.png"],
        category: "Periféricos",
        description: "Kit completo de teclado e mouse C3Tech, ideal para escritório e uso diário.",
        specs: [
            "Teclado ABNT2 padrão brasileiro",
            "Mouse óptico ergonômico",
            "Conexão USB plug and play",
            "Cor preta",
            "Modelo KT200BK",
            "Compatível com Windows e Linux"
        ],
        condition: "Usado",
        sold: "+500 vendidos",
        rating: 4.6,
        reviews: 120
    },
    "5": {
        id: "5",
        name: "Mouse Hp 100 1600dpi Usb Preto",
        price: 65.00,
        image: "images/mouse1.png",
        images: ["images/mouse1.png"],
        category: "Periféricos",
        description: "Mouse óptico HP 100 com sensor preciso de 1600 DPI. Conexão USB rápida e confiável.",
        specs: [
            "Sensor óptico 1600 DPI",
            "Conexão USB 2.0",
            "Design ergonômico",
            "Cor preta",
            "Compatível com Windows, Mac e Linux",
            "Plug and play"
        ],
        condition: "Usado",
        sold: "+800 vendidos",
        rating: 4.5,
        reviews: 156
    },
    "6": {
        id: "6",
        name: "Teclado sem fio Logitech K270 Preto",
        price: 170.00,
        image: "images/teclado1.jpg",
        images: ["images/teclado1.jpg"],
        category: "Periféricos",
        description: "Teclado sem fio Logitech K270 com teclas de mídia e layout ABNT2. Pilhas inclusas.",
        specs: [
            "Conexão sem fio 2.4GHz",
            "Layout ABNT2",
            "Teclas de mídia de fácil acesso",
            "Alcance de até 10 metros",
            "Pilhas inclusas",
            "Receptor USB nano"
        ],
        condition: "Usado",
        sold: "+400 vendidos",
        rating: 4.8,
        reviews: 89
    },

    // ============= MÓVEIS (Moveis.php) =============
    "7": {
        id: "7",
        name: "Cadeira Ergonômica de Escritório",
        price: 399.99,
        image: "images/cadeira.png",
        images: ["images/cadeira.png"],
        category: "Móveis",
        description: "Cadeira de escritório ergonômica com altura ajustável, ideal para longas jornadas de trabalho.",
        specs: [
            "Altura ajustável",
            "Encosto ergonômico",
            "Base giratória com rodízios",
            "Suporta até 120kg",
            "Revestimento em tecido respirável",
            "Braços fixos"
        ],
        condition: "Usado",
        sold: "+300 vendidos",
        rating: 4.7,
        reviews: 85
    },
    "8": {
        id: "8",
        name: "Mesa Escrivaninha Para Escritório Reforçada",
        price: 500.00,
        image: "images/mesa.png",
        images: ["images/mesa.png"],
        category: "Móveis",
        description: "Mesa escrivaninha reforçada para escritório, fabricada em MDP 15mm com tampos de cantos arredondados.",
        specs: [
            "Material: MDP 15mm",
            "Tampos com cantos arredondados",
            "Estrutura reforçada",
            "Dimensões: 120cm x 60cm",
            "Suporta até 50kg",
            "Acabamento em melamina"
        ],
        condition: "Usado",
        sold: "+250 vendidos",
        rating: 4.6,
        reviews: 67
    },
    "9": {
        id: "9",
        name: "Armário de Aço com 02 Portas de Abrir e Fechadura",
        price: 550.00,
        image: "images/armario1.png",
        images: ["images/armario1.png"],
        category: "Móveis",
        description: "Armário de aço com 02 portas de abrir, três prateleiras mais a base, com fechadura para segurança.",
        specs: [
            "Material: Aço reforçado",
            "02 portas de abrir",
            "03 prateleiras ajustáveis",
            "Fechadura com chave",
            "Dimensões: 180cm x 90cm x 40cm",
            "Acabamento em pintura epóxi"
        ],
        condition: "Usado",
        sold: "+180 vendidos",
        rating: 4.8,
        reviews: 52
    },
    "10": {
        id: "10",
        name: "Mesa Escrivaninha para Escritório",
        price: 499.90,
        image: "images/escrivaninha.png",
        images: ["images/escrivaninha.png"],
        category: "Móveis",
        description: "Mesa para escritório com borda ABS e 3 gavetas, design reto e discreto, ideal para ambientes profissionais.",
        specs: [
            "Dimensões: 150cm x 58cm",
            "03 gavetas com corrediças metálicas",
            "Borda em ABS",
            "Material: MDP 15mm",
            "Design reto e discreto",
            "Suporta até 40kg"
        ],
        condition: "Usado",
        sold: "+220 vendidos",
        rating: 4.7,
        reviews: 71
    },
    "11": {
        id: "11",
        name: "Estante de Aço Mini",
        price: 130.00,
        image: "images/armario2.png",
        images: ["images/armario2.png"],
        category: "Móveis",
        description: "Estante de aço mini com 3 prateleiras, coluna bipartida, ideal para escritório.",
        specs: [
            "03 prateleiras de 45x27cm",
            "Capacidade: 45kg por prateleira",
            "Coluna bipartida",
            "Material: Aço",
            "Cor: Branca",
            "Fácil montagem"
        ],
        condition: "Usado",
        sold: "+400 vendidos",
        rating: 4.5,
        reviews: 98
    },
    "12": {
        id: "12",
        name: "Cadeira de Escritório",
        price: 320.00,
        image: "images/cadeira3.png",
        images: ["images/cadeira3.png"],
        category: "Móveis",
        description: "Cadeira de escritório giratória com regulagem de altura em tecido preto, confortável para uso prolongado.",
        specs: [
            "Regulagem de altura a gás",
            "Base giratória com 5 rodízios",
            "Revestimento em tecido preto",
            "Encosto médio",
            "Suporta até 100kg",
            "Braços fixos"
        ],
        condition: "Usado",
        sold: "+350 vendidos",
        rating: 4.6,
        reviews: 92
    },

    // ============= ELETRODOMÉSTICOS (Eletrodomesticos.php) =============
    "13": {
        id: "13",
        name: "Micro-ondas 30 Litros LG",
        price: 700.00,
        image: "images/microondas.png",
        images: ["images/microondas.png"],
        category: "Eletrodomésticos",
        description: "Micro-ondas LG de 30 litros com tecnologia projetada para garantir o cozimento e descongelamento dos alimentos.",
        specs: [
            "Capacidade: 30 litros",
            "Potência: 1200W",
            "10 níveis de potência",
            "Função descongelar",
            "Prato giratório",
            "Timer programável"
        ],
        condition: "Usado",
        sold: "+280 vendidos",
        rating: 4.7,
        reviews: 73
    },
    "14": {
        id: "14",
        name: "Ventilador de Parede",
        price: 620.00,
        image: "images/ventilador1.png",
        images: ["images/ventilador1.png"],
        category: "Eletrodomésticos",
        description: "Ventilador de parede 50cm VENTI50P preto com grade em pintura epóxi preta.",
        specs: [
            "Diâmetro: 50cm",
            "03 velocidades",
            "Grade em pintura epóxi",
            "Oscilação horizontal",
            "Potência: 200W",
            "Cor: Preto"
        ],
        condition: "Usado",
        sold: "+320 vendidos",
        rating: 4.6,
        reviews: 88
    },
    "15": {
        id: "15",
        name: "Fogão Mueller MFI4BA",
        price: 620.00,
        image: "images/fogao1.png",
        images: ["images/fogao1.png"],
        category: "Eletrodomésticos",
        description: "Fogão Mueller MFI4BA com acendimento manual, 4 bocas, mesa inox e forno de 48,1L.",
        specs: [
            "04 bocas",
            "Mesa em inox",
            "Forno: 48,1 litros",
            "Acendimento manual",
            "Queimadores de alta eficiência",
            "Tampa de vidro temperado"
        ],
        condition: "Usado",
        sold: "+200 vendidos",
        rating: 4.5,
        reviews: 64
    },
    "16": {
        id: "16",
        name: "Geladeira Industrial 4 Portas",
        price: 3250.00,
        image: "images/geladeira.png",
        images: ["images/geladeira.png"],
        category: "Eletrodomésticos",
        description: "Geladeira industrial 4 portas 765L Galva Kofisa, com isolamento térmico 100% injetado em poliuretano de alta densidade.",
        specs: [
            "Capacidade: 765 litros",
            "04 portas",
            "Isolamento em poliuretano",
            "Sistema de refrigeração eficiente",
            "Prateleiras ajustáveis",
            "Voltagem: 220V"
        ],
        condition: "Usado",
        sold: "+120 vendidos",
        rating: 4.8,
        reviews: 45
    },
    "17": {
        id: "17",
        name: "Purificador de Água",
        price: 349.99,
        image: "images/filtro.png",
        images: ["images/filtro.png"],
        category: "Eletrodomésticos",
        description: "Purificador de água natural e gelada Electrolux PA31G, ideal para uso doméstico e comercial.",
        specs: [
            "Água natural e gelada",
            "Capacidade de refrigeração: 1,6L/h",
            "Filtro de carvão ativado",
            "Painel eletrônico",
            "Compressor de alta eficiência",
            "Voltagem: 127V"
        ],
        condition: "Usado",
        sold: "+450 vendidos",
        rating: 4.7,
        reviews: 112
    },
    "18": {
        id: "18",
        name: "Smart TV LED 32\" Philco",
        price: 949.99,
        image: "images/tv.png",
        images: ["images/tv.png"],
        category: "Eletrodomésticos",
        description: "Smart TV LED 32\" Philco PTV32G52S HD com áudio Dolby, conversor digital integrado, 2 HDMI, 1 USB, Wi-Fi e Netflix.",
        specs: [
            "Tela: 32 polegadas LED HD",
            "Resolução: 1366 x 768",
            "Áudio Dolby",
            "02 entradas HDMI",
            "01 entrada USB",
            "Wi-Fi integrado",
            "Netflix, YouTube e outros apps"
        ],
        condition: "Usado",
        sold: "+380 vendidos",
        rating: 4.8,
        reviews: 95
    },

    // ============= COMPUTADORES ADICIONAIS (Computadores.php) =============
    "19": {
        id: "19",
        name: "Monitor ACER E200Q",
        price: 599.90,
        image: "images/monitor1.png",
        images: ["images/monitor1.png"],
        category: "Computadores",
        description: "Monitor ACER E200Q de 19.5 polegadas, TN, HD, 6MS, 75Hz, com conexões HDMI e VGA.",
        specs: [
            "Tela: 19.5 polegadas",
            "Resolução: HD (1366x768)",
            "Painel: TN",
            "Tempo de resposta: 6ms",
            "Taxa de atualização: 75Hz",
            "Conexões: HDMI e VGA"
        ],
        condition: "Usado",
        sold: "+290 vendidos",
        rating: 4.6,
        reviews: 76
    },
    "20": {
        id: "20",
        name: "Notebook Dell Inspiron 15 3000",
        price: 2399.90,
        image: "images/notebook1.png",
        images: ["images/notebook1.png"],
        category: "Computadores",
        description: "Notebook Dell Inspiron 15 3000 i15-3501-A40P com Intel Core i5 1135G7, 15,6\", 4GB, SSD 256GB e Windows 10.",
        specs: [
            "Processador: Intel Core i5 1135G7",
            "Memória RAM: 4GB DDR4",
            "Armazenamento: SSD 256GB",
            "Tela: 15,6 polegadas HD",
            "Sistema: Windows 10",
            "Bateria de longa duração"
        ],
        condition: "Usado",
        sold: "+180 vendidos",
        rating: 4.7,
        reviews: 58
    },
    "21": {
        id: "21",
        name: "Monitor Bluecase 20\"",
        price: 350.00,
        image: "images/monitor3.png",
        images: ["images/monitor3.png"],
        category: "Computadores",
        description: "Monitor Bluecase 20\" LED com conexões HDMI e VGA, preto - BM20K4HVW.",
        specs: [
            "Tela: 20 polegadas LED",
            "Resolução: HD (1600x900)",
            "Conexões: HDMI e VGA",
            "Cor: Preto",
            "Ângulo de visão: 170°/160°",
            "Suporte VESA"
        ],
        condition: "Usado",
        sold: "+410 vendidos",
        rating: 4.5,
        reviews: 103
    },

    // ============= PERIFÉRICOS ADICIONAIS (Perifericos.php) =============
    "22": {
        id: "22",
        name: "Mouse com fio USB Logitech M90",
        price: 50.00,
        image: "images/mouse2.jpg",
        images: ["images/mouse2.jpg"],
        category: "Periféricos",
        description: "Mouse com fio USB Logitech M90 com design ambidestro e facilidade plug and play.",
        specs: [
            "Conexão: USB com fio",
            "Design ambidestro",
            "Sensor óptico",
            "Plug and play",
            "Compatível com Windows, Mac e Linux",
            "Durável e confiável"
        ],
        condition: "Usado",
        sold: "+650 vendidos",
        rating: 4.6,
        reviews: 142
    },
    "23": {
        id: "23",
        name: "Kit Teclado e Mouse com fio USB Logitech MK120",
        price: 149.99,
        image: "images/kit2.png",
        images: ["images/kit2.png"],
        category: "Periféricos",
        description: "Kit teclado e mouse com fio USB Logitech MK120 com design confortável, durável e resistente a respingos.",
        specs: [
            "Teclado ABNT2 resistente a respingos",
            "Mouse óptico confortável",
            "Conexão USB com fio",
            "Design durável",
            "Teclas silenciosas",
            "Compatível com Windows e Linux"
        ],
        condition: "Usado",
        sold: "+520 vendidos",
        rating: 4.7,
        reviews: 128
    },
    "24": {
        id: "24",
        name: "Mouse Gamer Corsair Katar PRO",
        price: 79.99,
        image: "images/mouse3.png",
        images: ["images/mouse3.png"],
        category: "Periféricos",
        description: "Mouse Gamer Corsair Katar PRO ultra-leve, RGB, 6 botões, 12400DPI, preto, com sensor óptico PixArt.",
        specs: [
            "Sensor: PixArt 12400 DPI",
            "06 botões programáveis",
            "Iluminação RGB",
            "Design ultra-leve",
            "Cabo trançado",
            "Software de personalização"
        ],
        condition: "Usado",
        sold: "+380 vendidos",
        rating: 4.8,
        reviews: 94
    }
};

// Função para obter parâmetros da URL
function getURLParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Função para formatar preço
function formatPrice(price) {
    return price.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

// Função para calcular parcelas
function calculateInstallments(price, installments = 21) {
    const installmentValue = price / installments;
    return `${installments}x ${formatPrice(installmentValue)} sem juros`;
}

// Função para renderizar estrelas
function renderStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 !== 0;
    let starsHTML = '';
    
    for (let i = 0; i < fullStars; i++) {
        starsHTML += '<i class="fas fa-star"></i>';
    }
    
    if (hasHalfStar) {
        starsHTML += '<i class="fas fa-star-half-alt"></i>';
    }
    
    const emptyStars = 5 - Math.ceil(rating);
    for (let i = 0; i < emptyStars; i++) {
        starsHTML += '<i class="far fa-star"></i>';
    }
    
    return starsHTML;
}

// Função para carregar produto
function loadProduct() {
    const productId = getURLParameter('id');
    
    if (!productId || !productsDatabase[productId]) {
        alert('Produto não encontrado!');
        window.location.href = 'index.php';
        return;
    }
    
    const product = productsDatabase[productId];
    
    // Atualizar breadcrumb
    document.getElementById('breadcrumb-category').textContent = product.category;
    document.getElementById('breadcrumb-product').textContent = product.name;
    
    // Atualizar título e informações básicas
    document.getElementById('product-title').textContent = product.name;
    document.getElementById('rating-number').textContent = product.rating;
    document.getElementById('product-stars').innerHTML = renderStars(product.rating);
    document.getElementById('reviews-count').textContent = `(${product.reviews})`;
    document.getElementById('product-condition').textContent = product.condition;
    document.getElementById('product-sold').textContent = product.sold;
    
    // Atualizar preço
    document.getElementById('current-price').textContent = formatPrice(product.price);
    document.getElementById('installment-info').textContent = calculateInstallments(product.price);
    
    // Atualizar imagem principal
    const mainImage = document.getElementById('main-product-image');
    mainImage.src = product.image;
    mainImage.alt = product.name;
    
    // Criar galeria de thumbnails
    const thumbnailGallery = document.getElementById('thumbnail-gallery');
    thumbnailGallery.innerHTML = '';
    
    product.images.forEach((imgSrc, index) => {
        const thumbnail = document.createElement('img');
        thumbnail.src = imgSrc;
        thumbnail.alt = `${product.name} - Imagem ${index + 1}`;
        if (index === 0) thumbnail.classList.add('active');
        
        thumbnail.addEventListener('click', () => {
            mainImage.src = imgSrc;
            document.querySelectorAll('.thumbnail-gallery img').forEach(img => {
                img.classList.remove('active');
            });
            thumbnail.classList.add('active');
        });
        
        thumbnailGallery.appendChild(thumbnail);
    });
    
    // Atualizar descrição
    const descriptionContent = document.getElementById('product-description');
    let descriptionHTML = `<p>${product.description}</p>`;
    
    if (product.specs && product.specs.length > 0) {
        descriptionHTML += '<h3 style="margin-top: 1.5rem; margin-bottom: 1rem; font-size: 1.2rem;">Especificações:</h3>';
        descriptionHTML += '<ul>';
        product.specs.forEach(spec => {
            descriptionHTML += `<li>${spec}</li>`;
        });
        descriptionHTML += '</ul>';
    }
    
    descriptionContent.innerHTML = descriptionHTML;
    
    // Configurar botões de ação
    setupActionButtons(product);
}

// Função para configurar botões de ação
function setupActionButtons(product) {
    const btnAddCart = document.getElementById('btn-add-cart');
    const btnBuyNow = document.getElementById('btn-buy-now');
    const qtyInput = document.getElementById('quantity');
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');
    
    // Controle de quantidade
    qtyMinus.addEventListener('click', () => {
        const currentQty = parseInt(qtyInput.value);
        if (currentQty > 1) {
            qtyInput.value = currentQty - 1;
        }
    });
    
    qtyPlus.addEventListener('click', () => {
        const currentQty = parseInt(qtyInput.value);
        const maxQty = parseInt(qtyInput.max);
        if (currentQty < maxQty) {
            qtyInput.value = currentQty + 1;
        }
    });
    
    // Adicionar ao carrinho
    btnAddCart.addEventListener('click', () => {
        const quantity = parseInt(qtyInput.value);
        addToCart(product, quantity);
    });
    
    // Comprar agora
    btnBuyNow.addEventListener('click', () => {
        const quantity = parseInt(qtyInput.value);
        addToCart(product, quantity);
        window.location.href = 'checkout.php';
    });
}

// Função para adicionar ao carrinho
function addToCart(product, quantity) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    const existingProduct = cart.find(item => item.id === product.id);
    
    if (existingProduct) {
        existingProduct.quantity += quantity;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: quantity
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Atualizar contador do carrinho
    updateCartCount();
    
    // Mostrar feedback
    showAddToCartFeedback();
}

// Função para atualizar contador do carrinho
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartCount = document.querySelector('.cart-count');
    
    if (cartCount) {
        cartCount.textContent = totalItems;
        cartCount.style.display = totalItems > 0 ? 'block' : 'none';
    }
}

// Função para mostrar feedback de adição ao carrinho
function showAddToCartFeedback() {
    const btnAddCart = document.getElementById('btn-add-cart');
    const originalText = btnAddCart.textContent;
    
    btnAddCart.textContent = '✓ Adicionado!';
    btnAddCart.style.backgroundColor = '#00a650';
    
    setTimeout(() => {
        btnAddCart.textContent = originalText;
        btnAddCart.style.backgroundColor = '';
    }, 2000);
}

// Inicializar página
document.addEventListener('DOMContentLoaded', () => {
    loadProduct();
    updateCartCount();
});

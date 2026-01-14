document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const navMenu = document.getElementById("nav-menu");
  
    // Adiciona o evento de clique ao botão hambúrguer
    if (hamburger && navMenu) {
        hamburger.addEventListener("click", () => {
            navMenu.classList.toggle("open");
        });
    }

    // ==================== CARRINHO DE COMPRAS ====================
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartIcon = document.querySelector('.cart-icon');
    const cartDropdown = document.querySelector('.cart-dropdown');
    const cartCount = document.querySelector('.cart-count');
    const cartItems = document.querySelector('.cart-items');
    const cartTotal = document.querySelector('.cart-total');
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    // Mostrar/esconder carrinho ao passar o mouse
    const cartContainer = document.querySelector('.cart-container');
    
    if (cartContainer && cartDropdown) {
        cartContainer.addEventListener('mouseenter', () => {
            cartDropdown.style.display = 'block';
            setTimeout(() => {
                cartDropdown.classList.add('show');
            }, 10);
        });
        
        cartContainer.addEventListener('mouseleave', () => {
            cartDropdown.classList.remove('show');
            setTimeout(() => {
                cartDropdown.style.display = 'none';
            }, 300);
        });
    }
    
    // Adicionar produto ao carrinho
    addToCartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const productPrice = parseFloat(button.getAttribute('data-price'));
            const productImage = button.getAttribute('data-image');
            
            // Verificar se o produto já está no carrinho
            const existingProduct = cart.find(item => item.id === productId);
            
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: 1
                });
            }
            
            updateCart();
            showAddedToCartAnimation(button);
            showCartAutomatically();
        });
    });
    
    // Atualizar carrinho
    function updateCart() {
        updateCartCount();
        updateCartItems();
        updateCartTotal();
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    // Atualizar contador do carrinho
    function updateCartCount() {
        if (!cartCount) return;
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
        cartCount.style.display = totalItems > 0 ? 'block' : 'none';
    }
    
    // Atualizar itens do carrinho
    function updateCartItems() {
        if (!cartItems) return;
        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Seu carrinho está vazio</p>
                </div>
            `;
        } else {
            cartItems.innerHTML = cart.map(item => `
                <div class="cart-item" data-id="${item.id}">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <div class="cart-item-controls">
                            <button class="quantity-btn minus" data-id="${item.id}">-</button>
                            <span class="quantity">${item.quantity}</span>
                            <button class="quantity-btn plus" data-id="${item.id}">+</button>
                        </div>
                        <div class="cart-item-price">R$ ${(item.price * item.quantity).toFixed(2).replace('.', ',')}</div>
                    </div>
                    <button class="remove-item" data-id="${item.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');
            
            // Adicionar event listeners para os controles
            addCartControlListeners();
        }
    }
    
    // Adicionar event listeners para controles do carrinho
    function addCartControlListeners() {
        // Botões de quantidade
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = btn.getAttribute('data-id');
                const isPlus = btn.classList.contains('plus');
                
                const product = cart.find(item => item.id === productId);
                if (product) {
                    if (isPlus) {
                        product.quantity += 1;
                    } else {
                        product.quantity -= 1;
                        if (product.quantity <= 0) {
                            removeFromCart(productId);
                            return;
                        }
                    }
                    updateCart();
                }
            });
        });
        
        // Botões de remover
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = btn.getAttribute('data-id');
                removeFromCart(productId);
            });
        });
    }
    
    // Remover produto do carrinho
    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        updateCart();
    }
    
    // Atualizar total do carrinho
    function updateCartTotal() {
        if (!cartTotal) return;
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        cartTotal.innerHTML = `<strong>Total: R$ ${total.toFixed(2).replace('.', ',')}</strong>`;
    }
    
    // Animação de produto adicionado
    function showAddedToCartAnimation(button) {
        const originalText = button.textContent;
        button.textContent = 'Adicionado!';
        button.style.backgroundColor = '#28a745';
        button.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            button.textContent = originalText;
            button.style.backgroundColor = '';
            button.style.transform = '';
        }, 1000);
    }
    
    // Mostrar carrinho automaticamente após adicionar produto
    function showCartAutomatically() {
        if (!cartDropdown) return;
        // Mostrar o carrinho imediatamente
        cartDropdown.style.display = 'block';
        setTimeout(() => {
            cartDropdown.classList.add('show');
        }, 10);
        
        // Esconder o carrinho após 3 segundos com fade out
        setTimeout(() => {
            cartDropdown.classList.remove('show');
            setTimeout(() => {
                cartDropdown.style.display = 'none';
            }, 300);
        }, 3000);
    }
    
    // Finalizar compra
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('checkout-btn')) {
            e.preventDefault();
            if (cart.length > 0) {
                // Salvar carrinho no localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                // Redirecionar para página de checkout
                window.location.href = 'checkout.php';
            } else {
                alert('Seu carrinho está vazio!');
            }
        }
    });

    // Inicializar o carrinho na carga da página
    updateCart();
});


    // ========================================
    //  LÓGICA DA NOVA BARRA DE PESQUISA
    // ========================================
    const searchToggle = document.getElementById('search-toggle');
    const searchBox = document.getElementById('search-box-toggled');
    const searchInput = searchBox ? searchBox.querySelector('input') : null;
    const searchButton = searchBox ? searchBox.querySelector('.search-button-inner') : null;

    // Lista de produtos para pesquisa (pode ser expandida)
    const products = [
        { name: 'Computador Dell Optiplex 3000', category: 'computadores', url: 'computadores.php' },
        { name: 'Monitor Gamer Samsung 24" FHD', category: 'perifericos', url: 'perifericos.php' },
        { name: 'Computador Home Completo HD701', category: 'computadores', url: 'computadores.php' },
        { name: 'Kit de Teclado e Mouse para Escritório C3Tech', category: 'perifericos', url: 'perifericos.php' },
        { name: 'Mouse Hp 100 1600dpi Usb Preto', category: 'perifericos', url: 'perifericos.php' },
        { name: 'Teclado sem fio Logitech K270', category: 'perifericos', url: 'perifericos.php' },
        { name: 'Móveis', category: 'moveis', url: 'moveis.php' },
        { name: 'Eletrodomésticos', category: 'eletrodomesticos', url: 'eletrodomesticos.php' },
        { name: 'Computadores', category: 'computadores', url: 'computadores.php' },
        { name: 'Periféricos', category: 'perifericos', url: 'perifericos.php' }
    ];

    if (searchToggle && searchBox) {
        // Toggle da barra de pesquisa
        searchToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            const isOpen = searchBox.classList.contains('open');
            
            if (isOpen) {
                closeSearchBox();
            } else {
                openSearchBox();
            }
        });

        // Função para abrir a caixa de pesquisa
        function openSearchBox() {
            searchBox.classList.add('open');
            if (searchInput) {
                setTimeout(() => {
                    searchInput.focus();
                }, 100);
            }
        }

        // Função para fechar a caixa de pesquisa
        function closeSearchBox() {
            searchBox.classList.remove('open');
            if (searchInput) {
                searchInput.blur();
            }
            removeSuggestions();
        }

        // Fecha a caixa de pesquisa se clicar fora dela
        document.addEventListener('click', function (event) {
            if (!searchBox.contains(event.target) && !searchToggle.contains(event.target)) {
                closeSearchBox();
            }
        });

        // Funcionalidade de pesquisa
        if (searchInput && searchButton) {
            // Pesquisa ao digitar (com debounce)
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length > 0) {
                    searchTimeout = setTimeout(() => {
                        showSuggestions(query);
                    }, 300);
                } else {
                    removeSuggestions();
                }
            });

            // Pesquisa ao clicar no botão ou pressionar Enter
            function performSearch() {
                const query = searchInput.value.trim();
                if (query) {
                    searchProducts(query);
                    closeSearchBox();
                }
            }

            searchButton.addEventListener('click', performSearch);
            
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    performSearch();
                }
            });
        }
    }

    // Função para mostrar sugestões
    function showSuggestions(query) {
        const suggestions = products.filter(product => 
            product.name.toLowerCase().includes(query.toLowerCase()) ||
            product.category.toLowerCase().includes(query.toLowerCase())
        ).slice(0, 5); // Limita a 5 sugestões

        removeSuggestions(); // Remove sugestões anteriores

        if (suggestions.length > 0) {
            const suggestionsContainer = document.createElement('div');
            suggestionsContainer.className = 'search-suggestions';
            suggestionsContainer.innerHTML = suggestions.map(product => `
                <div class="suggestion-item" data-url="${product.url}" data-query="${product.name}">
                    <i class="fas fa-search"></i>
                    <span>${product.name}</span>
                    <small>${product.category}</small>
                </div>
            `).join('');

            searchBox.appendChild(suggestionsContainer);

            // Adiciona event listeners para as sugestões
            suggestionsContainer.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    const query = this.getAttribute('data-query');
                    searchInput.value = query;
                    closeSearchBox();
                    
                    // Redireciona para a página correspondente
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        }
    }

    // Função para remover sugestões
    function removeSuggestions() {
        const existingSuggestions = document.querySelector('.search-suggestions');
        if (existingSuggestions) {
            existingSuggestions.remove();
        }
    }

    // Função para realizar pesquisa
    function searchProducts(query) {
        const results = products.filter(product => 
            product.name.toLowerCase().includes(query.toLowerCase()) ||
            product.category.toLowerCase().includes(query.toLowerCase())
        );

        if (results.length > 0) {
            // Se encontrou resultados, redireciona para a primeira categoria encontrada
            const firstResult = results[0];
            window.location.href = firstResult.url + '?search=' + encodeURIComponent(query);
        } else {
            // Se não encontrou resultados, mostra uma mensagem
            alert(`Nenhum produto encontrado para "${query}". Tente pesquisar por: computadores, periféricos, móveis ou eletrodomésticos.`);
        }
    }




// ==================== LÓGICA DE ORDENAÇÃO DE PRODUTOS ====================
document.addEventListener("DOMContentLoaded", function() {
    const sortSelects = document.querySelectorAll(".products-header select");

    sortSelects.forEach(sortSelect => {
        sortSelect.addEventListener("change", function() {
            const productsGrid = this.closest(".products").querySelector(".grid");
            const productCards = Array.from(productsGrid.querySelectorAll(".product-card"));
            const sortBy = this.value;

            productCards.sort((a, b) => {
                const priceA = parseFloat(a.querySelector(".product-price span").textContent.replace("R$", "").replace(".", "").replace(",", "."));
                const priceB = parseFloat(b.querySelector(".product-price span").textContent.replace("R$", "").replace(".", "").replace(",", "."));

                switch (sortBy) {
                    case "Preço: Menor para Maior":
                        return priceA - priceB;
                    case "Preço: Maior para Menor":
                        return priceB - priceA;
                    case "Mais Recentes":
                        // Para 'Mais Recentes' e 'Mais Populares', precisaríamos de dados adicionais (timestamp, vendas)
                        // Por enquanto, manter a ordem original ou uma ordem arbitrária.
                        // Implementação básica: manter a ordem atual se não houver dados específicos.
                        return 0;
                    case "Mais Populares":
                        return 0;
                    default:
                        return 0;
                }
            });

            // Remover os produtos existentes e adicionar os ordenados
            productCards.forEach(card => productsGrid.removeChild(card));
            productCards.forEach(card => productsGrid.appendChild(card));
        });
    });
});


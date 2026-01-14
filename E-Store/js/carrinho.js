    // ==================== CARRINHO DE COMPRAS ====================
    
    let cart = [];
    const cartIcon = document.querySelector('.cart-icon');
    const cartDropdown = document.querySelector('.cart-dropdown');
    const cartCount = document.querySelector('.cart-count');
    const cartItems = document.querySelector('.cart-items');
    const cartTotal = document.querySelector('.cart-total');
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    // Mostrar/esconder carrinho ao passar o mouse
    const cartContainer = document.querySelector('.cart-container');
    
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
        });
    });
    
    // Atualizar carrinho
    function updateCart() {
        updateCartCount();
        updateCartItems();
        updateCartTotal();
    }
    
    // Atualizar contador do carrinho
    function updateCartCount() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
        cartCount.style.display = totalItems > 0 ? 'block' : 'none';
    }
    
    // Atualizar itens do carrinho
    function updateCartItems() {
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
    
    // Finalizar compra
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('checkout-btn')) {
            e.preventDefault();
            if (cart.length > 0) {
                // Salvar carrinho no localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                // Redirecionar para página de checkout
                window.location.href = 'checkout.html';
            } else {
                alert('Seu carrinho está vazio!');
            }
        }
    
    });
document.addEventListener("DOMContentLoaded", function () {
    // ==================== VARIÁVEIS GLOBAIS ====================
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let shippingCost = 0;
    let discountAmount = 0;
    let appliedCoupon = null;

    // Cupons disponíveis
    const coupons = {
        "DESCONTO10": { type: "percentage", value: 10, description: "10% de desconto" },
        "FRETE20": { type: "fixed", value: 20, description: "R$ 20 de desconto" },
        "PRIMEIRA15": { type: "percentage", value: 15, description: "15% de desconto primeira compra" }
    };

    // ==================== INICIALIZAÇÃO ====================
    initializeCheckout();

    function initializeCheckout() {
        // Verificar se há itens no carrinho
        if (cart.length === 0) {
            showEmptyCartMessage();
            return;
        }

        // Carregar dados do carrinho
        loadCartItems();
        calculateShipping();
        updateTotals();
        
        // Configurar event listeners
        setupEventListeners();
        
        // Configurar máscaras de input
        setupInputMasks();
        
        // Configurar parcelamento
        updateInstallments();
    }

    // ==================== CARREGAR ITENS DO CARRINHO ====================
    function loadCartItems() {
        const checkoutItems = document.getElementById("checkout-items");
        
        if (cart.length === 0) {
            checkoutItems.innerHTML = "<div class=\"empty-cart-message\">Seu carrinho está vazio</div>";
            return;
        }

        checkoutItems.innerHTML = cart.map(item => `
            <div class="checkout-item" data-id="${item.id}">
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="item-details">
                    <h3>${item.name}</h3>
                    <div class="item-quantity">
                        <button class="qty-btn minus" data-id="${item.id}">-</button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="qty-btn plus" data-id="${item.id}">+</button>
                    </div>
                </div>
                <div class="item-price">
                    <div class="unit-price">R$ ${item.price.toFixed(2).replace(".", ",")}</div>
                    <div class="total-price">R$ ${(item.price * item.quantity).toFixed(2).replace(".", ",")}</div>
                </div>
                <button class="remove-item-btn" data-id="${item.id}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `).join("");

        // Adicionar event listeners para controles de quantidade
        setupQuantityControls();
    }

    // ==================== CONTROLES DE QUANTIDADE ====================
    function setupQuantityControls() {
        document.querySelectorAll(".qty-btn").forEach(btn => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                const productId = btn.getAttribute("data-id");
                const isPlus = btn.classList.contains("plus");
                
                updateQuantity(productId, isPlus);
            });
        });

        document.querySelectorAll(".remove-item-btn").forEach(btn => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                const productId = btn.getAttribute("data-id");
                removeItem(productId);
            });
        });
    }

    function updateQuantity(productId, increase) {
        const product = cart.find(item => item.id === productId);
        if (product) {
            if (increase) {
                product.quantity += 1;
            } else {
                product.quantity -= 1;
                if (product.quantity <= 0) {
                    removeItem(productId);
                    return;
                }
            }
            
            saveCart();
            loadCartItems();
            updateTotals();
        }
    }

    function removeItem(productId) {
        cart = cart.filter(item => item.id !== productId);
        saveCart();
        
        if (cart.length === 0) {
            showEmptyCartMessage();
        } else {
            loadCartItems();
            updateTotals();
        }
    }

    function saveCart() {
        localStorage.setItem("cart", JSON.stringify(cart));
        // Atualizar contador do carrinho no header
        updateHeaderCartCount();
    }

    function updateHeaderCartCount() {
        const cartCount = document.querySelector(".cart-count");
        if (cartCount) {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
            cartCount.style.display = totalItems > 0 ? "block" : "none";
        }
    }

    // ==================== CÁLCULOS ====================
    function calculateSubtotal() {
        return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    function calculateShipping() {
        const subtotal = calculateSubtotal();
        // Frete grátis acima de R$ 500
        shippingCost = subtotal >= 500 ? 0 : 50;
    }

    function updateTotals() {
        const subtotal = calculateSubtotal();
        calculateShipping();
        
        // Aplicar desconto do método de pagamento
        const paymentMethod = document.querySelector("input[name=\"payment-method\"]:checked")?.value;
        let paymentDiscount = 0;
        
        if (paymentMethod === "pix") {
            paymentDiscount = subtotal * 0.05; // 5% desconto PIX
        } else if (paymentMethod === "boleto") {
            paymentDiscount = subtotal * 0.03; // 3% desconto boleto
        }

        const totalDiscount = discountAmount + paymentDiscount;
        const finalTotal = subtotal + shippingCost - totalDiscount;

        // Atualizar interface
        document.getElementById("subtotal").textContent = `R$ ${subtotal.toFixed(2).replace(".", ",")}`;
        document.getElementById("shipping-cost").textContent = shippingCost === 0 ? "Grátis" : `R$ ${shippingCost.toFixed(2).replace(".", ",")}`;
        
        if (totalDiscount > 0) {
            document.getElementById("discount-line").style.display = "flex";
            document.getElementById("discount-amount").textContent = `-R$ ${totalDiscount.toFixed(2).replace(".", ",")}`;
        } else {
            document.getElementById("discount-line").style.display = "none";
        }
        
        document.getElementById("final-total").textContent = `R$ ${finalTotal.toFixed(2).replace(".", ",")}`;
        
        // Atualizar parcelamento
        updateInstallments();
    }

    // ==================== PARCELAMENTO ====================
    function updateInstallments() {
        const subtotal = calculateSubtotal();
        const installmentsSelect = document.getElementById("installments");
        
        if (!installmentsSelect) return;
        
        installmentsSelect.innerHTML = "";
        
        // Calcular parcelas (máximo 12x)
        const maxInstallments = Math.min(12, Math.floor(subtotal / 50)); // Mínimo R$ 50 por parcela
        
        for (let i = 1; i <= maxInstallments; i++) {
            const installmentValue = subtotal / i;
            let interestRate = 0;
            
            // Juros a partir da 4ª parcela
            if (i > 3) {
                interestRate = 0.02 * (i - 3); // 2% ao mês a partir da 4ª parcela
            }
            
            const finalInstallmentValue = installmentValue * (1 + interestRate);
            const totalWithInterest = finalInstallmentValue * i;
            
            const option = document.createElement("option");
            option.value = i;
            
            if (i <= 3) {
                option.textContent = `${i}x de R$ ${installmentValue.toFixed(2).replace(".", ",")} sem juros`;
            } else {
                option.textContent = `${i}x de R$ ${finalInstallmentValue.toFixed(2).replace(".", ",")} (Total: R$ ${totalWithInterest.toFixed(2).replace(".", ",")})`;
            }
            
            installmentsSelect.appendChild(option);
        }
    }

    // ==================== EVENT LISTENERS ====================
    function setupEventListeners() {
        // Métodos de pagamento
        document.querySelectorAll("input[name=\"payment-method\"]").forEach(radio => {
            radio.addEventListener("change", handlePaymentMethodChange);
        });

        // Busca CEP
        document.getElementById("cep-search")?.addEventListener("click", searchCEP);
        document.getElementById("cep")?.addEventListener("blur", searchCEP);

        // Cupom de desconto
        document.getElementById("apply-coupon")?.addEventListener("click", applyCoupon);
        document.getElementById("coupon-code")?.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                applyCoupon();
            }
        });

        // Finalizar pedido
        document.getElementById("finish-order")?.addEventListener("click", finishOrder);
    }

    // ==================== MÉTODOS DE PAGAMENTO ====================
    function handlePaymentMethodChange(e) {
        const method = e.target.value;
        
        // Esconder todos os formulários
        document.querySelectorAll(".payment-form").forEach(form => {
            form.style.display = "none";
        });
        
        // Mostrar formulário correspondente
        const formId = method + "-form";
        const form = document.getElementById(formId);
        if (form) {
            form.style.display = "block";
        }
        
        // Atualizar totais (para aplicar desconto)
        updateTotals();
    }

    // ==================== BUSCA CEP ====================
    async function searchCEP() {
        const cepInput = document.getElementById("cep");
        const cep = cepInput.value.replace(/\D/g, "");
        
        if (cep.length !== 8) {
            showMessage("CEP deve ter 8 dígitos", "error");
            return;
        }
        
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            
            if (data.erro) {
                showMessage("CEP não encontrado", "error");
                return;
            }
            
            // Preencher campos
            document.getElementById("address").value = data.logradouro || "";
            document.getElementById("neighborhood").value = data.bairro || "";
            document.getElementById("city").value = data.localidade || "";
            document.getElementById("state").value = data.uf || "";
            
            showMessage("CEP encontrado!", "success");
            
        } catch (error) {
            showMessage("Erro ao buscar CEP", "error");
        }
    }

    // ==================== CUPOM DE DESCONTO ====================
    function applyCoupon() {
        const couponCode = document.getElementById("coupon-code").value.trim().toUpperCase();
        const couponMessage = document.getElementById("coupon-message");
        
        if (!couponCode) {
            showCouponMessage("Digite um código de cupom", "error");
            return;
        }
        
        if (appliedCoupon) {
            showCouponMessage("Já existe um cupom aplicado", "error");
            return;
        }
        
        const coupon = coupons[couponCode];
        if (!coupon) {
            showCouponMessage("Cupom inválido", "error");
            return;
        }
        
        // Aplicar desconto
        const subtotal = calculateSubtotal();
        if (coupon.type === "percentage") {
            discountAmount = subtotal * (coupon.value / 100);
        } else {
            discountAmount = coupon.value;
        }
        
        appliedCoupon = couponCode;
        showCouponMessage(`Cupom aplicado: ${coupon.description}`, "success");
        updateTotals();
        
        // Desabilitar campo
        document.getElementById("coupon-code").disabled = true;
        document.getElementById("apply-coupon").textContent = "Remover";
        document.getElementById("apply-coupon").onclick = removeCoupon;
    }

    function removeCoupon() {
        discountAmount = 0;
        appliedCoupon = null;
        
        document.getElementById("coupon-code").value = "";
        document.getElementById("coupon-code").disabled = false;
        document.getElementById("apply-coupon").textContent = "Aplicar";
        document.getElementById("apply-coupon").onclick = applyCoupon;
        
        showCouponMessage("Cupom removido", "info");
        updateTotals();
    }

    function showCouponMessage(message, type) {
        const couponMessage = document.getElementById("coupon-message");
        couponMessage.textContent = message;
        couponMessage.className = `coupon-message ${type}`;
        
        setTimeout(() => {
            couponMessage.textContent = "";
            couponMessage.className = "coupon-message";
        }, 3000);
    }

    // ==================== MÁSCARAS DE INPUT ====================
    function setupInputMasks() {
        // Máscara CPF
        const cpfInput = document.getElementById("cpf");
        if (cpfInput) {
            cpfInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/\D/g, "");
                value = value.replace(/(\d{3})(\d)/, "$1.$2");
                value = value.replace(/(\d{3})(\d)/, "$1.$2");
                value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
                e.target.value = value;
            });
        }

        // Máscara telefone
        const phoneInput = document.getElementById("phone");
        if (phoneInput) {
            phoneInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/\D/g, "");
                value = value.replace(/(\d{2})(\d)/, "($1) $2");
                value = value.replace(/(\d{4,5})(\d{4})$/, "$1-$2");
                e.target.value = value;
            });
        }

        // Máscara CEP
        const cepInput = document.getElementById("cep");
        if (cepInput) {
            cepInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/\D/g, "");
                value = value.replace(/(\d{5})(\d)/, "$1-$2");
                e.target.value = value;
            });
        }

        // Máscara cartão de crédito
        const cardNumberInput = document.getElementById("card-number");
        if (cardNumberInput) {
            cardNumberInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/\D/g, "");
                value = value.replace(/(\d{4})(\d)/, "$1 $2");
                value = value.replace(/(\d{4})(\d)/, "$1 $2");
                value = value.replace(/(\d{4})(\d)/, "$1 $2");
                e.target.value = value;
                
                // Detectar bandeira do cartão
                detectCardBrand(value.replace(/\s/g, ""));
            });
        }

        // Máscara validade cartão
        const cardExpiryInput = document.getElementById("card-expiry");
        if (cardExpiryInput) {
            cardExpiryInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/\D/g, "");
                value = value.replace(/(\d{2})(\d)/, "$1/$2");
                e.target.value = value;
            });
        }

        // Máscara cartão de débito
        const debitNumberInput = document.getElementById("debit-number");
        if (debitNumberInput) {
            debitNumberInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/\D/g, "");
                value = value.replace(/(\d{4})(\d)/, "$1 $2");
                value = value.replace(/(\d{4})(\d)/, "$1 $2");
                value = value.replace(/(\d{4})(\d)/, "$1 $2");
                e.target.value = value;
            });
        }

        const debitExpiryInput = document.getElementById("debit-expiry");
        if (debitExpiryInput) {
            debitExpiryInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/\D/g, "");
                value = value.replace(/(\d{2})(\d)/, "$1/$2");
                e.target.value = value;
            });
        }

        const debitCvvInput = document.getElementById("debit-cvv");
        if (debitCvvInput) {
            debitCvvInput.addEventListener("input", (e) => {
                e.target.value = e.target.value.replace(/\D/g, "").slice(0, 3);
            });
        }
    }

    // ==================== VALIDAÇÃO DE FORMULÁRIO ====================
    function validateForm() {
        let isValid = true;
        
        // Validar campos de contato
        const contactFields = ["full-name", "email", "phone", "cpf"];
        contactFields.forEach(id => {
            const input = document.getElementById(id);
            if (input && !input.value.trim()) {
                input.classList.add("error");
                isValid = false;
            } else {
                input?.classList.remove("error");
            }
        });

        // Validar campos de endereço
        const addressFields = ["cep", "address", "number", "neighborhood", "city", "state"];
        addressFields.forEach(id => {
            const input = document.getElementById(id);
            if (input && !input.value.trim()) {
                input.classList.add("error");
                isValid = false;
            } else {
                input?.classList.remove("error");
            }
        });

        // Validar método de pagamento
        const paymentMethod = document.querySelector("input[name=\"payment-method\"]:checked");
        if (!paymentMethod) {
            isValid = false;
            showMessage("Selecione um método de pagamento", "error");
        } else {
            // Validação específica para cada método de pagamento
            if (paymentMethod.value === "credit-card") {
                const cardFields = ["card-name", "card-number", "card-expiry", "card-cvv"];
                cardFields.forEach(id => {
                    const input = document.getElementById(id);
                    if (input && !input.value.trim()) {
                        input.classList.add("error");
                        isValid = false;
                    } else {
                        input?.classList.remove("error");
                    }
                });
            } else if (paymentMethod.value === "debit-card") {
                const debitFields = ["debit-name", "debit-number", "debit-expiry", "debit-cvv"];
                debitFields.forEach(id => {
                    const input = document.getElementById(id);
                    if (input && !input.value.trim()) {
                        input.classList.add("error");
                        isValid = false;
                    } else {
                        input?.classList.remove("error");
                    }
                });
            }
        }

        // Validar CPF
        const cpfInput = document.getElementById("cpf");
        if (cpfInput && cpfInput.value.trim() && !isValidCPF(cpfInput.value.trim())) {
            cpfInput.classList.add("error");
            showMessage("CPF inválido", "error");
            isValid = false;
        }

        return isValid;
    }

    function isValidCPF(cpf) {
        cpf = cpf.replace(/\D/g, "");
        if (cpf.length !== 11) return false;
        
        // Verificar se todos os dígitos são iguais
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        
        // Validar dígitos verificadores
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let digit1 = 11 - (sum % 11);
        if (digit1 > 9) digit1 = 0;
        
        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        let digit2 = 11 - (sum % 11);
        if (digit2 > 9) digit2 = 0;
        
        return digit1 === parseInt(cpf.charAt(9)) && digit2 === parseInt(cpf.charAt(10));
    }

    // ==================== FINALIZAR PEDIDO ====================
    function finishOrder() {
        if (!validateForm()) {
            showMessage("Por favor, preencha todos os campos obrigatórios", "error");
            return;
        }
        
        // Simular processamento
        const finishBtn = document.getElementById("finish-order");
        const originalText = finishBtn.innerHTML;
        
        finishBtn.innerHTML = "<i class=\"fas fa-spinner fa-spin\"></i> Processando...";
        finishBtn.disabled = true;
        
        setTimeout(async () => {
            // Coletar dados do cliente
            const customerInfo = {
                name: document.getElementById("fullName").value,
                email: document.getElementById("email").value,
                phone: document.getElementById("phone").value,
                cpf: document.getElementById("cpf").value,
                address: document.getElementById("address").value,
                number: document.getElementById("number").value,
                complement: document.getElementById("complement").value,
                neighborhood: document.getElementById("neighborhood").value,
                city: document.getElementById("city").value,
                state: document.getElementById("state").value,
                cep: document.getElementById("cep").value,
            };

            // Coletar itens do carrinho
            const cartItemsData = cart.map(item => ({
                id: item.id,
                name: item.name,
                quantity: item.quantity,
                price: item.price,
                image: item.image
            }));

            // Coletar detalhes de pagamento (simplificado para o exemplo)
            const paymentMethod = document.querySelector("input[name=\"payment-method\"]:checked").value;
            const paymentDetails = {
                method: paymentMethod,
                // Adicionar outros detalhes específicos do método de pagamento aqui, se necessário
            };

            const subtotal = calculateSubtotal();
            const totalAmount = subtotal + shippingCost - discountAmount; // Usar o total calculado
            const orderNumber = generateOrderNumber();

            try {
                const response = await fetch("admin_panel/process_order.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        customerInfo: customerInfo,
                        cartItems: cartItemsData,
                        paymentDetails: paymentDetails,
                        totalAmount: totalAmount,
                        orderNumber: orderNumber
                    }),
                });
                const data = await response.json();
                console.log("API Response:", data);

                if (data.success) {
                    // Limpar carrinho
                    cart = [];
                    saveCart();
                    // Mostrar modal de confirmação
                    showConfirmationModal(orderNumber);
                } else {
                    showMessage(`Erro ao finalizar pedido: ${data.message}`, "error");
                }
            } catch (error) {
                console.error("Error:", error);
                showMessage("Erro de comunicação com o servidor.", "error");
            } finally {
                finishBtn.innerHTML = originalText;
                finishBtn.disabled = false;
            }
        }, 2000);
    }

    function generateOrderNumber() {
        const timestamp = Date.now();
        const random = Math.floor(Math.random() * 1000);
        return `${timestamp}${random}`.slice(-8);
    }

    function showConfirmationModal(orderNumber) {
        document.getElementById("order-number").textContent = orderNumber;
        document.getElementById("confirmation-modal").style.display = "flex";
    }

    // ==================== FUNÇÕES AUXILIARES ====================
    function showEmptyCartMessage() {
        const checkoutItems = document.getElementById("checkout-items");
        checkoutItems.innerHTML = `
            <div class="empty-cart-checkout">
                <i class="fas fa-shopping-cart"></i>
                <h3>Seu carrinho está vazio</h3>
                <p>Adicione produtos ao carrinho para continuar com a compra.</p>
                <a href="index.php" class="btn-primary">
                    <i class="fas fa-arrow-left"></i> Continuar Comprando
                </a>
            </div>
        `;
        
        // Esconder seções desnecessárias
        document.querySelectorAll(".checkout-section:not(:first-child)").forEach(section => {
            section.style.display = "none";
        });
        document.querySelector(".checkout-actions").style.display = "none";
    }

    function showMessage(message, type) {
        // Criar elemento de mensagem
        const messageElement = document.createElement("div");
        messageElement.className = `message ${type}`;
        messageElement.innerHTML = `
            <i class="fas fa-${type === "error" ? "exclamation-circle" : type === "success" ? "check-circle" : "info-circle"}"></i>
            ${message}
        `;
        
        // Adicionar ao topo da página
        document.body.insertBefore(messageElement, document.body.firstChild);
        
        // Remover após 3 segundos
        setTimeout(() => {
            messageElement.remove();
        }, 3000);
    }

    // ==================== FUNÇÕES GLOBAIS ====================
    window.closeModal = function() {
        document.getElementById("confirmation-modal").style.display = "none";
        window.location.href = "index.php";
    };
});

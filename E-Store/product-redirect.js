// Script para redirecionar para a página de produto ao clicar em "Adicionar ao Carrinho"
document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        // Remove o event listener antigo e adiciona o novo
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        newButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = newButton.getAttribute('data-id');
            
            if (productId) {
                // Redireciona para a página de produto
                window.location.href = `produto.php?id=${productId}`;
            }
        });
    });
    
    // Também adicionar clique nos cards de produto
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        // Tornar o card clicável (exceto os botões)
        card.style.cursor = 'pointer';
        
        card.addEventListener('click', (e) => {
            // Verifica se o clique não foi em um botão
            if (!e.target.closest('.add-to-cart-btn') && !e.target.closest('button')) {
                const button = card.querySelector('.add-to-cart-btn');
                const productId = button ? button.getAttribute('data-id') : null;
                
                if (productId) {
                    window.location.href = `produto.php?id=${productId}`;
                }
            }
        });
    });
});

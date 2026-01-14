
    // ========================================
    //  LÓGICA DA NOVA BARRA DE PESQUISA
    // ========================================
    const searchToggle = document.getElementById('search-toggle');
    const searchBox = document.getElementById('search-box-toggled');
    const searchInput = searchBox ? searchBox.querySelector('input') : null;
    const searchButton = searchBox ? searchBox.querySelector('.search-button-inner') : null;

    // Lista de produtos para pesquisa (pode ser expandida)
    const products = [
        { name: 'Computador Dell Optiplex 3000', category: 'computadores', url: 'computadores.html' },
        { name: 'Monitor Gamer Samsung 24" FHD', category: 'perifericos', url: 'perifericos.html' },
        { name: 'Computador Home Completo HD701', category: 'computadores', url: 'computadores.html' },
        { name: 'Kit de Teclado e Mouse para Escritório C3Tech', category: 'perifericos', url: 'perifericos.html' },
        { name: 'Mouse Hp 100 1600dpi Usb Preto', category: 'perifericos', url: 'perifericos.html' },
        { name: 'Teclado sem fio Logitech K270', category: 'perifericos', url: 'perifericos.html' },
        { name: 'Móveis', category: 'moveis', url: 'moveis.html' },
        { name: 'Eletrodomésticos', category: 'eletrodomesticos', url: 'eletrodomesticos.html' },
        { name: 'Computadores', category: 'computadores', url: 'computadores.html' },
        { name: 'Periféricos', category: 'perifericos', url: 'perifericos.html' }
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






    // ========================================
    //  LÓGICA DO MENU FLUTUANTE DO USUÁRIO
    // ========================================
    // Removido o JavaScript para permitir que o CSS gerencie o hover
    // O comportamento agora é controlado inteiramente pelo CSS com :hover


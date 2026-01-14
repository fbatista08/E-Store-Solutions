  function toggleAccountMenu() {
    const menu = document.getElementById('accountDropdown');
    // Alterna entre mostrar e esconder
    if (menu.style.display === 'block') {
      menu.style.display = 'none';
    } else {
      menu.style.display = 'block';
    }
  }

  // Fecha o menu se clicar fora dele
  window.addEventListener('click', function(event) {
    const menu = document.getElementById('accountDropdown');
    const button = document.querySelector('.account-btn, .fas.fa-user');
    
    if (!menu.contains(event.target) && !button.contains(event.target)) {
      menu.style.display = 'none';
    }
  });

 // Função para exibir o alerta e confirmar se o usuário deseja sair
 function sairDaConta() {
    // Exibe um alerta de confirmação
    const confirmar = confirm("Você tem certeza que deseja sair?");
    
    // Se o usuário clicar em "OK" (confirmar)
    if (confirmar) {
      // Redireciona para a página de logout ou qualquer outra ação que você deseje
      window.location.href = "../tela-de-login/login.html"; // Alterar para a URL de logout ou ação de logout
    }
  }
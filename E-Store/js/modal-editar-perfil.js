// Seleção dos elementos
const btnEditarPerfil = document.getElementById("btnEditarPerfil");
const modalEditarPerfil = document.getElementById("modalEditarPerfil");
const fecharEditarPerfil = document.getElementById("fecharEditarPerfil");

const inputFotoPerfil = document.getElementById("inputFotoPerfil");
const previewFotoPerfil = document.getElementById("previewFotoPerfil");
const inputNomePerfil = document.getElementById("inputNomePerfil");
const inputEmailPerfil = document.getElementById("inputEmailPerfil");

const nomeDisplay = document.getElementById("nomeDisplay");
const emailDisplay = document.getElementById("emailDisplay");
const fotoPerfilDisplay = document.querySelector(".foto-perfil");

// A função carregarPerfilSalvo foi removida para evitar que o JavaScript sobrescreva
// os dados carregados pelo PHP, que são os dados corretos do usuário logado.
// A persistência dos dados do perfil será tratada pelo backend (update_profile.php).

// Função para abrir o modal
function abrirModal() {
  modalEditarPerfil.style.display = "flex";

  // Preencher os inputs com dados atuais
  inputNomePerfil.value = nomeDisplay.textContent;
  inputEmailPerfil.value = emailDisplay.textContent;

  // Resetar preview da foto
  previewFotoPerfil.style.display = "none";
  previewFotoPerfil.src = "";
  inputFotoPerfil.value = ""; // limpa seleção do input
}

// Função para fechar o modal
function fecharModal() {
  modalEditarPerfil.style.display = "none";
}

// Abrir modal ao clicar no botão "Editar Perfil"
if (btnEditarPerfil) {
  btnEditarPerfil.addEventListener("click", function (e) {
    e.preventDefault();
    abrirModal();
  });
}

// Fechar modal ao clicar no botão fechar (X)
if (fecharEditarPerfil) {
  fecharEditarPerfil.addEventListener("click", fecharModal);
}

// Fechar modal clicando fora dele
if (modalEditarPerfil) {
  modalEditarPerfil.addEventListener("click", function (e) {
    if (e.target === modalEditarPerfil) {
      fecharModal();
    }
  });
}

// Preview da foto selecionada
if (inputFotoPerfil) {
  inputFotoPerfil.addEventListener("change", () => {
    const file = inputFotoPerfil.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        previewFotoPerfil.src = e.target.result;
        previewFotoPerfil.style.display = "block";
      };
      reader.readAsDataURL(file);
    } else {
      previewFotoPerfil.style.display = "none";
      previewFotoPerfil.src = "";
    }
  });
}

// Salvar alterações do formulário
const formEditarPerfil = document.getElementById("formEditarPerfil");
if (formEditarPerfil) {
  formEditarPerfil.addEventListener("submit", (e) => {
    const novoNome = inputNomePerfil.value.trim();
    const novoEmail = inputEmailPerfil.value.trim();

    if (!novoNome || !novoEmail) {
      e.preventDefault();
      alert("Por favor, preencha nome e email.");
      return;
    }

    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(novoEmail)) {
      e.preventDefault();
      alert("Por favor, insira um email válido.");
      return;
    }

    // Permitir que o formulário seja submetido normalmente para o servidor
    // O PHP irá processar o upload da foto e atualizar os dados no banco
  });
}

// A função carregarPerfilSalvo foi removida. O perfil é carregado pelo PHP.


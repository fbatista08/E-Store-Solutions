const openModalBtn = document.getElementById('btn-form-payment');
const closeModalBtn = document.getElementById('close-modal-btn');
const modalPagamento = document.getElementById('form-modal');
const formPagamento = document.getElementById('payment-form');
const paymentDisplay1 = document.getElementById('payment-method1');
const paymentDisplay2 = document.getElementById('payment-method2');

// Função para carregar a forma de pagamento salva do localStorage
function carregarFormaPagamentoSalva() {
  try {
    const pagamentoSalvo = localStorage.getItem('forma_pagamento_usuario');
    if (pagamentoSalvo) {
      const pagamento = JSON.parse(pagamentoSalvo);
      paymentDisplay1.textContent = `${pagamento.method}: ${pagamento.details}`;
      paymentDisplay2.textContent = `(Validade: ${pagamento.formattedExpiry})`;
    }
  } catch (error) {
    console.error('Erro ao carregar forma de pagamento salva:', error);
  }
}

openModalBtn.addEventListener('click', () => {
  modalPagamento.style.display = 'flex';
  // Preencher o formulário com dados existentes, se houver
  try {
    const pagamentoSalvo = localStorage.getItem('forma_pagamento_usuario');
    if (pagamentoSalvo) {
      const pagamento = JSON.parse(pagamentoSalvo);
      document.getElementById('method').value = pagamento.method;
      document.getElementById('details').value = pagamento.details;
      // A data de validade precisa ser formatada para 'YYYY-MM'
      const [month, year] = pagamento.formattedExpiry.split('/');
      document.getElementById('expiry').value = `20${year}-${month}`;
    }
  } catch (error) {
    console.error('Erro ao preencher formulário de pagamento:', error);
  }
});

closeModalBtn.addEventListener('click', () => {
  modalPagamento.style.display = 'none';
  formPagamento.reset();
});

// Fechar modal clicando fora dele
if (modalPagamento) {
  modalPagamento.addEventListener('click', function (e) {
    if (e.target === modalPagamento) {
      modalPagamento.style.display = 'none';
      formPagamento.reset();
    }
  });
}

formPagamento.addEventListener('submit', event => {
  event.preventDefault();

  const method = document.getElementById('method').value.trim();
  const details = document.getElementById('details').value.trim();
  const expiry = document.getElementById('expiry').value;

  // Validações básicas
  if (!method || !details || !expiry) {
    alert('Por favor, preencha todos os campos da forma de pagamento.');
    return;
  }

  const [year, month] = expiry.split('-');
  const formattedExpiry = `${month}/${year.slice(2)}`;

  paymentDisplay1.textContent = `${method}: ${details}`;
  paymentDisplay2.textContent = `(Validade: ${formattedExpiry})`;

  // Salvar no localStorage para persistência
  const pagamentoData = {
    method,
    details,
    expiry,
    formattedExpiry,
    dataAtualizacao: new Date().toISOString()
  };
  localStorage.setItem('forma_pagamento_usuario', JSON.stringify(pagamentoData));

  alert('Forma de pagamento atualizada com sucesso!');
  formPagamento.reset();
  modalPagamento.style.display = 'none';
});

// Carregar forma de pagamento salva ao inicializar a página
document.addEventListener('DOMContentLoaded', carregarFormaPagamentoSalva);


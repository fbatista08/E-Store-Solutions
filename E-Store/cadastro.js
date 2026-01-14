  window.onload = function() {
    const inputTelefone = document.getElementById('telefone');
    VMasker(inputTelefone).maskPattern('(99) 99999-9999');
  };

function formatarTelefone(campo) {
  let valor = campo.value.replace(/\D/g, ""); // Remove tudo que não é número
  valor = valor.replace(/^(\d\d)(\d)/g, "($1) $2"); // Coloca parênteses em volta dos dois primeiros dígitos
  valor = valor.replace(/(\d{5})(\d)/, "$1-$2"); // Coloca o hífen depois dos cinco primeiros dígitos

  campo.value = valor;
}

document.addEventListener('DOMContentLoaded', () => {
    const cpfInput = document.getElementById('cpf');
  
    cpfInput.addEventListener('input', (event) => {
      let value = event.target.value;
      value = value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
  
      if (value.length > 11) {
        value = value.slice(0, 11); // Limita a 11 dígitos
      }
  
      if (value.length > 9) {
        value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, '$1.$2.$3-$4');
      } else if (value.length > 6) {
        value = value.replace(/^(\d{3})(\d{3})(\d{3}).*/, '$1.$2.$3');
      } else if (value.length > 3) {
        value = value.replace(/^(\d{3})(\d{3}).*/, '$1.$2');
      } else if (value.length > 0) {
        value = value.replace(/^(\d{3}).*/, '$1');
      }
  
      event.target.value = value;
    });

    // Formatação automática do CEP com hífen
    const cepInput = document.getElementById('cep');
    
    cepInput.addEventListener('input', (event) => {
      let value = event.target.value;
      value = value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
      
      if (value.length > 8) {
        value = value.slice(0, 8); // Limita a 8 dígitos
      }
      
      if (value.length > 5) {
        value = value.replace(/^(\d{5})(\d{1,3}).*/, '$1-$2');
      }
      
      event.target.value = value;
    });

    // Busca automática de endereço pelo CEP
    cepInput.addEventListener('blur', function() {
      const cep = this.value.replace(/\D/g, '');
      
      if (cep.length === 8) {
        // Faz a requisição para a API ViaCEP
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(response => response.json())
          .then(data => {
            if (!data.erro) {
              // Preenche os campos com os dados retornados
              document.getElementById('rua').value = data.logradouro || '';
              document.getElementById('bairro').value = data.bairro || '';
              document.getElementById('cidade').value = data.localidade || '';
              document.getElementById('estado').value = data.uf || '';
              
              // Foca no campo de número
              document.getElementById('numero').focus();
            } else {
              alert('CEP não encontrado!');
            }
          })
          .catch(error => {
            console.error('Erro ao buscar CEP:', error);
            alert('Erro ao buscar CEP. Tente novamente.');
          });
      }
    });
  });
  
  $(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
  });
    
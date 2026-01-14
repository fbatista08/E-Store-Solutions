// Elementos do DOM
const btnAlterarEndereco = document.getElementById('btn-endereco');
const btnFecharEndereco = document.getElementById('btn-fechar-end');
const formularioEndereco = document.getElementById('formularioEndereco');
const formEndereco = document.getElementById('formEndereco');
const enderecoDisplay1 = document.getElementById('endereco-display1');
const enderecoDisplay2 = document.getElementById('endereco-display2');

// Função para formatar CEP
function formatarCEP(cep) {
    // Remove caracteres não numéricos
    cep = cep.replace(/\D/g, '');
    
    // Aplica a máscara 00000-000
    if (cep.length <= 5) {
        return cep;
    } else {
        return cep.substring(0, 5) + '-' + cep.substring(5, 8);
    }
}

// Função para validar CEP
function validarCEP(cep) {
    const cepRegex = /^\d{5}-?\d{3}$/;
    return cepRegex.test(cep);
}

// Função para buscar endereço pelo CEP usando ViaCEP API
async function buscarEnderecoPorCEP(cep) {
    try {
        const cepLimpo = cep.replace(/\D/g, '');
        const response = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
        const data = await response.json();
        
        if (data.erro) {
            throw new Error('CEP não encontrado');
        }
        
        return data;
    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        return null;
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Abrir modal de endereço
    if (btnAlterarEndereco) {
        btnAlterarEndereco.addEventListener('click', function(e) {
            e.preventDefault();
            formularioEndereco.style.display = 'flex';
        });
    }

    // Fechar modal de endereço
    if (btnFecharEndereco) {
        btnFecharEndereco.addEventListener('click', function(e) {
            e.preventDefault();
            formularioEndereco.style.display = 'none';
            formEndereco.reset();
        });
    }

    // Fechar modal clicando fora dele
    if (formularioEndereco) {
        formularioEndereco.addEventListener('click', function(e) {
            if (e.target === formularioEndereco) {
                formularioEndereco.style.display = 'none';
                formEndereco.reset();
            }
        });
    }

    // Formatação automática do CEP
    const cepInput = document.getElementById('cepEnd');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            e.target.value = formatarCEP(e.target.value);
        });

        // Buscar endereço automaticamente quando CEP for válido
        cepInput.addEventListener('blur', async function(e) {
            const cep = e.target.value;
            if (validarCEP(cep)) {
                const endereco = await buscarEnderecoPorCEP(cep);
                if (endereco) {
                    // Preencher campos automaticamente
                    const ruaInput = document.getElementById('ruaEnd');
                    const cidadeInput = document.getElementById('cidadeEnd');
                    const estadoSelect = document.getElementById('estadoEnd');

                    if (ruaInput && endereco.logradouro) {
                        ruaInput.value = endereco.logradouro;
                    }
                    if (cidadeInput && endereco.localidade) {
                        cidadeInput.value = endereco.localidade;
                    }
                    if (estadoSelect && endereco.uf) {
                        estadoSelect.value = endereco.uf;
                    }
                }
            }
        });
    }

    // Submissão do formulário
    if (formEndereco) {
        formEndereco.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Obter valores dos campos
            const rua = document.getElementById('ruaEnd').value.trim();
            const numero = document.getElementById('numeroEnd').value.trim();
            const complemento = document.getElementById('complementoEnd').value.trim();
            const bairro = ''; // Campo bairro não está no formulário, mas está no banco
            const cidade = document.getElementById('cidadeEnd').value.trim();
            const estado = document.getElementById('estadoEnd').value;
            const cep = document.getElementById('cepEnd').value.trim();

            // Validações
            if (!rua || !numero || !cidade || !estado || !cep) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }

            if (!validarCEP(cep)) {
                alert('Por favor, insira um CEP válido.');
                return;
            }

            // Enviar dados para o servidor via FormData
            const formData = new FormData();
            formData.append('address', rua);
            formData.append('number', numero);
            formData.append('complement', complemento);
            formData.append('neighborhood', bairro);
            formData.append('city', cidade);
            formData.append('state', estado);
            formData.append('zip_code', cep);

            try {
                const response = await fetch('update_address.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Atualizar exibição do endereço
                    let enderecoLinha1 = `${rua}, ${numero}`;
                    if (complemento) {
                        enderecoLinha1 += ` - ${complemento}`;
                    }

                    const enderecoLinha2 = `${cidade} - ${estado} - ${cep}`;

                    if (enderecoDisplay1) {
                        enderecoDisplay1.textContent = enderecoLinha1;
                    }
                    if (enderecoDisplay2) {
                        enderecoDisplay2.textContent = enderecoLinha2;
                    }

                    // Mostrar mensagem de sucesso
                    alert('Endereço atualizado com sucesso!');

                    // Fechar modal e limpar formulário
                    formularioEndereco.style.display = 'none';
                    formEndereco.reset();
                } else {
                    alert('Erro ao atualizar endereço: ' + (result.message || 'Erro desconhecido'));
                }
            } catch (error) {
                console.error('Erro ao enviar endereço:', error);
                alert('Erro ao atualizar endereço. Por favor, tente novamente.');
            }
        });
    }
});

// Função para limpar endereço salvo (pode ser útil para futuras funcionalidades)
function limparEnderecoSalvo() {
    localStorage.removeItem('endereco_usuario');
    if (enderecoDisplay1) {
        enderecoDisplay1.textContent = 'Rua Exemplo, 123 - complemento';
    }
    if (enderecoDisplay2) {
        enderecoDisplay2.textContent = 'Centro - Cidade/Estado - CEP';
    }
}

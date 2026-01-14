<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <div class="container">
        <div class="img-container">
            <div><img src="images/logo.png" alt="logo e-store solution"></div>
        </div>
        <h1>Criar conta</h1>
        <form action="register_process.php" method="post">
            <!-- ===== Dados pessoais ===== -->
            <div class="form-group">
                <!-- ===== nome ===== -->
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="name" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="phone" placeholder="(XX) XXXXX-XXXX" onkeyup="formatarTelefone(this)">
            </div>
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="XXX.XXX.XXX-XX">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="password" id="senha" placeholder="Crie uma senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar"></label>
                <input type="password" name="confirm_password" id="confirmar" placeholder="Confirme sua senha" required>
            </div>

            <!-- ===== Endereço ===== -->
            <h2>Endereço</h2>
            <div class="form-group">
                <label for="rua">Rua</label>
                <input type="text" id="rua" name="address" placeholder="Digite sua rua" required>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" id="numero" name="number" placeholder="Ex: 123" required>
                </div>
                <div class="form-group">
                    <label for="complemento">Complemento</label>
                    <input type="text" id="complemento" name="complement" placeholder="Apto, Bloco...">
                </div>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="neighborhood" placeholder="Digite seu bairro" required>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label for="Cidade">Cidade</label>
                    <input type="text" id="cidade" name="city" placeholder="Digite sua cidade" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="state" id="estado" required>
                        <option value="">Selecione</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="zip_code" placeholder="00000-000" required>
            </div>
            <button type="submit">Cadastrar</button>
        </form>
        <p id="mensagem-cadastro" class="mensagem">
            <?php
            if (isset($_GET["error"])) {
                echo htmlspecialchars($_GET["error"]);
            } elseif (isset($_GET["success"])) {
                echo htmlspecialchars($_GET["success"]);
            }
            ?>
        </p>
        <div class="link">
            <p>Já tem uma conta? <a href="login.php">Entrar</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="cadastro.js"></script>
</body>
</html>
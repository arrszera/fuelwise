<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include('../elements/head.php') ?>
    <title>Cadastro Transportadora</title>
<!-- fonte -->
</head>
<body>
    <?php include('../elements/header.php') ?>

    <?php
        if(isset($_GET['erro'])){
            echo("<script>alert('Preencha todos os campos.');</script>");
        }

    ?>
    <div class="form-div" id="form-div">
        <?php if (!isset($_GET["page"]) || $_GET["page"] == 1) {?>
            <form method="POST" action="cadastro_transportadora_php.php?page=1" class="form">
                <h3>Cadastro da Transportadora</h3>
                <small></small><br>
                <div class="form-group">
                    <label for="nomeTransportadora">Nome da Transportadora*</label>
                    <input name="nomeTransportadora" id="nomeTransportadora" type="text" class="form-control" id="exampleInputPassword1" placeholder="Nome da Transportadora">
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço*</label>
                    <input id="endereco" name="endereco" type="text" class="form-control" placeholder="Insira o endereço da transportadora">
                </div>
                <div class="form-group">
                    <label for="cnpj">CNPJ*</label>
                    <input id="cnpj" name="cnpj" type="text" class="form-control" aria-describedby="infoPage1" placeholder="Insira o CNPJ da transportadora">
                    <small id="infoPage1" class="form-text text-muted">Seus dados não serão compartilhados com terceiros.</small>
                </div>
                <button type="submit" class="btn btn-primary">Próxima página</button>
            </form>

        <?php } else if (isset($_GET["page"]) && $_GET["page"] == 2) { ?>
            <form method="POST" action="cadastro_transportadora_php.php?page=2" class="form">
                <h3>Cadastro de um gerente</h3>
                <small class="form-text text-muted">Mais gerentes poderão ser adicionados após o cadastro inicial.</small> <br>
                <div class="form-group">
                    <label for="nomeUsuario">Nome do usuário</label>
                    <input name="nomeUsuario" id="nomeUsuario" type="text" class="form-control" placeholder="Nome do usuário">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="text" class="form-control" placeholder="Insira seu endereço">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input name="telefone" type="text" class="form-control" placeholder="Insira o telefone">
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input name="cpf" type="text" class="form-control" placeholder="Insira seu CPF">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input id="senha" name="senha" type="password" class="form-control" placeholder="Insira sua senha">
                </div>
                <div class="form-group">
                    <label for="confirmarSenha">Confirmar sua senha</label>
                    <input id="confirmarSenha" name="confirmarSenha" type="password" class="form-control" placeholder="Confirme sua senha">
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        <?php } ?>

    </div>
    <!-- JS -->
    <script src="../js/index.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
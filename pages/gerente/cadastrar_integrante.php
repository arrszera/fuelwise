<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php 
        include('autenticacaoGerente.php');
        include('../../elements/head.php');
    ?>
    <link rel='stylesheet' href='../../css/login.css'>
    <link rel='stylesheet' href='../../css/header.css'>
    <title>Cadastro Funcionário</title>
<!-- fonte -->
</head>
<body>
    <?php include('../../elements/header.php') ?>

    <div class="form-div" id="form-div">
            <form method="POST" action="cadastrar_integrante_php.php?idtransportadora=<?php echo $_SESSION['idtransportadora'] ?>" class="form">
                <h3>Cadastro do Funcionário</h3>
                <small></small><br>
                <div class="form-group">
                    <label for="nome">Nome do Funcionário*</label>
                    <input name="nome" id="nome" type="text" class="form-control" id="exampleInputPassword1" placeholder="Nome do funcionário">
                </div>
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input id="email" name="email" type="text" class="form-control" placeholder="Insira o email do funcionário">
                </div>
                <div class="form-group">
                    <label for="senha">Senha*</label>
                    <input id="senha" name="senha" type="password" class="form-control" aria-describedby="infoPage1" placeholder="Insira a senha do funcionário">
                    <small id="infoPage1" class="form-text text-muted">Seus dados não serão compartilhados com terceiros.</small>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone*</label>
                    <input id="telefone" name="telefone" type="text" class="form-control" placeholder="Insira o telefone do funcionário">
                </div>
                <div class="form-group">
                    <label for="cpf">CPF*</label>
                    <input id="cpf" name="cpf" type="text" class="form-control" placeholder="Insira o CPF do funcionário">
                </div>
                <button type="submit" class="btn btn-primary">Cadastro</button>
            </form>

    </div>
    <!-- JS -->
    <script src="../../js/index.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
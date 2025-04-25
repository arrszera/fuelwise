<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php 
        include_once('../config.php');
        include(ROOT_PATH . '/elements/head.php'); 
    ?>
    <title>Login</title>
</head>
<body>
    <?php include(ROOT_PATH . '/elements/header.php') ?>

    <div class="form-div" id="form-div">
        <form method="POST" action="login_php.php" class="form">
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Insira seu Email">
                <small id="emailHelp" class="form-text text-muted">Seu Email não será compartilhado com terceiros.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Senha</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <!-- JS -->
    <script src="<?php ROOT_PATH ?>/js/index.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
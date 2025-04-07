<?php
    if (isset($_POST["email"]) && isset($_POST["password"])){
        include("../elements/connection.php");
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM usuario WHERE email = '".$email."' AND password = '".$password."'";

        if ($result = $conn->query($sql)->fetch_assoc()){
            $_SESSION["id"] = $result["id"];
            $_SESSION['role'] = $result['role']; // 0 = funcionario, 1 = gerente, 2 = posto, 3 ADM
            header('Location: index.php');
        } else {
            echo"<script>
                    alert('Essa senha não pertence a esse usuário')
                    window.location.href = 'login.php';
                </script>";
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include('../elements/head.php'); ?>
    <title>Login</title>
</head>
<body>
    <?php include('../elements/header.php') ?>

    <div class="form-div" id="form-div">
        <form method="POST" action="" class="form">
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
    <script src="../js/index.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
<?php
    if (isset($_POST["email"]) && isset($_POST["password"])){
        include_once('../config.php');
        include(ROOT_PATH . "/connection.php");
        $email = $_POST["email"];
        $password = $_POST["password"];
        $senha = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM usuario WHERE email = '".$email."' AND senha = '".$senha."'";
        
        if ($result = $conn->query($sql)->fetch_assoc()){
            $_SESSION["id"] = $result["id"];
            $_SESSION['adm'] = $result['adm'];
            $_SESSION['gerente'] = $result['gerente'];
            header('Location: '. ROOT_PATH .'/pages/index.php');
        } else {
            echo"<script>
                    alert('Essa senha não pertence a esse usuário')
                    window.location.href = '" . ROOT_PATH . "/pages/login.php';
                </script>";
            exit;
        }
    }
?>
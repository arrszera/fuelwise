<?php
session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    include("../elements/connection.php");

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $user = $result->fetch_assoc()) {
        if (password_verify($password, $user["senha"])) {
            $_SESSION["id"] = $user["idusuario"];
            $_SESSION["adm"] = $user["adm"];
            $_SESSION["gerente"] = $user["gerente"];

            $sql = "SELECT idtransportadora FROM transportadora_usuario WHERE idusuario = " . $_SESSION["id"];
            $result = $conn->query($sql);
            if ($result && $linha = $result->fetch_assoc()) {
                $_SESSION["idtransportadora"] = $linha["idtransportadora"];
            }

            header("Location: index.php");
            exit;
        } else {
            echo "<script>
                    alert('Senha incorreta para esse usuário.');
                    window.location.href = 'login.php';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Usuário não encontrado.');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
}
?>

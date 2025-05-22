<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    if (isset($_GET["precoCombustivel"])) {
        include("../../elements/connection.php");
        if (isset($_GET['idcombustivel'])){
            $sql = "UPDATE combustivel SET preco = " . $_GET['precoCombustivel'] . "WHERE idcombustivel = " .$_GET['idcombustivel'];
        // TODO cadastrar o posto
        } else {
            $tipoCombustivel = $_POST["tipoCombustivel"];
            $precoCombustivel = $_POST["precoCombustivel"];
            $sql = "INSERT INTO combustivel (idposto, tipo, preco) VALUES ('$idposto', '$tipoCombustivel', '$precoCombustivel')";
        }

        if ($conn->query($sql)) {
            header('Location: postos.php');
        } else {
            echo "<script>
                    alert('Erro na adição do combustível.');
                    window.location.href = 'postos.php';
                </script>";
            exit;
        }
    }
?>

<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    if (isset($_POST["tipoCombustivel"]) && isset($_POST["precoCombustivel"])) {
        include("../../elements/connection.php");
        $tipoCombustivel = $_POST["tipoCombustivel"];
        $precoCombustivel = $_POST["precoCombustivel"];
        $idposto = $_POST["idposto"];
        $nome = $_POST["nomeposto"];

        $check = "SELECT * FROM combustivel WHERE idposto = $idposto AND tipo = $tipoCombustivel";
        $resultado = $conn->query($check);

        if ($resultado->num_rows > 0) {
            $sql = "UPDATE combustivel SET preco = $precoCombustivel WHERE idposto = $idposto AND tipo = $tipoCombustivel";
        } else {
            $sql = "INSERT INTO combustivel (idposto, tipo, preco) VALUES ('$idposto', '$tipoCombustivel', '$precoCombustivel')";
        }

        if ($conn->query($sql)) {
            header('Location: posto_combustiveis.php?id=' . $idposto . '&nome=' . $nome);
        } else {
            echo "<script>
                    alert('Erro na adição do combustível.');
                    window.location.href = 'posto_combustiveis.php?id=' . $idposto;
                </script>";
            exit;
        }
    }
?>

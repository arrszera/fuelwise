<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    if (isset($_POST["nomePosto"]) && isset($_POST["enderecoPosto"])){
        include("../../elements/connection.php");
        $nomePosto = $_POST["nomePosto"];
        $enderecoPosto = $_POST["enderecoPosto"];
        if ($enderecoPosto > 100 || $nomePosto > 45){
            echo "<script>
                    alert('Limite de caracteres excedido.');
                    window.location.href = 'posto_alterar.php?idposto=".$_GET['id']".';
                </script>";
        }
        $sql = "INSERT INTO posto (nome, endereco) VALUES ('$nomePosto', '$enderecoPosto')";
        if ($result = $conn->query($sql)){
            header('Location: postos.php');
        } else {
            echo"<script>
                    alert('Erro na adição do posto.');
                    window.location.href = 'postos.php';
                </script>";
            exit;
        }
    }
?>
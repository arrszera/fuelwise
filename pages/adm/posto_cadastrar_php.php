<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    if (isset($_POST["nomePosto"]) && isset($_POST["enderecoPosto"])){
        include_once('../../config.php');
        include(ROOT_PATH . "/elements/connection.php");
        $nomePosto = $_POST["nomePosto"];
        $enderecoPosto = $_POST["enderecoPosto"];
        $sql = "INSERT INTO posto (nome, endereco) VALUES ('$nomePosto', '$enderecoPosto')";
        if ($result = $conn->query($sql)){
            header('Location: '. ROOT_PATH .'/postos.php');
        } else {
            echo"<script>
                    alert('Erro na adição do posto.');
                    window.location.href = 'postos.php';
                </script>";
            exit;
        }
    }
?>
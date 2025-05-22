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
        $sql = "INSERT INTO posto (nome, endereco) VALUES ('$nomePosto', '$enderecoPosto')";
        if ($result = $conn->query($sql)){
            header('Location: postos.php');
        } else {
            $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Posto adicionado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header("location: postos.php"); exit;
            exit;
        }
    }
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Preencha todos os campos.',
        'icon' => 'question', 
        'confirmButtonColor' => '#2563eb',
    ];
    header("location: postos.php"); exit;
?>
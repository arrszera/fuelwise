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
        $coordenadas = $_POST["coordenadasPosto"];
        list($latitude, $longitude) = explode(", ", $coordenadas);

        if (strlen($nomePosto) < 2 || strlen($nomePosto) > 45) {
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'O nome do posto deve ter entre 2 e 45 caracteres.',
                'icon' => 'warning',
                'confirmButtonColor' => '#2563eb',
            ];
            header("Location: postos.php");
            exit;
        }
        
        if (strlen($enderecoPosto) < 5 || strlen($enderecoPosto) > 100) {
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'Endereço inválido.',
                'icon' => 'warning',
                'confirmButtonColor' => '#2563eb',
            ];
            header("Location: postos.php");
            exit;
        }

        if ((!($latitude <= 90 && $latitude >= -90)) || (!($longitude <= 180 && $longitude >= -180))) {
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'Insira coordenadas válidas.',
                'icon' => 'warning',
                'confirmButtonColor' => '#2563eb',
            ];
            header("Location: postos.php");
            exit;
        }

        $sql = "INSERT INTO posto (nome, endereco, latitude, longitude) VALUES ('$nomePosto', '$enderecoPosto', $latitude, $longitude)";
        if ($result = $conn->query($sql)){
            $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Posto adicionado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: postos.php'); exit;
        } else {
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'Solicitação falhou.',
                'icon' => 'warning', 
                'confirmButtonColor' => '#2563eb',
            ];
            header("location: postos.php"); exit;
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
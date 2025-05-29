<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    
    // TODO verificacoes

    $nomePosto = trim($_POST["nomePosto"]);
    $enderecoPosto = trim($_POST["enderecoPosto"]);
    $coordenadas = trim($_POST["coordenadasPosto"]);
    
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
    
    if (strlen($enderecoPosto) < 7 || strlen($enderecoPosto) > 100) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Endereço inválido.',
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: postos.php");
        exit;
    }
    
    list($latitude, $longitude) = explode(", ", $coordenadas);
    $sql = "INSERT INTO posto (nome, endereco, latitude, longitude) VALUES ('$nomePosto', '$enderecoPosto', $latitude, $longitude)";
// ...restante do código
    header("location: postos.php"); exit;
?>
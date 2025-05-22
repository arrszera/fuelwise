<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }

    // TODO verificacoes

    // dedicada a atualizacao
    include("../../elements/connection.php");
    if (isset($_GET["precoCombustivel"])) {

        if (isset($_GET['idcombustivel'])){
            $sql = "UPDATE combustivel SET preco = " . $_GET['precoCombustivel'] . "WHERE idcombustivel = " .$_GET['idcombustivel'];
        }

        if ($conn->query($sql)) {
             $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Combustível alterado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: postos.php'); exit;
        } else {
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'Algo deu errado.',
                'icon' => 'warning', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: postos.php'); exit;
        }
    }
    // dedicada ao cadastro
    if (isset($_POST['idposto'])){
        $idposto = $_POST["idposto"];
        $precoCombustivel = $_POST["precoCombustivel"];
        $tipoCombustivel = $_POST["tipoCombustivel"];
        
        $sql = "SELECT * FROM posto p 
                JOIN combustivel c ON p.idposto = c.idposto 
                WHERE p.idposto = $idposto AND c.tipo = $tipoCombustivel";

        if (!($result = $conn->query($sql))){
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'Erro na atualização do banco de dados.',
                'icon' => 'warning', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: postos.php'); exit;
        }
        if ($result->num_rows > 0){
            $sql = "UPDATE combustivel 
                    SET preco = $precoCombustivel 
                    WHERE idposto = $idposto AND tipo = $tipoCombustivel";
        } else {
            $sql = "INSERT INTO combustivel (idposto, preco, tipo) 
                    VALUES ($idposto, $precoCombustivel, $tipoCombustivel)";        
        }
         if ($result = $conn->query($sql)){
            $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Cadastro realizado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: postos.php'); exit;
         }
    }
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Algo deu errado.',
        'icon' => 'warning', 
        'confirmButtonColor' => '#2563eb',
    ];
    header('Location: postos.php'); exit;
?>

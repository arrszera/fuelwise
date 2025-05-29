<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include("../../elements/connection.php");

    // TODO verificacoes
    if (isset($_POST['idposto'])){
        $nomePosto = $_POST['nomePosto'];
        $enderecoPosto = $_POST['enderecoPosto'];
        $coordenadas = $_POST['coordenadasPosto'];
        list($latitude, $longitude) = explode(", ", $coordenadas);
        $latitude = (float) $latitude;
        $longitude = (float) $longitude;
        

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
        $sql = "UPDATE posto SET nome = '$nomePosto', endereco = '$enderecoPosto', latitude = $latitude, longitude = $longitude WHERE idposto = ".$_POST['idposto'];
        if ($result = $conn->query($sql)){
            $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Posto alterado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: postos.php'); exit;
        }
    } else {
        $_SESSION['alert'] = [
			'title' => 'Erro!',
			'text' => 'Algo deu errado.',
			'icon' => 'warning', 
			'confirmButtonColor' => '#2563eb',
		];
        header('Location: postos.php'); exit;
    }
?>

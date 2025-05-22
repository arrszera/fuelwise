<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include("../../elements/connection.php");

    // TODO verificacoes
    if (isset($_POST['idposto'])){
        $sql = "UPDATE posto SET nome = '".$_POST['nomePosto']."', endereco = '".$_POST['enderecoPosto']."' WHERE idposto = ".$_POST['idposto'];
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

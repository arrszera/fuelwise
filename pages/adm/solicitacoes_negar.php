<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['id'])){
		include('../../elements/connection.php');

		$query = "UPDATE solicitacao SET status = 2 WHERE idsolicitacao = ".$_GET['id'];
		$resultado = $conn->query($query);
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Status de solicitação alterada com sucesso!',
			'icon' => 'success'
		];
		header("location: solicitacoes.php");
	}else{
		echo "Algo deu errado."; 
	}
?>
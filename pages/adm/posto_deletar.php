<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['id'])){
		include('../../elements/connection.php');
		$id = (int)$_GET['id'];
		
		$query = "DELETE FROM combustivel WHERE idposto = $id";
		$conn->query($query);
		
		$query = "DELETE FROM posto WHERE idposto = $id";
		$conn->query($query);

		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Posto excluído com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];

		header("location: postos_v2.php");
	}else{
		echo "Algo deu errado."; 
	}
?>
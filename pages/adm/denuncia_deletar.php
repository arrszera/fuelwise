<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['iddenuncia'])){
		include('../../elements/connection.php');
		$query = "DELETE FROM anexos WHERE iddenuncia = ".$_GET['iddenuncia'];
		$resultado = $conn->query($query);
		$query = "DELETE FROM denuncia WHERE iddenuncia = ".$_GET['iddenuncia'];
		$resultado = $conn->query($query);

		 $_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Denúncia deletada com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];

		header('Location: denuncias.php');
	}else{
		echo "Algo deu errado."; 
	}
?>
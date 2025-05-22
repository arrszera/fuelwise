<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['idcombustivel'])){
		include('../../elements/connection.php');
		$query = "DELETE FROM combustivel WHERE idcombustivel = ".$_GET['idcombustivel'];
		$resultado = $conn->query($query);

		 $_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Combustível deletado com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];

		header('Location: postos.php');
	}else{
		echo "Algo deu errado."; 
	}
?>
<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['id'])){
		include('../../elements/connection.php');
		$query = "DELETE FROM posto WHERE idposto = ".$_GET['id'];
		$resultado = $conn->query($query);
		header("location: postos.php");
	}else{
		echo "Algo deu errado."; 
	}
?>
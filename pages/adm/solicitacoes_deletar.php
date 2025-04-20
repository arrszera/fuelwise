<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['id'])){
		include('../../elements/connection.php');
		$query = "DELETE FROM solicitacao WHERE idsolicitacao = ".$_GET['id'];
		$resultado = $conn->query($query);
		header("location: solicitacoes.php");
	}else{
		echo "Algo deu errado."; 
	}
?>
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
		$idposto = $_GET["idposto"];
        $nome = $_GET["nomeposto"];

		header('Location: posto_combustiveis.php?id='.$idposto.'&nome='.$nome);
	}else{
		echo "Algo deu errado."; 
	}
?>
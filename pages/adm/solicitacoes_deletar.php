<?php
	if(isset($_GET['id'])){
		include('../../elements/connection.php');
		$query = "DELETE FROM tb_solicitacao WHERE idsolicitacao = ".$_GET['id'];
		$resultado = $conn->query($query);
		header("location:../index.php");
	}else{
		echo "Algo deu errado.";
	}
?>
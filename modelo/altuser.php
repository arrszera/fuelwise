<?php

	if(isset($_GET['id'])){
		$obj = conecta_db();
		$role = $_GET["gerente"] == 1 ?  0 : 1;
		$query = "UPDATE tb_usuario
		SET gerente = " . $role . "
		WHERE id_usuario = ".$_GET['id'];
		$resultado = $obj->query($query);
		header("location:index.php");
	}else{
		echo "Algo deu errado.";
	}
#	codigo para tornar adm
?>	


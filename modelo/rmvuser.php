<?php
	if(isset($_GET['id'])){
		$obj = conecta_db();
		$query = "DELETE FROM tb_usuario WHERE id_usuario = ".$_GET['id'];
		$resultado = $obj->query($query);
		header("location:index.php");
	}else{
		echo "Algo deu errado.";
		#	codigo para excluir usuario
	}
?>	


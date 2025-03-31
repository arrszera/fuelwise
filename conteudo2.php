<?php
	if(isset($_GET['id'])){
		$obj = conecta_db();
		$query = "DELETE FROM tb_transportadora WHERE id_transp = ".$_GET['id'];
		$resultado = $obj->query($query);
		header("location:index.php");
	}else{
		echo "Algo deu errado.";
	}
#	codigo para excluir uma transportadora
?>	

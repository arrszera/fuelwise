<?php
	function debug($var){
		echo "<pre>";
		var_dump($var);
		echo"</pre>";
		
	}
	
	include 'conecta_db.php';
	$conexao = conecta_db();
	// debug($conexao);
?>
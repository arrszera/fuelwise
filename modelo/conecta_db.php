<?php

	function conecta_db() {
	$db_name = "db_fuelwise";
	$user = "root";
	$pass = "";
	$server = "localhost:3307";	
	$conexao = new mysqli($server, $user, $pass, $db_name);
	return $conexao;
	}
	
?>
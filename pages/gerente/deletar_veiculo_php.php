<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idveiculo']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');
		$query = "DELETE FROM veiculo WHERE idveiculo = ".$_GET['idveiculo'];
		$resultado = $conn->query($query);
		header("location: veiculos.php?idtransportadora=".$_SESSION['idtransportadora']);
	}else{
		echo "Algo deu errado."; 
	}
?>
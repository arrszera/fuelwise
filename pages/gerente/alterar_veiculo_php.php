<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idveiculo']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');
		$sql = "UPDATE veiculo SET placa = '".$_POST['placa']."', modelo = '".$_POST['modelo']."', eixos = ".$_POST['eixos'].", observacao = '".$_POST['observacao']."' WHERE idveiculo =  ".$_GET['idveiculo'];
        if (!$result = $conn->query($sql)){
            echo 'Erro na atualização';
            exit;
        }
		header("location: veiculos.php?idtransportadora=".$_GET['idtransportadora']);
	}else{
		echo "Algo deu errado."; 
	}
?>
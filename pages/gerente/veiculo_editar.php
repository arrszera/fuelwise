<?php
    include('autenticacaoGerente.php');
	// echo var_dump($_POST); exit;
	// TODO verificacoes
	if(isset($_POST['idveiculo']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

		$sql = "UPDATE veiculo SET placa = '".$_POST['placa']."', modelo = '".$_POST['modelo']."', eixos = '".$_POST['eixos']."', litragem = '".$_POST['litragem']."', observacao = '".$_POST['observacao']."' WHERE idveiculo = ".$_POST['idveiculo'];
        if (!$result = $conn->query($sql)){
            $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Algo deu errado.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: veiculos.php?idtransportadora=".$_GET['idtransportadora']); exit;
        }
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Veículo alterado com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: veiculos.php?idtransportadora=".$_GET['idtransportadora']);
	}else{
		echo "Algo deu errado."; 
	}
?>
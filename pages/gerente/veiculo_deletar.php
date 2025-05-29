<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idveiculo']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

		$tabelas = ["viagem", "veiculo"];

		foreach ($tabelas as $tabela){
			$query = "DELETE FROM $tabela WHERE idveiculo = ".$_GET['idveiculo'];
			$conn->query($query);
		}
		
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Veículo excluido com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: veiculos.php?idtransportadora=".$_SESSION['idtransportadora']);
	}else{
		$_SESSION['alert'] = [
			'title' => 'Erro!',
			'text' => 'Algo deu errado.',
			'icon' => 'warning', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: veiculos.php?idtransportadora=".$_SESSION['idtransportadora']);
	}
?>
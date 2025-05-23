<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idviagem']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

			$query = "DELETE FROM viagem WHERE idviagem = ".$_GET['idviagem'];
			$conn->query($query);
		
		
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Viagem excluido com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']);
	}else{
		$_SESSION['alert'] = [
			'title' => 'Erro!',
			'text' => 'Algo deu errado.',
			'icon' => 'warning', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']);
	}
?>
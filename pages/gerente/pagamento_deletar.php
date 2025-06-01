<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idpagamento']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

        $query = "DELETE FROM pagamento WHERE idpagamento = ".$_GET['idpagamento'];
        $conn->query($query);
		
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Pagamento excluido com sucesso.',
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
<?php
    include('autenticacaoGerente.php');
	// echo var_dump($_POST); exit;

	// TODO verificacoes de placa
	if(isset($_POST['idviagem']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

		$sql = "UPDATE viagem SET idusuario = '".$_POST['idusuario']."', peso = '".$_POST['peso']."', obs = '".$_POST['obs']."', data_inicio = '".$_POST['data_inicio']."', data_termino ='".$_POST['data_termino']."' WHERE idviagem = ".$_POST['idviagem'];
        if (!$result = $conn->query($sql)){
            $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Algo deu errado.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: viagens.php?idtransportadora=".$_GET['idtransportadora']); exit;
        }
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Viagem alterada com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: viagens.php?idtransportadora=".$_GET['idtransportadora']);
	}else{
		echo "Algo deu errado."; 
	}
?>
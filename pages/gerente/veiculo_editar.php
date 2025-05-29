<?php
    include('autenticacaoGerente.php');

	function redirecionarComErro($titulo, $mensagem, $idtransportadora) {
		$_SESSION['alert'] = [
			'title' => $titulo,
			'text' => $mensagem,
			'icon' => 'warning',
			'confirmButtonColor' => '#2563eb',
		];
		header("location: veiculos.php?idtransportadora=$idtransportadora");
		exit;
	}

	if(isset($_POST['idveiculo']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

		$placa = strtoupper(trim($_POST['placa']));
		$modelo = trim($_POST['modelo']);
		$eixos = trim($_POST['eixos']);
		$litragem = trim($_POST['litragem']);
		$observacao = trim($_POST['observacao']);
		$idveiculo = intval($_POST['idveiculo']);
		$idtransportadora = intval($_GET['idtransportadora']);

		if (strlen($placa) != 7 || !preg_match('/^[A-Z0-9]{7}$/', $placa)) {
        	redirecionarComErro('Placa inválida', 'A placa deve conter exatamente 7 caracteres alfanuméricos.', $idtransportadora);
		}

		if (strlen($modelo) < 3 || strlen($modelo) > 45) {
			redirecionarComErro('Modelo inválido', 'O modelo deve conter de 3 a 45 caracteres.', $idtransportadora);
		}

		if (!preg_match('/^\d{1,2}$/', $eixos)) {
			redirecionarComErro('Eixos inválidos', 'O número de eixos deve conter até 2 dígitos.', $idtransportadora);
		}

		if (!is_numeric($litragem) || $litragem <= 0) {
			redirecionarComErro('Litragem inválida', 'Informe um valor de litragem numérico maior que zero.', $idtransportadora);
		}

		$sql = "SELECT * FROM veiculo WHERE placa = '$placa' AND idveiculo != $idveiculo";

		$result = $conn->query($sql);
		if ($result->num_rows > 0){
            $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Essa placa já foi registrada para outro veículo.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: veiculos.php?idtransportadora=".$_GET['idtransportadora']); exit;
        }

		$sql = "UPDATE veiculo SET placa = '$placa', modelo = '".$_POST['modelo']."', eixos = '".$_POST['eixos']."', litragem = '".$_POST['litragem']."', observacao = '".$_POST['observacao']."' WHERE idveiculo = $idveiculo";
        
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
<?php
    include('autenticacaoGerente.php');

	function validarCPF($cpf){
		if (strlen($cpf) !== 11) {
			return false;
		}

		if (preg_match('/(\d)\1{10}/', $cpf)) {
			return false;
		}

		for ($t = 9; $t < 11; $t++) {
			$soma = 0;
			for ($i = 0; $i < $t; $i++) {
				$soma += $cpf[$i] * (($t + 1) - $i);
			}
			$digito = (10 * $soma) % 11;
			$digito = ($digito == 10) ? 0 : $digito;

			if ($cpf[$t] != $digito) {
				return false;
			}
		}

		return true;
	}

	if(isset($_POST['idusuario']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');
		
		$cpf = preg_replace('/\D/', '', $_POST["cpf"]);
		$email = $_POST['email'];
		$idusuario = (int)$_POST['idusuario'];

		if (!validarCPF($cpf)) {
			$_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Esse CPF é inválido.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
			header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
		}

		$result = $conn->query("SELECT * FROM usuario WHERE (cpf = '$cpf' OR email='$email') AND idusuario != $idusuario");

		if ($result && $result->num_rows > 0) {
			$_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Esse CPF ou E-mail já foi registrado em outro perfil.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
			header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
		}

		$sql = "UPDATE usuario SET nome = '".$_POST['nome_usuario']."', email = '$email', cpf = '$cpf', telefone = '".$_POST['telefone_usuario']."' WHERE idusuario = $idusuario";
        if (!$result = $conn->query($sql)){
            $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Algo deu errado.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: integrantes.php?idtransportadora=".$_GET['idtransportadora']); exit;
        }
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Usuário alterado com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: integrantes.php?idtransportadora=".$_GET['idtransportadora']);
	}else{
		echo "Algo deu errado."; 
	}
?>
<?php
    include('autenticacaoGerente.php');

	// TODO contra SQL injection

	if(isset($_POST['idusuario']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');
		
		$cpf = $_POST['cpf'];
		$email = $_POST['email'];
		$idusuario = $_POST['idusuario'];

		$result = $conn->query("SELECT * FROM usuario WHERE cpf = '$cpf' OR email='$email' AND idusuario != $idusuario");

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
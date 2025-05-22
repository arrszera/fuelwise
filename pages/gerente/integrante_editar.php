<?php
    include('autenticacaoGerente.php');
	// echo var_dump($_POST); exit;
	// TODO verificacoes
	if(isset($_POST['idusuario']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

		
		// TODO arrumar uma forma de verificar se o valor passado eh igual ao valor atual, para que nao acuse erro se o usuario escolher nao mudar o campo
		
		// $cpf = $_POST['cpf'];
		// $email = $_POST['email'];

		// $result = $conn->query("SELECT * FROM usuario WHERE cpf = '$cpf' OR email='$email'");

		// if ($result && $result->num_rows > 0) {
		// 	$_SESSION['alert'] = [
		// 		'title' => 'Erro!',
		// 		'text' => 'Esse CPF ou E-mail já foi registrado.',
		// 		'icon' => 'warning', 
		// 		'confirmButtonColor' => '#2563eb',
		// 	];
		// 	header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
		// }

		$sql = "UPDATE usuario SET nome = '".$_POST['nome_usuario']."', email = '".$_POST['email']."', cpf = '".$_POST['cpf']."', telefone = '".$_POST['telefone_usuario']."' WHERE idusuario = ".$_POST['idusuario'];
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
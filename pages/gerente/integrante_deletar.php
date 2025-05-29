<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idusuario']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');

		$idusuario = $_GET['idusuario'];

		$sql = "DELETE FROM anexos WHERE iddenuncia IN (SELECT iddenuncia FROM denuncia WHERE idusuario = $idusuario)";
		$conn->query($sql);

		$tabelas = ["transportadora_usuario", "viagem", "denuncia", "usuario"]; 

		foreach ($tabelas as $tabela){
			$query = "DELETE FROM $tabela WHERE idusuario = $idusuario";
			$conn->query($query);
		}
		
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Usuário excluido com sucesso.',
			'icon' => 'success', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']);
	}else{
		$_SESSION['alert'] = [
			'title' => 'Erro!',
			'text' => 'Algo deu errado.',
			'icon' => 'warning', 
			'confirmButtonColor' => '#2563eb',
		];
		header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']);
	}
?>
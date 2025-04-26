<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idusuario']) && isset($_GET['idtransportadora'])){
        if ($_GET['idusuario'] == $_SESSION['id']){
            echo 'Você não pode excluir o próprio perfil';
            exit;
        }
		include('../../elements/connection.php');
		$query = "DELETE FROM transportadora_usuario WHERE idusuario = ".$_GET['idusuario'];
		$resultado = $conn->query($query);
		header("location: integrantes.php");
	}else{
		echo "Algo deu errado."; 
	}

    // -----REMOVE APENAS A RELACAO COM A TRANSPORTADORA, O PERFIL É MANTIDO POR MOTIVOS DE SEGURANÇA E HISTÓRICO DE VIAGENS
?>
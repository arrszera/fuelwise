<?php
    include('autenticacaoGerente.php');

	if(isset($_GET['idusuario']) && isset($_GET['idtransportadora'])){
		include('../../elements/connection.php');
		if ($_POST['nome'] > 90 || $_POST['email'] > 255 || $_POST['telefone'] > 45 || $_POST['cpf'] > 11){
            echo "<script>
                    alert('Limite de caracteres excedido.');
                    window.location.href = 'index.php';
                </script>";
        }
		$sql = "UPDATE usuario SET nome = '".$_POST['nome']."', email = '".$_POST['email']."', cpf = '".$_POST['cpf']."' WHERE idusuario = ".$_GET['idusuario'];
        if (!$result = $conn->query($sql)){
            echo 'Erro na atualização';
            exit;
        }
		header("location: integrantes.php?idtransportadora=".$_GET['idtransportadora']);
	}else{
		echo "Algo deu errado."; 
	}
?>
<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['id'])){
		include('../../elements/connection.php');
		$query = "SELECT * FROM solicitacao WHERE idsolicitacao = ".$_GET['id'];
        $resultado = $conn->query($query);
        $linha = $resultado->fetch_object();
		$query = "INSERT INTO usuario(email, nome, senha, telefone, cpf, gerente) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $status = 1;
        $stmt->bind_param("sssssi", $linha->emailUsuario, $linha->nomeUsuario, $linha->senha, $linha->telefone, $linha->cpf, $status);
        if ($stmt->execute()){
            $idusuario = $conn->insert_id;
            $query = "INSERT INTO transportadora(nome, endereco, cnpj) VALUES(?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $linha->nomeTransportadora, $linha->endereco, $linha->cnpj);
            if ($stmt->execute()){
                $idtransportadora = $conn->insert_id;
                $query = "INSERT INTO transportadora_usuario(idusuario, idtransportadora, datalogin) VALUES(?, ?, ?)";
                $stmt = $conn->prepare($query);
                $data = date('Y-m-d');
                $stmt->bind_param("iis", $idusuario, $idtransportadora, $data);
                if ($stmt->execute()) {
                    $query = "DELETE FROM solicitacao WHERE idsolicitacao = ".$_GET['id'];
                    if ($resultado = $conn->query($query)){
                        header("location: solicitacoes.php");
                    }
                    else  
                        echo "Solicitação aceita, algo deu errado na exclusão da solicitação.";
                }
            } else {
                echo "Algo deu errado na inclusão da transportadora";
            } 
        }
	}else{
		echo "Algo deu errado.";
	}
?>
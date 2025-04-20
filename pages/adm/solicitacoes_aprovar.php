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
		$query = "INSERT INTO usuario(email, nome, senha, telefone, cpf ) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $linha->emailUsuario, $linha->nomeUsuario, $linha->senha, $linha->telefone, $linha->cpf);
        if ($stmt->execute()){
            $query = "INSERT INTO transportadora(nome, endereco, cnpj) VALUES(?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $linha->nomeTransportadora, $linha->endereco, $linha->cnpj);
            if ($stmt->execute()){
                $query = "DELETE FROM solicitacao WHERE idsolicitacao = ".$_GET['id'];
                if ($resultado = $conn->query($query))
                    header("location: solicitacoes.php");
                else  
                    echo "Solicitação aceita, algo deu errado na exclusão da solicitação.";
            } else {
                echo "Algo deu errado na inclusão da transportadora";
            }
        }
	}else{
		echo "Algo deu errado.";
	}
?>
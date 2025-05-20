<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['id'])){
		include('../../elements/connection.php');
        
        // Verificacoes para existencia de cpf e cnpj previamente
        //TODO
        // $sql = "
		// 	SELECT cnpj, cpf 
		// 	FROM solicitacao 
		// 	WHERE idsolicitacao = ".$_GET['id'];
		// if ($resultado = $conn->query($sql)) {
            // if (!empty($row['cnpj'])) {
            //     $_SESSION['alert'] = [
            //         'title' => 'Erro!',
            // 		'text' => 'Este CNPJ já foi registrado!',
            // 		'icon' => 'warning'
            // 	];
            // 	header("Location: solicitacoes.php");
            // 	exit;
            // }
            // if (!empty($row['cpf'])){
            // 	$_SESSION['alert'] = [
            // 		'title' => 'Erro!',
            // 		'text' => 'Este CPF já foi registrado!',
            // 		'icon' => 'warning'
            // 	];
            // 	header("Location: solicitacoes.php");
            // 	exit;
            // }
        // }
	
		$query = "SELECT * FROM solicitacao WHERE idsolicitacao = ".$_GET['id'];
        $resultado = $conn->query($query);
        $linha = $resultado->fetch_object();
		$query = "INSERT INTO usuario(email, nome, senha, telefone, cpf, gerente) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $status = 1;
        $stmt->bind_param("sssssi", $linha->emailUsuario, $linha->nomeUsuario, $linha->senha, $linha->telefoneUsuario, $linha->cpf, $status);
        if ($stmt->execute()){
            $idusuario = $conn->insert_id;
            $query = "INSERT INTO transportadora(nome, endereco, cidade, estado, cep, cnpj) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $linha->nomeTransportadora, $linha->endereco, $linha->cidade, $linha->estado, $linha->cep, $linha->cnpj);
            if ($stmt->execute()){
                $idtransportadora = $conn->insert_id;
                $query = "INSERT INTO transportadora_usuario(idusuario, idtransportadora, datalogin) VALUES(?, ?, ?)";
                $stmt = $conn->prepare($query);
                $data = date('Y-m-d');
                $stmt->bind_param("iis", $idusuario, $idtransportadora, $data);
                if ($stmt->execute()) {
                    $query = "UPDATE solicitacao SET status = 1 WHERE idsolicitacao = ".$_GET['id'];
                    if ($resultado = $conn->query($query)){
                        $_SESSION['alert'] = [
                            'title' => 'Sucesso!',
                            'text' => 'Solicitação aprovada com sucesso.',
                            'icon' => 'success', 
                            'confirmButtonColor' => '#2563eb',
                        ];
                        header("location: solicitacoes.php"); exit;
                    }
                    else  
                        echo "Solicitação aceita, algo deu errado na exclusão da solicitação.";
                }
            } else {
                echo "Algo deu errado na inclusão da transportadora";
            } 
        }
	}else{
		$_SESSION['alert'] = [
            'title' => 'Algo deu errado!',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: solicitacoes.php");
}
?>
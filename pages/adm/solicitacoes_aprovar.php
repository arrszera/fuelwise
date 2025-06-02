<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        $sql = "
            SELECT idtransportadora 
            FROM transportadora 
            WHERE cnpj = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $linha->cnpj);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $_SESSION['alert'] = [
                    'title' => 'Erro!',
                    'text' => 'Este CNPJ já está registrado em outra transportadora.',
                    'icon' => 'warning',
                    'confirmButtonColor' => '#2563eb',
                ];
                header("Location: solicitacoes.php"); 
                exit;
            }
            $stmt->close();
        }

        $sql = "
            SELECT idusuario 
            FROM usuario 
            WHERE cpf = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $linha->cpf);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $_SESSION['alert'] = [
                    'title' => 'Erro!',
                    'text' => 'Este CPF já está registrado em outro usuário.',
                    'icon' => 'warning',
                    'confirmButtonColor' => '#2563eb',
                ];
                header("Location: solicitacoes.php"); 
                exit;
            }
            $stmt->close();
        }

		$query = "INSERT INTO usuario(email, nome, senha, telefone, cpf, gerente) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $status = 1;
        $stmt->bind_param("sssssi", $linha->emailUsuario, $linha->nomeUsuario, $linha->senha, $linha->telefoneUsuario, $linha->cpf, $status);
        
        if ($stmt->execute()){
            $idusuario = $conn->insert_id;

            $query = "INSERT INTO transportadora(nome, endereco, cidade, estado, cep, cnpj, dataCriacao) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $agora = $now->format('Y-m-d H:i:s');
            $stmt->bind_param("sssssss", $linha->nomeTransportadora, $linha->endereco, $linha->cidade, $linha->estado, $linha->cep, $linha->cnpj, $agora);

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
                    } else {
                        echo "Solicitação aceita, algo deu errado na exclusão da solicitação.";
                    }
                }
            } else {
                echo "Algo deu errado na inclusão da transportadora";
            } 
        }
	} else {
		$_SESSION['alert'] = [
            'title' => 'Algo deu errado!',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: solicitacoes.php");
	}
?>

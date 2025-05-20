<?php
	session_start(); 
	if (!($_SESSION['role'] == 3)){
	    header('Location: ../index.php');
	    exit;
	}
	if(isset($_GET['id'])){
		include('../../elements/connection.php');

		$sql = "
			SELECT status 
			FROM solicitacao 
			WHERE idsolicitacao = ".$_GET['id'];

		if ($resultado = $conn->query($sql)) {
			if ($row = $resultado->fetch_assoc()) {
				if ($row['status'] == 1) {
					excluirTransportadora($_GET['id']);
					header("location: solicitacoes.php");
				}
			}
		}
		$query = "UPDATE solicitacao SET status = 2 WHERE idsolicitacao = ".$_GET['id'];
		$resultado = $conn->query($query);
		$_SESSION['alert'] = [
			'title' => 'Sucesso!',
			'text' => 'Status de solicitação alterada com sucesso!',
			'icon' => 'success',
			'confirmButtonColor' => '#2563eb',
		];
		header("location: solicitacoes.php");
	}else{
		echo "Algo deu errado."; 
	}

function excluirTransportadora($idsolicitacao) {
    global $conn; // Conexão com o banco de dados

    $sql = "SELECT cnpj FROM solicitacao WHERE idsolicitacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idsolicitacao);
    $stmt->execute();
    $stmt->bind_result($cnpj);
    $stmt->fetch();
    $stmt->close();

    if ($cnpj) {

        // Excluir veiculos associados à transportadora
        $sql = "DELETE FROM veiculo WHERE idtransportadora IN (SELECT idtransportadora FROM transportadora WHERE cnpj = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cnpj);
        $stmt->execute();
        $stmt->close();

        // Excluir registros na tabela transportadora_usuario
        $sql = "DELETE FROM transportadora_usuario WHERE idtransportadora IN (SELECT idtransportadora FROM transportadora WHERE cnpj = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cnpj);
        $stmt->execute();
        $stmt->close();

		$sql = "DELETE FROM usuario WHERE idusuario IN (SELECT idusuario FROM transportadora_usuario WHERE idtransportadora IN (SELECT idtransportadora FROM transportadora WHERE cnpj = ?))";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cnpj);
        $stmt->execute();
        $stmt->close();

        // Excluir o registro da transportadora
        $sql = "DELETE FROM transportadora WHERE cnpj = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cnpj);
        $stmt->execute();
        $stmt->close();
    }
}

?>
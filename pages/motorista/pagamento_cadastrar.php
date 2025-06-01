<?php
include('autenticarMotorista.php');

if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) 
    && $_GET['idtransportadora'] == $_SESSION['idtransportadora']) {

    include("../../elements/connection.php");

    $idusuario = $_POST["idusuario"];
    $idposto = $_POST["postoSelecionado"];
    $idviagem = $_POST["idviagem"];
    $litragem = $_POST["litragem"];
    $valor = $_POST["valor"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $destinatario = $_POST["destinatarioLidoInput"];
    $idtransportadora = $_GET["idtransportadora"];
    $distanciaPercorrida = $_POST['distanciaPercorrida'];

    $query = 'SELECT cpf FROM usuario WHERE idusuario = ' . $idusuario;
    $cpf = $conn->query($query)->fetch_object()->cpf;

    $queryVeiculo = "SELECT idveiculo FROM viagem WHERE idviagem = $idviagem";
    $resultVeiculo = $conn->query($queryVeiculo);
    if (!$resultVeiculo || $resultVeiculo->num_rows === 0) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Viagem não encontrada.',
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
    }
    $idveiculo = $resultVeiculo->fetch_object()->idveiculo;

    // verificar se a litragem enviada esta dentro da litragem maxima do veiculo
    $queryLitragem = "SELECT litragem FROM veiculo WHERE idveiculo = $idveiculo";
    $litragemMaxima = $conn->query($queryLitragem)->fetch_object()->litragem;

    if ($litragem > $litragemMaxima) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'A litragem informada excede a capacidade do veículo.',
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
    }

    $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $dataPagamento = $now->format('Y-m-d H:i:s');

    $sql = "INSERT INTO pagamento (idtransportadora, idusuario, idposto, idviagem, litragem, valor, destinatario, cpfPagador, latitudePagamento, longitudePagamento, dataPagamento, distanciaPercorrida) 
            VALUES ('$idtransportadora', '$idusuario', '$idposto', '$idviagem', '$litragem', '$valor', '$destinatario', '$cpf', $latitude, $longitude, '$dataPagamento', $distanciaPercorrida)";

    if ($conn->query($sql)) {
        $_SESSION['alert'] = [
            'title' => 'Sucesso!',
            'text' => 'Pagamento cadastrado com sucesso.',
            'icon' => 'success',
            'confirmButtonColor' => '#2563eb',
        ];
        header('Location: index.php?idtransportadora=' . $_SESSION['idtransportadora']);
        exit;
    } else {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Algo deu errado ao salvar o pagamento.',
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
    }
}
?>

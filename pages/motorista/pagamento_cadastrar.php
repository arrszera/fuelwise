<?php
session_start();

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

    $query = 'SELECT cpf FROM usuario WHERE idusuario = ' . $idusuario;
    $cpf = $conn->query($query)->fetch_object()->cpf;

    $sql = "INSERT INTO pagamento (idtransportadora, idusuario, idposto, idviagem, litragem, valor, destinatario, cpfPagador, latitudePagamento, longitudePagamento) 
            VALUES ('$idtransportadora', '$idusuario', '$idposto', '$idviagem', '$litragem', '$valor', '$destinatario', '$cpf', $latitude, $longitude)";

    if ($conn->query($sql)) {
        $idveiculo = $conn->insert_id;
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
            'text' => 'Algo deu errado.',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: index.php?idtransportadora=".$_SESSION['idtransportadora']); 
        exit;
    }
//
    exit;
}
?>

<?php
include('autenticacaoGerente.php');

if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) 
    && $_SESSION['gerente'] == 1 && $_GET['idtransportadora'] == $_SESSION['idtransportadora']) {

    include("../../elements/connection.php");

    $idusuario = $_POST["idusuario"];
    $idveiculo = $_POST["idveiculo"];
    $carga = $_POST["carga"];
    $peso = $_POST["peso"];
    $obs = $_POST["obs"];
    $data_inicio = $_POST["data_inicio"];
    $enderecoOrigem = $_POST["enderecoOrigem"];
    $coordenadasOrigem = $_POST["coordenadasOrigem"];
    list($latitudeOrigem, $longitudeOrigem) = explode(", ", $coordenadasOrigem);
    $enderecoDestino = $_POST["enderecoDestino"];
    $coordenadasDestino = $_POST["coordenadasDestino"];
    list($latitudeDestino, $longitudeDestino) = explode(", ", $coordenadasDestino);
    $idtransportadora = $_GET["idtransportadora"];

    $result = $conn->query("SELECT * FROM viagem WHERE idveiculo = '$idveiculo'");

    if ($result && $result->num_rows > 0) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Esse veículo já esta em uso!',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

    $sql = "INSERT INTO viagem (
                idusuario, 
                idveiculo, 
                carga, 
                peso, 
                obs, 
                data_inicio, 
                endereco_origem, 
                latitude_origem, 
                longitude_origem, 
                endereco_destino, 
                latitude_destino, 
                longitude_destino,
                status
                ) 
            VALUES (
                '$idusuario', 
                '$idveiculo', 
                '$carga', 
                '$peso', 
                '$obs', 
                '$data_inicio', 
                '$enderecoOrigem', 
                $latitudeOrigem, 
                $longitudeOrigem, 
                '$enderecoDestino',
                $latitudeDestino, 
                $longitudeDestino,
                0
            )";

    if ($conn->query($sql)) {
        $idviagem = $conn->insert_id;
            $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Viagem cadastrado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: viagens.php?idtransportadora=' . $_SESSION['idtransportadora']); exit;
        }else {
            $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Algo deu errado.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
        }

} else {
    header('Location: ../login.php');
    exit;
}
?>

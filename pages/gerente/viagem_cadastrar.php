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

    if (empty($carga) || strlen($carga) > 100) {
        $_SESSION['alert'] = ['title' => 'Erro!', 'text' => 'Descrição da carga inválida.', 'icon' => 'warning', 'confirmButtonColor' => '#2563eb'];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

    if (!is_numeric($peso) || $peso <= 0) {
        $_SESSION['alert'] = ['title' => 'Erro!', 'text' => 'Peso inválido.', 'icon' => 'warning', 'confirmButtonColor' => '#2563eb'];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

    if (!strtotime($data_inicio)) {
        $_SESSION['alert'] = ['title' => 'Erro!', 'text' => 'Data de início inválida.', 'icon' => 'warning', 'confirmButtonColor' => '#2563eb'];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

    if (!is_numeric($latitudeOrigem) || !is_numeric($longitudeOrigem) || 
        !is_numeric($latitudeDestino) || !is_numeric($longitudeDestino)) {
        $_SESSION['alert'] = ['title' => 'Erro!', 'text' => 'Coordenadas inválidas.', 'icon' => 'warning', 'confirmButtonColor' => '#2563eb'];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

    if (!empty($obs) && strlen($obs) > 100) {
        $_SESSION['alert'] = ['title' => 'Erro!', 'text' => 'Observação muito longa.', 'icon' => 'warning', 'confirmButtonColor' => '#2563eb'];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

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

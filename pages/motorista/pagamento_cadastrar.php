<?php
session_start();

if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) 
    && $_GET['idtransportadora'] == $_SESSION['idtransportadora']) {

    include("../../elements/connection.php");

    $idusuario = $_POST["idusuario"];
    $idposto = $_POST["postoSelecionado"];
    $idviagem = $_POST["idviagem"];
    $litragem = $_POST["litragem"];
    $valor = $_POST["valorLido"];
    $destinatario = $_POST["destinatarioLido"];
    $idtransportadora = $_GET["idtransportadora"];

    $sql = "INSERT INTO pagamento (idtransportadora, idusuario, idposto, idviagem, litragem, valor, destinatario) 
            VALUES ('$idtransportadora', '$idusuario', '$idposto', '$idviagem', '$litragem', '$valor', '$destinatario')";

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

    exit;
}
?>

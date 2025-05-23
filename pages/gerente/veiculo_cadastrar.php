<?php
include('autenticacaoGerente.php');

if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) 
    && $_SESSION['gerente'] == 1 && $_GET['idtransportadora'] == $_SESSION['idtransportadora']) {

    include("../../elements/connection.php");

    $placa = $_POST["placa"];
    $modelo = $_POST["modelo"];
    $eixos = $_POST["eixos"];
    $litragem = $_POST["litragem"];
    $observacao = $_POST["observacao"];
    $idtransportadora = $_GET["idtransportadora"];

    $result = $conn->query("SELECT * FROM veiculo WHERE placa = '$placa'");

    if ($result && $result->num_rows > 0) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Essa placa já foi registrada.',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: veiculos.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }



    $sql = "INSERT INTO veiculo (idtransportadora, placa, modelo, eixos, litragem, observacao) 
            VALUES ('$idtransportadora', '$placa', '$modelo', '$eixos', '$litragem', '$observacao')";

    if ($conn->query($sql)) {
        $idveiculo = $conn->insert_id;
            $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Veículo cadastrado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: veiculos.php?idtransportadora=' . $_SESSION['idtransportadora']); exit;
        }else {
            $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Algo deu errado.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: veiculos.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
        }

} else {
    header('Location: ../login.php');
    exit;
}
?>

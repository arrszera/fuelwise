<?php
    include('autenticacaoGerente.php');
    if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) && $_SESSION['gerente'] == 1 && $_GET['idtransportadora'] == $_SESSION['idtransportadora']) {
        include("../../elements/connection.php");

        $idusuario = $_POST["idusuario"];
        $idveiculo = $_POST["idveiculo"];
        $data_inicio = $_POST["data_inicio"]; 
        $carga = $_POST["carga"];
        $peso = $_POST["peso"];
        $obs = $_POST["obs"];

        $data_inicio = str_replace('T', ' ', $data_inicio) . ":00"; 

        $sql = "INSERT INTO viagem (idusuario, idveiculo, data_inicio, carga, peso, obs) 
                VALUES ('$idusuario', '$idveiculo', '$data_inicio', '$carga', '$peso', '$obs')";

        if ($conn->query($sql)) {
            header('Location: viagens.php?idtransportadora=' . $_SESSION['idtransportadora']);
        } else {
            echo "<script>
                    alert('Erro na adição da viagem.');
                    window.location.href = 'viagens.php?idtransportadora=" . $_SESSION['idtransportadora'] . "';
                  </script>";
            exit;
        }
    }
?>

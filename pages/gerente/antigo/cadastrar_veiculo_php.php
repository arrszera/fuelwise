<?php
    include('autenticacaoGerente.php');
    if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) && $_SESSION['gerente'] == 1 && $_GET['idtransportadora'] == $_SESSION['idtransportadora']){
        include("../../elements/connection.php");
        $placa = $_POST["placa"];
        $modelo = $_POST["modelo"];
        $eixos = $_POST["eixos"];
        $observacao = $_POST["observacao"];
        $sql = "INSERT INTO veiculo (idtransportadora, placa, modelo, eixos, observacao) 
                VALUES (".$_SESSION['idtransportadora'].", '$placa', '$modelo', $eixos, '$observacao')";
        if ($result = $conn->query($sql)){
            header('Location: veiculos.php?idtransportadora='.$_SESSION['idtransportadora']);
        } else {
            echo"<script>
                    alert('Erro na adição do veiculo.');
                    window.location.href = 'veiculos.php?idtransportadora'".$_SESSION['idtransportadora'].";
                </script>";
            exit;
        }
    }
?>
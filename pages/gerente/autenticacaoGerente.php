<?php
    session_start();
    if (!isset($_SESSION['gerente']) || $_SESSION['gerente'] != '1' || !isset($_SESSION['idtransportadora'])){
        header('Location: ../index.php');
    }
    include('../../elements/connection.php');
    $sql = 'SELECT * FROM transportadora_usuario WHERE idusuario = '.$_SESSION["id"].' AND idtransportadora = '.$_SESSION["idtransportadora"];
    if (!$result = $conn->query($sql)){
        header('Location: ../index.php');
    }
    $linha = $result->fetch_assoc();
    if (!$linha || $linha['idtransportadora'] != $_GET['idtransportadora']){
        header('Location: ../index.php');
    }
?>
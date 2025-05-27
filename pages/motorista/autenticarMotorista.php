<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['idtransportadora'])){
    $sql = 'SELECT * FROM usuario 
    JOIN transportadora_usuario ON usuario.idusuario = transportadora_usuario.idusuario 
    WHERE usuario.idusuario = '.$_SESSION['id'] . ' AND idtransportadora = '.$_SESSION['idtransportadora'];

    include('../../elements/connection.php');
    if (!$result = $conn->query($sql)){
        header('Location: ../index.php');
    }
    $linha = $result->fetch_assoc();
    if (!$linha || $linha['idtransportadora'] != $_GET['idtransportadora']){
        header('Location: ../index.php');
    }
} else {
    header('Location: ../index.php');
}


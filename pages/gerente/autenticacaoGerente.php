<?php
    session_start();
    if ($_SESSION['role'] != 2 || !isset($_SESSION['idtransportadora'])){
        header('Location: ../index.php');
    }
    $sql = 'SELECT * FROM transportadora_usuario WHERE idusuario = '.$_SESSION["id"].' AND idtransportadora = '.$_SESSION["idtransportadora"];
    if (!$result = $conn->query($sql)){
        header('Location: ../index.php');
    }
?>
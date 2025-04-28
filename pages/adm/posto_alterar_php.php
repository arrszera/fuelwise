<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include("../../elements/connection.php");
    $sql = "UPDATE posto SET nome = '".$_POST['nomePosto']."', endereco = '".$_POST['enderecoPosto']."' WHERE idposto = ".$_GET['id'];
    if ($result = $conn->query($sql)){
        header('Location: postos.php');
        exit;
    }
?>

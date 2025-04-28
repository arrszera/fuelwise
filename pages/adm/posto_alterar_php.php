<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include("../../elements/connection.php");
    if ($_POST['nomePosto'] > 45 || $_POST['endereco'] > 100){
        echo "<script>
                alert('Limite de caracteres excedido.');
                window.location.href = 'posto_alterar.php?idposto=".$_GET['id']".';
            </script>";
    }
    $sql = "UPDATE posto SET nome = '".$_POST['nomePosto']."', endereco = '".$_POST['enderecoPosto']."' WHERE idposto = ".$_GET['id'];
    if ($result = $conn->query($sql)){
        header('Location: postos.php');
        exit;
    }
?>

<?php
    include('autenticacaoGerente.php');
    if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) && $_SESSION['gerente'] == 1 && $_GET['idtransportadora'] == $_SESSION['idtransportadora']){
        include("../../elements/connection.php");
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $telefone = $_POST["telefone"];
        $cpf = $_POST["cpf"];
        $gerente = $_POST["gerente"];
        
        if ($result = $conn->query('SELECT * FROM usuario WHERE cpf = '.$cpf)){
            echo"<script>
                    alert('Esse CPF já foi registrado.');
                    window.location.href = 'integrantes.php?integrantes'".$_SESSION['integrantes'].";
                </script>";
        }
        

        $sql = "INSERT INTO usuario (nome, email, senha, telefone, cpf, gerente) 
                VALUES ('$nome', '$email', '$hash', '$telefone', '$cpf', '$gerente')";
        if ($result = $conn->query($sql)){
            $sql = "INSERT INTO transportadora_usuario (idusuario, idtransportadora, datalogin) 
            VALUES ($conn->insert_id, ".$_SESSION['idtransportadora'].", '".date('Y-m-d')."')";
            if ($result = $conn->query($sql)){
                header('Location: integrantes.php?idtransportadora='.$_SESSION['idtransportadora']);
            } else {
                echo"<script>
                    alert('Erro na relação do integrante.');
                    window.location.href = 'veiculos.php?idtransportadora'".$_SESSION['idtransportadora'].";
                </script>";
            exit;
            }
        } else {
            echo"<script>
                    alert('Erro na adição do integrante.');
                    window.location.href = 'veiculos.php?idtransportadora'".$_SESSION['idtransportadora'].";
                </script>";
            exit;
        }
    }
?>
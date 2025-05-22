<?php
include('autenticacaoGerente.php');

if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) 
    && $_SESSION['gerente'] == 1 && $_GET['idtransportadora'] == $_SESSION['idtransportadora']) {

    include("../../elements/connection.php");

    $nome = $_POST["nome_usuario"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $telefone = $_POST["telefone_usuario"];
    $cpf = $_POST["cpf"];
    $gerente = 0; // padrão como não gerente

    // Verifica se o CPF já existe (atenção: coloquei aspas simples para string)
    $result = $conn->query("SELECT * FROM usuario WHERE cpf = '$cpf'");

    if ($result && $result->num_rows > 0) {
        echo "<script>
            alert('Esse CPF já foi registrado.');
            window.location.href = 'integrantes.php?idtransportadora=" . $_SESSION['idtransportadora'] . "';
        </script>";
        exit;
    }

    $sql = "INSERT INTO usuario (nome, email, senha, telefone, cpf, gerente) 
            VALUES ('$nome', '$email', '$senha', '$telefone', '$cpf', $gerente)";

    if ($conn->query($sql) === TRUE) {
        $idusuario = $conn->insert_id;

        $sql2 = "INSERT INTO transportadora_usuario (idusuario, idtransportadora, datalogin) 
                 VALUES ($idusuario, " . $_SESSION['idtransportadora'] . ", '" . date('Y-m-d') . "')";

        if ($conn->query($sql2) === TRUE) {
            header('Location: integrantes.php?idtransportadora=' . $_SESSION['idtransportadora']);
            exit;
        } else {
            echo "<script>
                alert('Erro na relação do integrante.');
                window.location.href = 'integrantes.php?idtransportadora=" . $_SESSION['idtransportadora'] . "';
            </script>";
            exit;
        }

    } else {
        echo "<script>
            alert('Erro na adição do integrante.');
            window.location.href = 'integrantes.php?idtransportadora=" . $_SESSION['idtransportadora'] . "';
        </script>";
        exit;
    }

} else {
    header('Location: login.php');
    exit;
}
?>

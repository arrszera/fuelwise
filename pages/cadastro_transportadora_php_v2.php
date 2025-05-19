<?php
    include('../elements/connection.php');
    $nomeUsuario = $_POST['nomePessoal'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $emailUsuario = $_POST['email'];
    $cnpj = $_SESSION['cnpj'];
    $nomeTransportadora = $_SESSION['nomeTransportadora'];
    $endereco = $_SESSION['endereco'];
    $query = "INSERT INTO solicitacao (nomeUsuario, telefone, cpf, senha, nomeTransportadora, endereco, cnpj, emailUsuario) ";
    $query .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    include('../elements/connection.php');
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $nomeUsuario, $telefone, $cpf, $senha, $nomeTransportadora, $endereco, $cnpj, $emailUsuario);
    if($stmt->execute()){
        echo "<script>
        alert('Sua solicitação foi enviada com sucesso, o suporte irá realizar a verificação e aprovação em breve.');
        window.location.href = 'index.php';
        </script>";
        session_destroy();
    } else {
        echo "<script>
                alert('Houve um problema no envio da solicitação, o suporte está trabalhando no erro, tente novamente mais tarde.');
                window.location.href = 'index.php';
            </script>";
    }
?>
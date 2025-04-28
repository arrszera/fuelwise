<?php 
include_once('../config.php');
session_start();
if($_GET['page'] == 1 || !isset($_GET['page'])){
    $nomeTransportadora = trim($_POST["nomeTransportadora"]);
    $endereco = trim($_POST["endereco"]);
    $cnpj = trim(str_replace(['.', '-'], '', $_POST["cnpj"]));
    if (
            strlen($nomeTransportadora) == 0 ||
            strlen($endereco) == 0 ||
            strlen($cnpj) == 0 
        ){
        header('Location: ' . ROOT_PATH .'/pages/cadastro_transportadora.php?page=1&erro=1');
        exit;
    }

    if (strlen($nomeTransportadora) > 50){
        echo("<script>alert('O tamanho limite do nome é de 50 caracteres');
                window.location.href = 'cadastro_transportadora.php?page=1'
            </script>");
        exit;
    }
    if (strlen($endereco) > 100){
        echo("<script>alert('O tamanho limite do endereço é de 100 caracteres');
                window.location.href = 'cadastro_transportadora.php?page=1'
            </script>");
        exit;
    }
    if (strlen($cnpj) != 14){
        echo("<script>alert('O CNPJ deve ter 14 caracteres (sinais serão ignorados)');
                window.location.href = 'cadastro_transportadora.php?page=1'
            </script>");
        exit;
    }
    $_SESSION['nomeTransportadora'] = $nomeTransportadora;
    $_SESSION['endereco'] = $endereco;
    $_SESSION['cnpj'] = $cnpj;

    header('Location: cadastro_transportadora.php?page=2');
}
else if($_GET['page'] == 2){
    $nomeUsuario = $_POST['nomeUsuario'];
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
}else{
    echo "Página não encontrada";          
}
?>
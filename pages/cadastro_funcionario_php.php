<?php 
$email = trim($_POST["email"]);
$nome = trim($_POST["nome"]);
$senha = trim($_POST["senha"]);
$hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
$telefone = trim($_POST["telefone"]);
$cpf = trim(str_replace(['.', '-'], '', $_POST["cpf"]));
if (
        strlen($email) == 0 ||
        strlen($nome) == 0 ||
        strlen($senha) == 0 ||
        strlen($telefone) == 0 ||
        strlen($cpf) == 0 
    ){
    echo("<script>alert('Preencha todos os campos');
    window.location.href = 'cadastro_funcionario.php'
    </script>");    exit;
}

if (strlen($email) > 255){
    echo("<script>alert('O tamanho limite do email é de 255 caracteres');
            window.location.href = 'cadastro_funcionario.php'
        </script>");
    exit;
}
if (strlen($nome) > 90){
    echo("<script>alert('O tamanho limite do nome é de 90 caracteres');
            window.location.href = 'cadastro_funcionario.php'
        </script>");
    exit;
}
if (strlen($senha) > 255){
    echo("<script>alert('O tamanho limite da senha é de 255 caracteres');
            window.location.href = 'cadastro_funcionario.php'
        </script>");
    exit;
}
if (strlen($telefone) > 45){
    echo("<script>alert('O tamanho limite do telefone é de 45 caracteres');
            window.location.href = 'cadastro_funcionario.php'
        </script>");
    exit;
}
if (strlen($cpf) != 11){
    echo("<script>alert('O CPF deve ter 11 caracteres (sinais serão ignorados)');
            window.location.href = 'cadastro_funcionario.php'
        </script>");
    exit;
}
$query = "INSERT INTO tb_usuario (email, nome, senha, telefone, cpf) ";
$query .= "VALUES (?, ?, ?, ?, ?);";

include('../elements/connection.php');
$stmt = $conn->prepare($query);
$stmt->bind_param("sssss", $email, $nome, $hashedPassword, $telefone, $cpf);
if($stmt->execute()){
    session_start();
    $_SESSION['id'] = $conn->insert_id;
    $_SESSION['gerente'] = 0;
    $_SESSION['adm'] = 0;
    echo "<script>
        alert('Cadastro realizado com sucesso.');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
            alert('Houve um problema no envio da solicitação, o suporte está trabalhando no erro, tente novamente mais tarde.');
            window.location.href = 'index.php';
        </script>";
}

?>
<?php
include('autenticacaoGerente.php');

function validarCPF($cpf){
    if (strlen($cpf) !== 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($i = 0; $i < $t; $i++) {
            $soma += $cpf[$i] * (($t + 1) - $i);
        }
        $digito = (10 * $soma) % 11;
        $digito = ($digito == 10) ? 0 : $digito;

        if ($cpf[$t] != $digito) {
            return false;
        }
    }

    return true;
}

if (isset($_GET['idtransportadora']) && isset($_SESSION['idtransportadora']) 
    && $_SESSION['gerente'] == 1 && $_GET['idtransportadora'] == $_SESSION['idtransportadora']) {

    include("../../elements/connection.php");

    $nome = $_POST["nome_usuario"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $telefone = $_POST["telefone_usuario"];
    $cpf = preg_replace('/\D/', '', $_POST["cpf"]);
    $gerente = 0;

    $result = $conn->query("SELECT * FROM usuario WHERE cpf = '$cpf' OR email='$email'");

    if ($result && $result->num_rows > 0) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Esse CPF ou E-mail já foi registrado.',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

    if (!validarCPF($cpf)) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Esse CPF é inválido.',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

    $sql = "INSERT INTO usuario (nome, email, senha, telefone, cpf, gerente) 
            VALUES ('$nome', '$email', '$senha', '$telefone', '$cpf', $gerente)";

    if ($conn->query($sql)) {
        $idusuario = $conn->insert_id;

        $sql2 = "INSERT INTO transportadora_usuario (idusuario, idtransportadora, datalogin) 
                 VALUES ($idusuario, " . $_SESSION['idtransportadora'] . ", '" . date('Y-m-d') . "')";

        if ($conn->query($sql2)) {
            $_SESSION['alert'] = [
                'title' => 'Sucesso!',
                'text' => 'Usuário cadastrado com sucesso.',
                'icon' => 'success', 
                'confirmButtonColor' => '#2563eb',
            ];
            header('Location: integrantes.php?idtransportadora=' . $_SESSION['idtransportadora']); exit;
        } else {
            $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Algo deu errado.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
        }

    } else {
        $_SESSION['alert'] = [
				'title' => 'Erro!',
				'text' => 'Algo deu errado.',
				'icon' => 'warning', 
				'confirmButtonColor' => '#2563eb',
			];
            header("location: integrantes.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
    }

} else {
    header('Location: ../login.php');
    exit;
}
?>

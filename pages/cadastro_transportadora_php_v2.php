<?php
function validarCNPJ($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    if (strlen($cnpj) != 14) return false;

    if (preg_match('/(\d)\1{13}/', $cnpj)) return false;

    for ($t = 12; $t < 14; $t++) {
        $d = 0;
        $c = 0;
        for ($m = $t - 7, $i = 0; $i < $t; $i++) {
            $d += $cnpj[$i] * $m--;
            if ($m < 2) $m = 9;
        }
        $digito = ((10 * $d) % 11) % 10;
        if ($cnpj[$t] != $digito) return false;
    }
    return true;
}

function temCaracterEspecial($str) {
    return preg_match('/[!@#$%^&*()\-_=+\[\]{};:,.?\/|~`]/', $str);
}

function validarCampos($dados) {
    foreach ($dados as $campo => $valor) {
        switch($campo) {
            case 'nomeEmpresa':
                if (strlen(trim($valor)) < 2) return false;
                break;
            case 'endereco':
                if (strlen(trim($valor)) == 0) return false;
                break;
            case 'cep':
                if (strlen(preg_replace('/\D/', '', $valor)) != 8) return false;
                break;
            case 'cidade':
                if (strlen(trim($valor)) < 2) return false;
                break;
            case 'estado':
                if (strlen(trim($valor)) != 2) return false;
                break;
            case 'telefoneEmpresa':
            case 'telefonePessoal':
                if (!preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $valor)) return false;
                break;
            case 'cnpj':
                if (!preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $valor) || !validarCNPJ($valor)) return false;
                break;
            case 'nomePessoal':
            case 'sobrenome':
                if (strlen(trim($valor)) < 2) return false;
                break;
            case 'cpf':
                if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $valor)) return false;
                break;
            case 'email':
                if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) return false;
                break;
            case 'senha':
                if (strlen($valor) < 8 || !temCaracterEspecial($valor)) return false;
                break;
            case 'confirmarSenha':
                if (!isset($dados['senha']) || $valor !== $dados['senha']) return false;
                break;
            // outros campos sem regras específicas, pode continuar
        }
    }
    return true; // se passou por todas as validações
}

session_start();

// armazena os dados preenchidos
$_SESSION['form_data'] = $_POST;

echo var_dump($_SESSION['form_data']);
exit;
// pegando dados do formulário
$campos = [
    'nomeEmpresa', 'endereco', 'cep', 'cidade', 'estado', 'telefoneEmpresa', 'cnpj',
    'nomePessoal', 'sobrenome', 'cpf', 'email', 'senha', 'confirmarSenha', 'telefonePessoal'
];

$dados = [];

// pega os dados do POST
foreach ($campos as $campo) {
    if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
        $_SESSION['erro'] = true;
        header("Location: cadastro_transportadora.php");
        exit;
    }
    $dados[$campo] = trim($_POST[$campo]);
}
$erros = validarCampos($dados);

if (!$erros) {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Preencha todos os campos corretamente. Tente novamente.',
        'icon' => 'question',
        'iconColor' => '#fedf00',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: cadastro_transportadora.php");
}

// query de inserção
$query = "INSERT INTO solicitacao (nomeUsuario, telefone, cpf, senha, nomeTransportadora, endereco, cnpj, emailUsuario) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

include('../elements/connection.php');

$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssss", $nomeUsuario, $telefone, $cpf, $senha, $nomeTransportadora, $endereco, $cnpj, $emailUsuario);

if ($stmt->execute()) {
    unset($_SESSION['form_data']); // limpa os dados em caso de sucesso
    $_SESSION['alert'] = [
        'title' => 'Sucesso!',
        'text' => 'Cadastro enviado com sucesso!',
        'icon' => 'success', 
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: index.php"); 
} else {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Erro ao enviar cadastro. O suporte está trabalhando nisso.',
        'icon' => 'question',
        'iconColor' => '#fedf00',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: cadastro_transportadora.php"); 
}
exit;
?>
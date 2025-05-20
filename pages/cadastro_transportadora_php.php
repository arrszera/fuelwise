<?php
function validarCNPJ($cnpj) {
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
                if (strlen(trim($valor)) != 2 || !ctype_alpha($valor)) return false;
                break;
            case 'telefoneEmpresa':
            case 'telefonePessoal':
                if (!preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $valor)) return false;
                break;
            case 'cnpj':
                if (!validarCNPJ($valor)) return false;
                break;
            case 'nomePessoal':
            case 'sobrenome':
                if (strlen(trim($valor)) < 2) return false;
                break;
            case 'cpf':
                if (!validarCPF($valor)) return false;
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

// pegando dados do formulário
$campos = [
    'nomeEmpresa', 'endereco', 'cep', 'cidade', 'estado', 'telefoneEmpresa', 'cnpj',
    'nomePessoal', 'sobrenome', 'cpf', 'email', 'senha', 'confirmarSenha', 'telefonePessoal',
];

$dados = [];

// pega os dados do POST
foreach ($campos as $campo) {
    if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Preencha todos os campos corretamente. Tente novamente.',
            'icon' => 'question',
            'iconColor' => '#fedf00',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: cadastro_transportadora.php"); exit;
    }
    $dados[$campo] = trim($_POST[$campo]);
}

// limpa inputs
$dados['cpf'] = preg_replace('/[^0-9]/', '', $dados['cpf']);
$dados['cnpj'] = preg_replace('/[^0-9]/', '', $dados['cnpj']);
$dados['cep'] = preg_replace('/[^0-9]/', '', $dados['cep']);
$dados['estado'] = strtoupper($dados['estado']);

// verifica se todos os campos atendem as regras estabelecidas
$erros = validarCampos($dados);

if (!$erros) {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Preencha todos os campos corretamente. Tente novamente.',
        'icon' => 'question',
        'iconColor' => '#fedf00',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: cadastro_transportadora.php"); exit;
}

// query de inserção
$query = "INSERT INTO solicitacao (
    nomeTransportadora, endereco, cep, cidade, estado, telefoneEmpresa, cnpj,
    nomeUsuario, sobrenome, cpf, emailUsuario, senha, telefoneUsuario, status
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


include('../elements/connection.php');

// hash da senha
$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
unset($dados['confirmarSenha']);
$status = 0;
$stmt = $conn->prepare($query);
$stmt->bind_param(
    'sssssssssssssi',
    $dados['nomeEmpresa'],
    $dados['endereco'],
    $dados['cep'],
    $dados['cidade'],
    $dados['estado'],
    $dados['telefoneEmpresa'],
    $dados['cnpj'],
    $dados['nomePessoal'],
    $dados['sobrenome'],
    $dados['cpf'],
    $dados['email'],
    $dados['senha'],
    $dados['telefonePessoal'],
    $status
);

if ($stmt->execute()) {
    unset($_SESSION['form_data']); // limpa os dados em caso de sucesso
    $_SESSION['alert'] = [
        'title' => 'Sucesso!',
        'text' => 'Cadastro enviado com sucesso! Sua solicitação será analisada em 1-2 dias úteis.',
        'icon' => 'success', 
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: index.php"); exit;
} else {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Erro ao enviar cadastro. O suporte está trabalhando nisso.',
        'icon' => 'question',
        'iconColor' => '#fedf00',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: cadastro_transportadora.php"); exit;
}
exit;
?>
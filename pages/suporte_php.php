<?php

session_start();

$_SESSION['form_data'] = $_POST;

if (!isset($_POST['motivo']) || trim($_POST['motivo']) === '' || strlen($_POST['motivo']) > 250) {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Preencha corretamente o campo de motivo antes de enviar.',
        'icon' => 'warning',
        'iconColor' => '#fedf00',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: suporte.php");
    exit;
}
if (!isset($_POST['titulo']) || trim($_POST['titulo']) === '' || strlen($_POST['titulo']) > 250) {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Preencha corretamente o campo de título antes de enviar.',
        'icon' => 'warning',
        'iconColor' => '#fedf00',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: suporte.php");
    exit;
}

$motivo = substr(trim($_POST['motivo']), 0, 250);
$titulo = substr(trim($_POST['titulo']), 0, 50);
$usuario_id = $_SESSION['id'] ?? null;

if (!$usuario_id) {
    $_SESSION['alert'] = [
        'title' => 'Sessão expirada!',
        'text' => 'Faça login novamente.',
        'icon' => 'error',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: index.php");
    exit;
}

$upload_dir = '../assets/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$arquivos = [];

if (isset($_FILES['anexo']) && $_FILES['anexo']['error'][0] !== 4) {
    foreach ($_FILES['anexo']['tmp_name'] as $key => $tmp_name) {
        $nome_original = basename($_FILES['anexo']['name'][$key]);
        $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];

        if (!in_array($extensao, $permitidos)) {
            $_SESSION['alert'] = [
                'title' => 'Arquivo inválido!',
                'text' => "O tipo de arquivo '$extensao' não é permitido.",
                'icon' => 'warning',
                'iconColor' => '#f59e0b',
                'confirmButtonColor' => '#2563eb',
            ];
            header("Location: suporte.php");
            exit;
        }

        $nome_novo = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '_', $nome_original);
        $caminho_final = $upload_dir . $nome_novo;

        if (move_uploaded_file($tmp_name, $caminho_final)) {
            $arquivos[] = [
                'nome_arquivo' => $nome_novo,
                'path' => $caminho_final
            ];
        } else {
            $_SESSION['alert'] = [
                'title' => 'Erro no upload!',
                'text' => "Erro ao enviar o arquivo '$nome_original'.",
                'icon' => 'error',
                'iconColor' => '#dc2626',
                'confirmButtonColor' => '#2563eb',
            ];
            header("Location: suporte.php");
            exit;
        }
    }
}

include('../elements/connection.php');

$data_criacao = date('Y-m-d'); // data atual para o campo data_criacao

$stmt = $conn->prepare("INSERT INTO denuncia (idusuario, titulo, motivo, data_criacao) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    // Debug simples em caso de erro na prepare
    die("Erro na preparação da query: " . $conn->error);
}
$stmt->bind_param("isss", $usuario_id, $titulo, $motivo, $data_criacao);

if ($stmt->execute()) {
    $iddenuncia = $stmt->insert_id;
    $stmt->close();

    if (!empty($arquivos)) {
        $stmt_anexo = $conn->prepare("INSERT INTO anexos (iddenuncia, nome_arquivo, path) VALUES (?, ?, ?)");
        if (!$stmt_anexo) {
            die("Erro na preparação da query de anexos: " . $conn->error);
        }

        foreach ($arquivos as $arquivo) {
            $stmt_anexo->bind_param("iss", $iddenuncia, $arquivo['nome_arquivo'], $arquivo['path']);
            $stmt_anexo->execute();
        }
        $stmt_anexo->close();
    }

    unset($_SESSION['form_data']);
    $_SESSION['alert'] = [
        'title' => 'Sucesso!',
        'text' => 'Denúncia enviada com sucesso.',
        'icon' => 'success',
        'confirmButtonColor' => '#2563eb',
    ];
} else {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => 'Erro ao salvar a denúncia. Tente novamente.',
        'icon' => 'error',
        'confirmButtonColor' => '#2563eb',
    ];
    $stmt->close();
}

$conn->close();
header("Location: suporte.php");
exit;
?>

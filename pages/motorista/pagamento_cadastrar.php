<?php
include('autenticarMotorista.php');

function estaDentroDoRaio($latAtual, $lngAtual, $latPosto, $lngPosto, $raioKm = 2) {
    $raioTerra = 6371;
    $dLat = deg2rad($latPosto - $latAtual);
    $dLng = deg2rad($lngPosto - $lngAtual);
    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($latAtual)) * cos(deg2rad($latPosto)) *
        sin($dLng / 2) * sin($dLng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return ($raioTerra * $c) <= $raioKm;
}

if (
    isset($_GET['idtransportadora'], $_SESSION['idtransportadora']) &&
    $_GET['idtransportadora'] == $_SESSION['idtransportadora'] &&
    isset(
        $_POST['idusuario'],
        $_POST['postoSelecionado'],
        $_POST['idviagem'],
        $_POST['litragem'],
        $_POST['valor'],
        $_POST['destinatarioLidoInput'],
        $_POST['distanciaPercorrida'],
        $_FILES['anexo']
    )
) {

    include("../../elements/connection.php");

    $upload_dir = '../assets/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $arquivos = [];

    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'][0] !== 4) {
        foreach ($_FILES['anexo']['tmp_name'] as $key => $tmp_name) {
            $nome_original = basename($_FILES['anexo']['name'][$key]);
            $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png'];

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
                    'text' => "Erro ao enviar o arquivo '$nome_original', pelo menos 3 fotos devem ser selecionadas.",
                    'icon' => 'error',
                    'iconColor' => '#dc2626',
                    'confirmButtonColor' => '#2563eb',
                ];
                header("Location: suporte.php");
                exit;
            }
        }
    }

    $idusuario = $_POST["idusuario"];
    $idposto = $_POST["postoSelecionado"];
    $idviagem = $_POST["idviagem"];
    $litragem = $_POST["litragem"];
    $valor = $_POST["valor"];
    $destinatario = $_POST["destinatarioLidoInput"];
    $idtransportadora = $_GET["idtransportadora"];
    $distanciaPercorrida = $_POST['distanciaPercorrida'];

    $latitude = isset($_POST['latitude']) && $_POST['latitude'] !== '' ? $_POST['latitude'] : null;
    $longitude = isset($_POST['longitude']) && $_POST['longitude'] !== '' ? $_POST['longitude'] : null;

    if ($latitude === null || $longitude === null) {
        $queryCoordenadasViagem = "SELECT latitude_atual, longitude_atual FROM viagem WHERE idviagem = $idviagem LIMIT 1";
        $resultCoordenadasViagem = $conn->query($queryCoordenadasViagem);

        if ($resultCoordenadasViagem && $resultCoordenadasViagem->num_rows > 0) {
            $coordenadasViagem = $resultCoordenadasViagem->fetch_object();
            $latitude = $coordenadasViagem->latitude_atual;
            $longitude = $coordenadasViagem->longitude_atual;

            if ($latitude === null || $longitude === null) {
                $_SESSION['alert'] = [
                    'title' => 'Erro!',
                    'text' => 'Últimas coordenadas da viagem não estão disponíveis.',
                    'icon' => 'warning',
                    'confirmButtonColor' => '#2563eb',
                ];
                header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
                exit;
            }
        } else {
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'Coordenadas não informadas e não encontradas no banco.',
                'icon' => 'warning',
                'confirmButtonColor' => '#2563eb',
            ];
            header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
            exit;
        }
    }

    if (count($arquivos) !== 3) {
        $_SESSION['alert'] = [
            'title' => 'Erro no upload!',
            'text' => "Erro ao enviar, pelo menos 3 fotos devem ser selecionadas.",
            'icon' => 'error',
            'iconColor' => '#dc2626',
            'confirmButtonColor' => '#2563eb',
        ];
        header('Location: index.php?idtransportadora=' . $idtransportadora);
        exit;
    }

    $query = 'SELECT cpf FROM usuario WHERE idusuario = ' . $idusuario;
    $cpf = $conn->query($query)->fetch_object()->cpf;

    $queryVeiculo = "SELECT idveiculo FROM viagem WHERE idviagem = $idviagem";
    $resultVeiculo = $conn->query($queryVeiculo);
    if (!$resultVeiculo || $resultVeiculo->num_rows === 0) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Viagem não encontrada.',
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
    }
    $idveiculo = $resultVeiculo->fetch_object()->idveiculo;

    $query = "SELECT latitude, longitude FROM posto WHERE idposto = $idposto";
    $coordenadas = $conn->query($query)->fetch_object();

    // verificar se está dentro do raio permitido para pagamento
    if (!estaDentroDoRaio($latitude, $longitude, $coordenadas->latitude, $coordenadas->longitude)) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Você está fora da distância máxima para o pagamento.',
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
    }

    // verificar se a litragem enviada está dentro da litragem máxima do veículo
    $queryLitragem = "SELECT litragem FROM veiculo WHERE idveiculo = $idveiculo";
    $litragemMaxima = $conn->query($queryLitragem)->fetch_object()->litragem;

    if ($litragem > $litragemMaxima) {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'A litragem informada excede a capacidade do veículo.',
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
    }

    $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $dataPagamento = $now->format('Y-m-d H:i:s');

    $sql = "INSERT INTO pagamento (idtransportadora, idusuario, idposto, idviagem, litragem, valor, destinatario, cpfPagador, latitudePagamento, longitudePagamento, dataPagamento, distanciaPercorrida, pathBomba, pathPosto, pathPlaca) 
            VALUES ('$idtransportadora', '$idusuario', '$idposto', '$idviagem', '$litragem', '$valor', '$destinatario', '$cpf', $latitude, $longitude, '$dataPagamento', $distanciaPercorrida, '{$arquivos[0]['path']}', '{$arquivos[1]['path']}', '{$arquivos[2]['path']}')";

    if ($conn->query($sql)) {
        $_SESSION['alert'] = [
            'title' => 'Sucesso!',
            'text' => 'Pagamento cadastrado com sucesso.',
            'icon' => 'success',
            'confirmButtonColor' => '#2563eb',
        ];
        header('Location: index.php?idtransportadora=' . $_SESSION['idtransportadora']);
        exit;
    } else {
        $erro = $conn->error;  // pega o erro real do MySQL
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => "Algo deu errado ao salvar o pagamento. Erro: $erro",
            'icon' => 'warning',
            'confirmButtonColor' => '#2563eb',
        ];
        header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
    }

} else {
    $_SESSION['alert'] = [
        'title' => 'Erro!',
        'text' => "Preencha todos os campos corretamente",
        'icon' => 'warning',
        'confirmButtonColor' => '#2563eb',
    ];
    header("Location: index.php?idtransportadora=" . $_SESSION['idtransportadora']);
    exit;
}
?>

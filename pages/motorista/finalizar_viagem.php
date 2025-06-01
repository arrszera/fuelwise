<?php 
    include('autenticarMotorista.php');
    include('../../elements/connection.php');

    function estaDentroDoRaio($latAtual, $lngAtual, $latDestino, $lngDestino, $raioKm = 2) {
        $raioTerra = 6371;
        $dLat = deg2rad($latDestino - $latAtual);
        $dLng = deg2rad($lngDestino - $lngAtual);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($latAtual)) * cos(deg2rad($latDestino)) *
            sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return ($raioTerra * $c) <= $raioKm;
    }
//
    $sql = 'SELECT * FROM viagem WHERE viagem.idusuario = '.$_SESSION['id'].' AND status = 0';
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $idviagem = $row['idviagem'];
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);
    $idtransportadora = intval($_POST['idtransportadora']);

    $conn->query('UPDATE viagem SET latitude_atual = '.$latitude.', longitude_atual = '.$longitude.' WHERE idviagem = '.$idviagem);

    if (estaDentroDoRaio($latitude, $longitude, $row['latitude_destino'], $row['longitude_destino'])) {
        $conn->query('UPDATE viagem SET status = 1, latitude_atual = '.$latitude.', longitude_atual = '.$longitude.', data_termino = NOW() WHERE idviagem = '.$idviagem);
        $_SESSION['alert'] = [
            'title' => 'Sucesso!',
            'text' => 'Viagem finalizada com sucesso.',
            'icon' => 'success', 
            'confirmButtonColor' => '#2563eb',
        ];
    } else {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Você não está dentro do raio de entrega.',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
    }

    header('Location: index.php?idtransportadora=' . $idtransportadora);
    exit;
?>
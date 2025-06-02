<?php
include('autenticacaoGerente.php');

if (isset($_GET['idviagem'])) {
    $idviagem = $_GET['idviagem'];

    $query = "
        SELECT 
            viagem.latitude_atual, 
            viagem.longitude_atual
        FROM 
            viagem
        WHERE 
            viagem.idviagem = ?
    ";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $idviagem); 
        
        $stmt->execute();
        
        $stmt->bind_result($latitude_atual, $longitude_atual);
        
        if ($stmt->fetch()) {
            header('Content-Type: application/json');
            echo json_encode([
                'latitude_atual' => $latitude_atual,
                'longitude_atual' => $longitude_atual
            ]);
        } else {
            $_SESSION['alert'] = [
                'title' => 'Erro!',
                'text' => 'Viagem não encontrada.',
                'icon' => 'warning', 
                'confirmButtonColor' => '#2563eb',
            ];
            header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']);
        }
        $stmt->close();
    } else {
        $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Algo deu errado.',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']);
    }
} else {
    $_SESSION['alert'] = [
            'title' => 'Erro!',
            'text' => 'Algo deu errado.',
            'icon' => 'warning', 
            'confirmButtonColor' => '#2563eb',
        ];
        header("location: viagens.php?idtransportadora=".$_SESSION['idtransportadora']);
}

$conn->close();
?>

<?php
include('../../elements/connection.php');
session_start();

$lat_usuario = (float) $_GET['lat'];
$lng_usuario = (float) $_GET['lng'];
$raio = isset($_GET['raio']) ? $_GET['raio'] : 100;

// consulta postos dentro do raio definido
$sql = "
    SELECT * ,
        (
            6371 * acos(
                cos(radians(?)) 
                * cos(radians(CAST(latitude AS DECIMAL(10,6)))) 
                * cos(radians(CAST(longitude AS DECIMAL(10,6))) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians(CAST(latitude AS DECIMAL(10,6))))
            )
        ) AS distancia
    FROM posto
    HAVING distancia <= ?
    ORDER BY distancia ASC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro no prepare: " . $conn->error);
}
//
$stmt->bind_param("dddi", $lat_usuario, $lng_usuario, $lat_usuario, $raio);
$stmt->execute();
$result = $stmt->get_result();
$postos = $result->fetch_all(MYSQLI_ASSOC);

// pega os combustíveis para cada posto
foreach ($postos as &$posto) {
    $idposto = $posto['idposto'];
    $sql_comb = "SELECT idcombustivel, tipo, preco FROM combustivel WHERE idposto = ?";
    $stmt_comb = $conn->prepare($sql_comb);
    if (!$stmt_comb) {
        die("Erro no prepare de combustíveis: " . $conn->error);
    }
    $stmt_comb->bind_param("i", $idposto);
    $stmt_comb->execute();
    $result_comb = $stmt_comb->get_result();
    $combustiveis = $result_comb->fetch_all(MYSQLI_ASSOC);

    $posto['combustiveis'] = $combustiveis;
}

// atualiza posição atual da viagem
$sql = 'UPDATE viagem SET latitude_atual = ?, longitude_atual = ? WHERE idusuario = ? AND status = 0';
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro no prepare da viagem: " . $conn->error);
}
$stmt->bind_param("ddi", $lat_usuario, $lng_usuario, $_SESSION['id']);
$stmt->execute();

echo json_encode($postos);

?>

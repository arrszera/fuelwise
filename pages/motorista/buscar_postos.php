<?php
include('../../elements/connection.php');
session_start();
$lat_usuario = (float) $_GET['lat'];
$lng_usuario = (float) $_GET['lng'];
$raio = 523;

$sql = "
    SELECT *,
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

$stmt->bind_param("dddi", $lat_usuario, $lng_usuario, $lat_usuario, $raio);


$stmt->execute();

$result = $stmt->get_result();
$postos = $result->fetch_all(MYSQLI_ASSOC);

$sql = 'UPDATE viagem SET latitude_atual = ?, longitude_atual = ? WHERE idusuario = ' . $_SESSION['id']. ' AND status = 1';
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro no prepare: " . $conn->error);
}
$stmt->bind_param("dd", $lat_usuario, $lng_usuario);

$stmt->execute();

echo json_encode($postos);

?>

<?php 
    include('autenticarMotorista.php');

    include('../../elements/connection.php');

    $sql = "SELECT * FROM viagem WHERE idusuario = ". $_SESSION['id'] . " AND status = 0 ORDER BY data_inicio ASC";
    $agora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $requests = [];
    $viagemAtual = null;
    $proximaViagem = null;
    $result = $conn->query($sql);
if ($result->num_rows > 0) {
    $viagensFuturas = [];
    
    while ($row = $result->fetch_assoc()) {
        $idviagem = (int)$row['idviagem'];

        $requests[$idviagem] = [
            'idviagem' => $idviagem,
            'idveiculo' => $row['idveiculo'],
            'data_inicio' => $row['data_inicio'],
            'enderecoOrigem' => $row['endereco_origem'],
            'latitudeOrigem' => $row['latitude_origem'],
            'longitudeOrigem' => $row['longitude_origem'],
            'enderecoDestino' => $row['endereco_destino'],
            'latitudeDestino' => $row['latitude_destino'],
            'longitudeDestino' => $row['longitude_destino'],
            'carga' => $row['carga'],
            'obs' => $row['obs'],
            'status' => $row['status'],
        ];
        if ($row['data_inicio'] <= $agora) {
            $viagensFuturas[] = [
                'idviagem' => $idviagem,
                'idveiculo' => $row['idveiculo'],
                'data_inicio' => $row['data_inicio'],
                'enderecoOrigem' => $row['endereco_origem'],
                'latitudeOrigem' => $row['latitude_origem'],
                'longitudeOrigem' => $row['longitude_origem'],
                'enderecoDestino' => $row['endereco_destino'],
                'latitudeDestino' => $row['latitude_destino'],
                'longitudeDestino' => $row['longitude_destino'],
                'carga' => $row['carga'],
                'obs' => $row['obs'],
                'status' => $row['status'],
            ];
        }

    }

    if (count($viagensFuturas) > 0) {
        $viagemAtual = $viagensFuturas[0];
    }

    if (count($viagensFuturas) > 1) {
        $proximaViagem = $viagensFuturas[1];
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Início</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../css/solicitacoes_v2.css" rel="stylesheet">
    <link href="../../css/index.css" rel="stylesheet">
    <link href="../../css/header.css" rel="stylesheet">
    <link href="../../css/sidebar.css" rel="stylesheet">
    <link href="../../css/footer.css" rel="stylesheet">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
    <style>
        #map {
            height: 400px;
            width: 70%;
            border-radius: 8px;
        }

        .map-container{
            display: flex;
            justify-content: space-around;
        }

        h2{
            font-weight: 400;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include('../../elements/sidebar.php') ?>
        <?php include('../../elements/alert.php'); ?>
    </div>

    <div class="main">
        <?php include('../../elements/header.php'); ?>
        <div class="content">
            <header class="page-header">
                <h1>Mapa</h1>
                <p>Visualize sua localização no mapa, assim como postos próximos.</p>
            </header>
            <div class="map-container">
                <div class="map" id="map"></div>
                <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <h2>Viagem atual</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($viagemAtual) { ?>
                            <h4>Origem</h4>
                            <p><?= htmlspecialchars($viagemAtual['enderecoOrigem']) ?></p>
                            <h4>Destino</h4>
                            <p><?= htmlspecialchars($viagemAtual['enderecoDestino']) ?></p>
                            <h4>Data</h4>
                            <p><?= date('d/m/Y H:i', strtotime($viagemAtual['data_inicio'])) ?></p>
                        <?php } else { ?>
                            <p>Nenhuma viagem atual encontrada.</p>
                        <?php } ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Próxima viagem</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($proximaViagem) { ?>
                            <h4>Origem</h4>
                            <p><?= htmlspecialchars($proximaViagem['enderecoOrigem']) ?></p>
                            <h4>Destino</h4>
                            <p><?= htmlspecialchars($proximaViagem['enderecoDestino']) ?></p>
                            <h4>Data</h4>
                            <p><?= date('d/m/Y H:i', strtotime($proximaViagem['data_inicio'])) ?></p>
                        <?php } else { ?>
                            <p>Nenhuma próxima viagem encontrada.</p>
                        <?php } ?>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>

    <script src="../../js/index.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
<script>
    mapboxgl.accessToken = '';

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(async function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            console.log(latitude,longitude)

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [longitude, latitude],
                zoom: 14
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.on('load', () => {
                new mapboxgl.Marker({ color: 'red' })
                .setLngLat([longitude, latitude])
                .setPopup(new mapboxgl.Popup().setHTML("<strong>Você está aqui</strong>"))
                .addTo(map);

                (async () =>{
                    const response = await fetch(`buscar_postos.php?lat=${latitude}&lng=${longitude}`);
                    if (!response.ok) {
                        alert('Erro ao buscar postos.');
                        return;
                    }
                    const postos = await response.json();
                    console.log(postos)
                    const svgPosto = `<svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="40"
                        height="40"
                        viewBox="0 0 64 64"
                        fill="none"
                        stroke="#000000"
                        stroke-width="2"
                        stroke-linejoin="round"
                        stroke-linecap="round"
                        >
                        <!-- Corpo da bomba -->
                        <rect x="14" y="12" width="24" height="40" rx="4" ry="4" fill="#e63946" stroke="#000"/>
                        <!-- Tela da bomba -->
                        <rect x="20" y="18" width="12" height="12" rx="2" ry="2" fill="#f1faee" stroke="#000"/>
                        <!-- Mangueira -->
                        <path d="M38 14h6v24h-4" stroke="#000" fill="none"/>
                        <!-- Bico -->
                        <rect x="42" y="36" width="6" height="8" rx="1" ry="1" fill="#1d3557" stroke="#000"/>
                        <!-- Detalhes da bomba -->
                        <line x1="26" y1="38" x2="26" y2="46" stroke="#000"/>
                        <line x1="32" y1="38" x2="32" y2="46" stroke="#000"/>
                    </svg>`;

                    function createSVGElementFromString(svgString) {
                        const div = document.createElement('div');
                        div.innerHTML = svgString.trim();
                        return div.firstChild;
                    }

                    postos.forEach(posto => {
                        const svgElement = createSVGElementFromString(svgPosto);
                        new mapboxgl.Marker({ element: svgElement, anchor: "bottom" })
                            .setLngLat([posto.longitude, posto.latitude])
                            .setPopup(new mapboxgl.Popup().setHTML(`<strong>${posto.nome}</strong><br>Distância: ${posto.distancia.toFixed(2)} km`))
                            .addTo(map);
                    });
                })()

            })
            

        }, function(error) {
            alert("Erro ao obter localização: " + error.message);
        });
    } else {
        alert("Geolocalização não suportada pelo navegador.");
    }
</script>

</body>
</html>

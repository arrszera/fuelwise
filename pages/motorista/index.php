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
            'idusuario' => $row['idusuario'],
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
                'idusuario' => $row['idusuario'],
                'data_inicio' => $row['data_inicio'],
                'data_termino' => $row['data_termino'],
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

if ($viagemAtual) { ?>
    <script>
        const destinoViagem = {
            latitude: <?= json_encode($viagemAtual['latitudeDestino']) ?>,
            longitude: <?= json_encode($viagemAtual['longitudeDestino']) ?>
        };
    </script>
<?php } ?>
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
        #dadosExibidos, #dadosExibidos2{
            margin-bottom: 12px;
        }

        #dadosExibidos2{
            justify-content: center;
        }

        #map {
            height: 400px;
            width: 60%;
            border-radius: 8px;
        }

        .map-container{
            display: flex;
            justify-content: space-around;
        }

        .card{
            border: 1px solid #ddd;
            padding: 0px
        }

        .cards{
            display: flex;
            flex-direction: column;
            width: 35%;
            gap: 10px;
        }
        .card-body{
            padding: 10px 15px;
        }
        .card-header{
            padding: 10px;
        }

        h2{
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        p{
            font-size: 0.9rem;
            font-weight: 200;
            color: #777;
        }
        .row{
            margin-top: 15px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px 0 10px;
        }
        .buttons{
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            overflow: hidden !important;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            position: relative;
        }

        .modal-content h3 {
            margin-top: 0;
        }

        .modal-content input, select {
            width: 100%;
            margin-top: 0px;
            padding: 8px;
        }

        .modal-buttons {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .modal-buttons button {
            padding: 8px 12px;
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
                <h1>Início</h1>
                <p>Visualize sua localização no mapa, assim como postos próximos.</p>
            </header>
            <div class="map-container">
                <div class="map" id="map"></div>
                <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" 
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-navigation">
                                <polygon points="3 11 22 2 13 21 11 13 3 11" />
                            </svg> Viagem atual</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($viagemAtual) { ?>
                            <h4>Origem</h4>
                            <p><?= htmlspecialchars($viagemAtual['enderecoOrigem']) ?></p>
                            <h4>Destino</h4>
                            <p><?= htmlspecialchars($viagemAtual['enderecoDestino']) ?></p>
                            <div class="row">
                                <div>
                                    <h4>Início</h4>
                                    <p><?= date('d/m/Y', strtotime($viagemAtual['data_inicio'])) ?></p>
                                </div>
                                <div>
                                    <h4>Término</h4>
                                    <p><?= !empty($viagemAtual['data_termino']) ? date('d/m/Y', strtotime($viagemAtual['data_termino'])) : 'Indefinido' ?></p>
                                </div>
                            </div>
                            <div class="buttons">
                                <button id="registrarPagamento" class="btn primary">
                                    Registrar pagamento
                                </button>
                                <button id="finalizarViagem" class="btn">
                                    Finalizar Viagem
                                </button>
                            </div>
                        <?php } else { ?>
                            <p>Nenhuma viagem atual encontrada.</p>
                        <?php } ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-calendar">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg> Próxima viagem</h2>
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

    <div id="qrModal" class="modal">
        <div class="modal-content">
        <form onsubmit="cadastrarPagamento()" method="POST" action="pagamento_cadastrar.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>"> 

            <h3 style="font-weight: 600; color: #2563eb; font-size: 1.3rem">Registrar Pagamento</h3>
            <div id="qr-reader"></div>
            <div class="hidden" id="dadosExibidos">
                <div>
                    <p style="font-weight: 400; color: #333">Destinatário</p>
                    <p name="destinatarioLido" id="destinatarioLido"></p>
                    
                </div>
                <div>
                    <p style="font-weight: 400; color: #333">Valor</p>
                    <p name="valorLido" id="valorLido"></p>
                </div>
            </div>
            <!-- <div class="hidden" id="dadosExibidos2"> -->
                <!-- <div>
                    <p style="font-weight: 400; color: #333">Cidade da conta</p>
                    <p name="cidade" id=""></p>
                </div> -->
                <!-- <div>
                    <p style="font-weight: 400; color: #333">PIX</p>
                    <p name="chavePIX" id=""></p>
                </div> -->
            <!-- </div> -->
            <div id="postForm" class="hidden">
                <input type="hidden" id="idusuario" name="idusuario" value="">
                <input type="hidden" id="idviagem" name="idviagem" value="">
                <input type="hidden" id="valor" name="valor" value="">
                <input type="hidden" id="destinatarioLidoInput" name="destinatarioLidoInput" value="">
                <input type="hidden" id="latitude" name="latitude" value="">
                <input type="hidden" id="longitude" name="longitude" value="">
                <label>Posto</label>
                <select name="postoSelecionado" id="postoSelecionado">
                    <option value="0" disabled selected>Carregando postos próximos...</option>
                </select>
                <label>Litragem</label>
                <input style="margin-top: 0px" placeholder="Coloque a litragem" name="litragem"><br>
                <small id="coordenadasTexto" style="font-weight: 400; color: #333">Coordenadas: </small>
            </div>

            <div class="modal-buttons">
                <button id="cancelar" type="button" class="btn">Cancelar</button>
                <button type="submit" id="confirmar" class="btn primary hidden">Confirmar</button>
            </div>
            </form>
        </div>
    </div>

<script src="../../js/index.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script type="module">
    import { parsePix } from 'https://cdn.skypack.dev/pix-utils'

    const modal = document.getElementById("qrModal")

    function abrirModal() {
        modal.style.display = "flex";

        startQR();
    }

    function finalizarViagem() {
        Swal.fire({
            title: "Tem certeza?",
            text: "Esta ação irá encerrar a viagem atual!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sim, finalizar!"
        }).then((result) => {
            if (result.isConfirmed) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        const form = document.createElement("form");
                        form.method = "POST";
                        form.action = "finalizar_viagem.php";

                        const inputs = {
                            idtransportadora: "<?php echo $_GET['idtransportadora']; ?>",
                            latitude: latitude,
                            longitude: longitude
                        };

                        for (const key in inputs) {
                            const input = document.createElement("input");
                            input.type = "hidden";
                            input.name = key;
                            input.value = inputs[key];
                            form.appendChild(input);
                        }

                        document.body.appendChild(form);
                        form.submit();
                    }, function(error) {
                        Swal.fire("Erro", "Não foi possível obter sua localização.", "error");
                    });
                } else {
                    Swal.fire("Erro", "Geolocalização não é suportada neste navegador.", "error");
                }
            }
        });
    }

    document.querySelector('#finalizarViagem').addEventListener('click', () =>{
        finalizarViagem()
    })

    let html5QrCode;

    function startQR() {
        html5QrCode = new Html5Qrcode("qr-reader");

        function fecharModal() {
            modal.style.display = "none";
            document.querySelector('[name="destinatarioLido"]').textContent = ''
            document.querySelector('[name="valorLido"]').textContent = ''
            document.querySelector('#postForm').classList.add('hidden')
            document.querySelector('#confirmar').classList.add('hidden')
            document.querySelector('#dadosExibidos').classList.remove('row')
            document.querySelector('#dadosExibidos').classList.add('hidden')
            html5QrCode.stop().then(() => {}).catch(err => {})
        }

        document.querySelector('#cancelar').addEventListener('click', () => {
            fecharModal()
        })

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                html5QrCode.start(
                    cameras[0].id,
                    { fps: 10, qrbox: 250 },
                    qrCodeMessage => {
                        const dados = parsePix(qrCodeMessage)
                        console.log(dados)
                        html5QrCode.stop();

                        if (!dados.merchantName) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'QR code inválido',
                                text: 'O QR code não corresponde a um payload PIX.',
                                confirmButtonColor: '#2563eb'
                            })
                            fecharModal()
                            return
                        }

                        document.querySelector('[name="destinatarioLido"]').textContent = dados.merchantName
                        document.querySelector('[name="valorLido"]').textContent = dados.transactionAmount
                        document.getElementById('idviagem').value = <?= json_encode($viagemAtual ? $viagemAtual['idviagem'] : null) ?>;
                        document.querySelector('[name="idusuario"]').value = <?= $_SESSION['id'] ?>;
                        document.querySelector('[name="valor"]').value = dados.transactionAmount
                        document.querySelector('[name="destinatarioLidoInput"]').value = dados.merchantName

                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(position => {
                                const lat = position.coords.latitude.toFixed(6);
                                const lng = position.coords.longitude.toFixed(6);

                                document.querySelector('[name="latitude"]').value = lat;
                                document.querySelector('[name="longitude"]').value = lng;

                                document.querySelector('#coordenadasTexto').textContent += `${lat}, ${lng}`;
                            }, error => {
                                console.error("Erro ao obter localização:", error);
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Localização indisponível',
                                    text: 'Não foi possível obter sua localização.',
                                    confirmButtonColor: '#2563eb'
                                });
                            });
                        }

                        document.querySelector('#postForm').classList.remove('hidden')
                        document.querySelector('#confirmar').classList.remove('hidden')
                        document.querySelector('#dadosExibidos').classList.add('row')
                    },
                    errorMessage => {}
                ).catch(err => {
                    alert("Erro ao iniciar câmera.")
                })
            }
        }).catch(err => {
            alert("Nenhuma câmera disponível.")
        })
    }

    document.querySelector('#registrarPagamento').addEventListener('click', abrirModal);
                            
    mapboxgl.accessToken = 'pk.eyJ1IjoibHVjYXM1NTVhbmRyaWFuaSIsImEiOiJjbWJhMDBqYm0wNW5rMmxvbDl5eHcyYXRnIn0.PCgnmuGP-tgdJity6h2LUg';

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

                (async () => {
                    const responseSelect = await fetch(`buscar_postos.php?lat=${latitude}&lng=${longitude}&raio=5`);
                    if (!responseSelect.ok) {
                        alert('Erro ao buscar postos para seleção.');
                        return;
                    }
                    const postosSelect = await responseSelect.json();

                    const selectElement = document.getElementById('postoSelecionado');
                    selectElement.innerHTML = ''; // limpa as opções anteriores

                    if (postosSelect.length === 0) {
                        selectElement.innerHTML = '<option value="0" disabled selected>Nenhum posto próximo encontrado</option>';
                    } else {
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '0';
                        defaultOption.disabled = true;
                        defaultOption.selected = true;
                        defaultOption.textContent = 'Selecione o posto em que vai ser realizado o pagamento';
                        selectElement.appendChild(defaultOption);

                        postosSelect.forEach(posto => {
                            const option = document.createElement('option');
                            option.value = posto.idposto;
                            option.textContent = `${posto.nome} - ${posto.endereco}`;
                            selectElement.appendChild(option);
                        });
                    }

                    // SVG do marcador
                    const svgPosto = `<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 64 64" fill="none" stroke="#000000" stroke-width="2" stroke-linejoin="round" stroke-linecap="round">
                        <rect x="14" y="12" width="24" height="40" rx="4" ry="4" fill="#e63946" stroke="#000"/>
                        <rect x="20" y="18" width="12" height="12" rx="2" ry="2" fill="#f1faee" stroke="#000"/>
                        <path d="M38 14h6v24h-4" stroke="#000" fill="none"/>
                        <rect x="42" y="36" width="6" height="8" rx="1" ry="1" fill="#1d3557" stroke="#000"/>
                        <line x1="26" y1="38" x2="26" y2="46" stroke="#000"/>
                        <line x1="32" y1="38" x2="32" y2="46" stroke="#000"/>
                    </svg>`;

                    function createSVGElementFromString(svgString) {
                        const div = document.createElement('div');
                        div.innerHTML = svgString.trim();
                        return div.firstChild;
                    }

                    const responseMapa = await fetch(`buscar_postos.php?lat=${latitude}&lng=${longitude}`);
                    if (!responseMapa.ok) {
                        alert('Erro ao buscar postos para o mapa.');
                        return;
                    }
                    const postosMapa = await responseMapa.json();

                    postosMapa.forEach(posto => {
                        const svgElement = createSVGElementFromString(svgPosto);
                        let tabelaCombustiveis = `
                            <table style="width:100%; border-collapse: collapse; font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th style="text-align:left; padding: 4px;">Tipo</th>
                                        <th style="text-align:right; padding: 4px;">Preço</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `

                        posto.combustiveis.forEach(c => {
                            let tipo
                            switch (c.tipo) {
                                case 1: tipo = 'Gasolina'; break;
                                case 2: tipo = 'Etanol'; break;
                                case 3: tipo = 'Diesel'; break;
                                default: tipo = 'Outro';
                            }

                            tabelaCombustiveis += `
                                <tr>
                                    <td style="padding: 4px;">${tipo}</td>
                                    <td style="text-align:right; padding: 4px;">R$ ${parseFloat(c.preco).toFixed(2)}</td>
                                </tr>
                            `
                        });

                        tabelaCombustiveis += `
                                </tbody>
                            </table>
                        `

                        const popupHTML = `
                            <strong>${posto.nome}</strong><br>
                            Distância: ${posto.distancia.toFixed(2)} km
                            <hr style="margin: 8px 0;">
                            ${tabelaCombustiveis}
                        `
                        new mapboxgl.Marker({ element: svgElement, anchor: "bottom" })
                        .setLngLat([posto.longitude, posto.latitude])
                        .setPopup(new mapboxgl.Popup().setHTML(popupHTML))
                        .addTo(map);
                    })
                })()
                if (typeof destinoViagem !== 'undefined') {
                    const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${longitude},${latitude};${destinoViagem.longitude},${destinoViagem.latitude}?geometries=geojson&access_token=${mapboxgl.accessToken}`
//
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            const route = data.routes[0].geometry;

                            map.addSource('route', {
                                type: 'geojson',
                                data: {
                                    type: 'Feature',
                                    geometry: {
                                        type: 'LineString',
                                        coordinates: route.coordinates
                                    }
                                }
                            });

                            map.addLayer({
                                id: 'route',
                                type: 'line',
                                source: 'route',
                                layout: {
                                    'line-join': 'round',
                                    'line-cap': 'round'
                                },
                                paint: {
                                    'line-color': '#0074D9',
                                    'line-width': 4
                                }
                            });

                            // Adiciona marcador no destino
                            new mapboxgl.Marker({ color: 'green' })
                                .setLngLat([destinoViagem.longitude, destinoViagem.latitude])
                                .setPopup(new mapboxgl.Popup().setHTML("<strong>Destino da viagem</strong>"))
                                .addTo(map);
                        })
                        .catch(error => {
                            console.error('Erro ao buscar rota:', error);
                        });
                }
            })
            

        }, function(error) {
            alert("Erro ao obter localização: " + error.message);
        });
    } else {
        alert("Geolocalização não suportada pelo navegador.");
    }

    function validarFormularioPagamento() {
        const form = document.querySelector('#qrModal form');
        const postoSelecionado = document.getElementById('postoSelecionado');
        const litragemInput = form.querySelector('input[name="litragem"]');
        const destinatario = document.getElementById('destinatarioLido');
        const valor = document.getElementById('valorLido');

        const postoValor = postoSelecionado.value;
        const litragemValor = litragemInput.value.trim();
        const destinatarioTexto = destinatario.textContent.trim();
        const valorTexto = valor.textContent.trim();

        if (!destinatarioTexto) {
            Swal.fire({
                icon: 'warning',
                title: 'QR code não lido',
                text: 'Você precisa escanear um QR code válido antes de confirmar.',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }

        if (!valorTexto) {
            Swal.fire({
                icon: 'warning',
                title: 'Valor não detectado',
                text: 'O valor do pagamento não foi identificado.',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }

        if (!postoValor || postoValor === '0') {
            Swal.fire({
                icon: 'warning',
                title: 'Posto não selecionado',
                text: 'Por favor, selecione um posto antes de confirmar.',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }

        if (isNaN(litragemValor) || Number(litragemValor) <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Litragem inválida',
                text: 'Insira uma litragem válida maior que 0.',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }
    }
</script>

</body>
</html>
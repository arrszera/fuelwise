<?php 
    include('autenticacaoGerente.php');
    include('../../elements/connection.php');
    
    $query = "SELECT p.idpagamento, po.latitude, po.nome AS nome_posto, po.endereco AS endereco_posto, po.longitude, p.litragem, p.valor, p.destinatario, p.cpfPagador, u.nome AS nome_usuario, p.latitudePagamento, p.longitudePagamento, p.idposto 
              FROM pagamento AS p 
              JOIN usuario AS u ON p.idusuario = u.idusuario 
              JOIN posto AS po ON po.idposto = p.idposto
              WHERE p.idtransportadora = ".$_GET['idtransportadora'];

    $resultado = $conn->query($query);
    
    $requests = [];
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $idpagamento = (int)$row['idpagamento'];

            if (!isset($requests[$idpagamento])) {
                $requests[$idpagamento] = [
                    'idpagamento' => $idpagamento,
                    'litragem' => $row['litragem'],
                    'valor' => $row['valor'],
                    'destinatario' => $row['destinatario'],
                    'cpfPagador' => $row['cpfPagador'],
                    'nome_usuario' => $row['nome_usuario'],
                    'latitudePagamento' => $row['latitudePagamento'],
                    'longitudePagamento' => $row['longitudePagamento'],
                    'idposto' => $row['idposto'],
                    'latitude_posto' => $row['latitude'],
                    'longitude_posto' => $row['longitude'],
                    'endereco_posto' => $row['endereco_posto'],
                    'nome_posto' => $row['nome_posto'],
                ];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Pagamentos Cadastrados</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../css/solicitacoes_v2.css" rel="stylesheet">
    <link href="../../css/index.css" rel="stylesheet">
    <link href="../../css/header.css" rel="stylesheet">
    <link href="../../css/sidebar.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <?php 
            include('../../elements/sidebar.php'); 
            include('../../elements/alert.php');
        ?>
    </div>
    <div class="main">
        <?php include('../../elements/header.php'); ?>
        <div class="content">
            <header class="page-header">
                <h1>Pagamentos Cadastrados</h1>
                <p>Revise e gerencie os pagamentos cadastrados.</p>
            </header>
            <div class="search-wrapper">
                <div class="search-container">
                    <svg class="icon" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input
                    id="searchInput"
                    type="search"
                    placeholder="Buscar por destinatário ou CPF..."
                    class="search-input"
                    aria-label="Busca"
                    />
                </div>
                <button onclick="modalAdicionarPagamento()" class="btn primary">Adicionar novo pagamento</button>
            </div>
            <div class="table-wrapper">
                <table aria-label="Pagamentos cadastrados">
                    <thead>
                        <tr>
                            <th>Nome do Usuário</th>
                            <th>Destinatário</th>
                            <th>Valor</th>
                            <th>Litragem</th>
                            <th>CPF do Pagador</th>
                            <th class="w-120px">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Linhas serão inseridas via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!--  -->
    <div id="modalMapa" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Localização do Pagamento</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/index.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />

    <script>
        const requests = <?php echo json_encode($requests); ?>;

        const icons = {
            edit: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L9 17.713 4.5 19.5l1.787-4.5 10.575-11.513z"/>
                    </svg>`,
            x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`,
            map: `<svg width="24" height="24" viewBox="0 0 64 58" xmlns="http://www.w3.org/2000/svg" fill="green">
                    <path d="M32 6C23.163 6 16 13.163 16 22c0 10.5 13.5 27 16 30 2.5-3 16-19.5 16-30 0-8.837-7.163-16-16-16zm0 22a6 6 0 1 1 0-12 6 6 0 0 1 0 12z"/>
                </svg>
                `
        }

        function fecharModal() {
            document.querySelectorAll('.modal').forEach(element => {
                element.style.display = 'none'
            })
        }
        
        function modalAdicionarPagamento() {
            document.getElementById('modalAdicionarPagamento').style.display = 'block'
        }

        function abrirMapa(latitudePagamento, longitudePagamento, latitudePosto, longitudePosto, nomePosto, enderecoPosto, idposto) {
    document.getElementById('modalMapa').style.display = 'block';

    (async function () {
        mapboxgl.accessToken = 'pk.eyJ1IjoibHVjYXM1NTVhbmRyaWFuaSIsImEiOiJjbWJhMDBqYm0wNW5rMmxvbDl5eHcyYXRnIn0.PCgnmuGP-tgdJity6h2LUg';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [longitudePagamento, latitudePagamento],
            zoom: 14
        });

        map.addControl(new mapboxgl.NavigationControl());

        const svgPosto =  `<svg
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
                    </svg>`
        const svgPostoEl = document.createElement('div');
        svgPostoEl.innerHTML = svgPosto;
        const svgElement = svgPostoEl.firstElementChild;

        new mapboxgl.Marker({ color: 'red' })
            .setLngLat([longitudePagamento, latitudePagamento])
            .setPopup(new mapboxgl.Popup().setHTML("<strong>Local do Pagamento</strong>"))
            .addTo(map);

        new mapboxgl.Marker({ element: svgElement })
            .setLngLat([longitudePosto, latitudePosto])
            .setPopup(new mapboxgl.Popup().setHTML(`<strong>${nomePosto}</strong><br>${enderecoPosto}`))
            .addTo(map);

        const bounds = new mapboxgl.LngLatBounds();
        bounds.extend([longitudePagamento, latitudePagamento]);
        bounds.extend([longitudePosto, latitudePosto]);
        map.fitBounds(bounds, { padding: 20 });

    })().catch(function (error) {
        alert("Erro ao obter localização: " + error.message);
    });
}

        function renderTable(filtered) {
            const tbody = document.getElementById('tableBody')
            tbody.innerHTML = ''

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="6">Nenhum pagamento encontrado.</td></tr>`
                return
            }

            filtered.forEach(req => {
                const tr = document.createElement('tr')

                let html = `
                <td class="font-medium">${req.nome_usuario}</td>
                <td>${req.destinatario}</td>
                <td>${req.valor}</td>
                <td>${req.litragem}</td>
                <td>${req.cpfPagador}</td>
                <td>
                    <div class="actions">
                        <button onclick='abrirMapa(${req.latitudePagamento}, ${req.longitudePagamento}, ${req.latitude_posto}, ${req.longitude_posto}, ${JSON.stringify(req.nome_posto)}, ${JSON.stringify(req.endereco_posto)}, ${req.idposto})' class="btn-icon btn-map" title="Ver no Mapa">
                            ${icons.map}
                        </button>

                        <button class="btn-icon btn-edit" title="Editar pagamento" data-idpagamento="${req.idpagamento}">
                            ${icons.edit}
                        </button>
                        <button onclick='excluirPagamento(${req.idpagamento})' class="btn-icon btn-deny" title="Excluir">
                            ${icons.x}
                        </button>
                    </div>
                </td>
                `
                tr.innerHTML = html
                tbody.appendChild(tr)
            })
        }
                
        renderTable(Object.values(requests))
            
        const searchInput = document.getElementById('searchInput')
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase()
            const filtered = Object.values(requests).filter(r =>
                r.destinatario.toLowerCase().includes(term) ||
                r.cpfPagador.toLowerCase().includes(term)
            )
            renderTable(filtered)
        })

    </script>
</body>
</html>

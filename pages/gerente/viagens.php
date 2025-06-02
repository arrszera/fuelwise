<?php 
    include('autenticacaoGerente.php');

    include('../../elements/connection.php');
    
    $query = "SELECT * FROM viagem 
    JOIN usuario ON viagem.idusuario = usuario.idusuario
    JOIN veiculo ON viagem.idveiculo = veiculo.idveiculo
    JOIN transportadora_usuario ON usuario.idusuario = transportadora_usuario.idusuario
    WHERE transportadora_usuario.idtransportadora = " . (int)$_GET['idtransportadora'] . " ORDER BY idviagem DESC";  

    $resultado = $conn->query($query);
#    if ($resultado === false) {
#       die("Erro na consulta: " . $conn->error);
#    }
    
    $requests = [];
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $idviagem = (int)$row['idviagem'];

            if (!isset($requests[$idviagem])) {
                $requests[$idviagem] = [
                    'idviagem' => $idviagem,
                    'idusuario' => $row['idusuario'],
                    'idveiculo' => $row['idveiculo'],
                    'carga' => $row['carga'],
                    'peso' => $row['peso'],
                    'obs' => $row['obs'],
                    'data_inicio' => $row['data_inicio'],
                    'data_termino' => $row['data_termino'],
                    'nome' => $row['nome'],
                    'placa' => $row['placa'],
                    'enderecoOrigem' => $row['endereco_origem'],
                    'modelo' => $row['modelo'],
                    'status' => $row['status'],
                    'latitudeOrigem' => $row['latitude_origem'],
                    'longitudeOrigem' => $row['longitude_origem'],
                    'enderecoDestino' => $row['endereco_destino'],
                    'latitudeDestino' => $row['latitude_destino'],
                    'longitudeDestino' => $row['longitude_destino'],
                    'longitudeAtual' => $row['longitude_atual'],
                    'latitudeAtual' => $row['latitude_atual'],
                ];
            }

            $queryPagamentos = "
                SELECT 
                    pagamento.*, 
                    posto.nome AS nome_posto, 
                    posto.latitude AS latitude_posto, 
                    posto.longitude AS longitude_posto, 
                    usuario.nome AS nome_usuario,
                    transportadora.nome AS nome_transportadora,
                    viagem.idviagem
                    FROM pagamento
                    JOIN posto ON pagamento.idposto = posto.idposto
                    JOIN usuario ON pagamento.idusuario = usuario.idusuario
                    JOIN transportadora ON pagamento.idtransportadora = transportadora.idtransportadora
                    JOIN viagem ON pagamento.idviagem = viagem.idviagem
                    WHERE pagamento.idviagem = $idviagem
            ";

            $resultadoPagamentos = $conn->query($queryPagamentos);
    
            $pagamentos = [];
            if ($resultadoPagamentos && $resultadoPagamentos->num_rows > 0) {
                while($pagamento = $resultadoPagamentos->fetch_assoc()) {
                    $pagamentos[] = [
                        'idpagamento' => $pagamento['idpagamento'],
                        'idusuario' => $pagamento['idusuario'],
                        'idposto' => $pagamento['idposto'],
                        'nomePosto' => $pagamento['nome_posto'],
                        'nomeUsuario' => $pagamento['nome_usuario'],
                        'nomeTransportadora' => $pagamento['nome_transportadora'],
                        'idviagem' => $pagamento['idviagem'],
                        'idtransportadora' => $pagamento['idtransportadora'],
                        'litragem' => $pagamento['litragem'],
                        'valor' => $pagamento['valor'],
                        'distancia' => $pagamento['distanciaPercorrida'],
                        'data' => $pagamento['dataPagamento'],
                        'destinatario' => $pagamento['destinatario'],
                        'latitudePagamento' => $pagamento['latitudePagamento'],
                        'longitudePagamento' => $pagamento['longitudePagamento'],
                        'latitudePosto' => $pagamento['latitude_posto'],
                        'longitudePosto' => $pagamento['longitude_posto'],
                        'cpfPagador' => $pagamento['cpfPagador'],
                        'placa' => $requests[$idviagem]['placa'],
                    ];
                }
            }
            $requests[$idviagem]['pagamentos'] = $pagamentos;
        }
    } 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Viagens</title>
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
                <h1>Viagens</h1>
                <p>Revise e gerencie as viagens da transportadora.</p>
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
                    placeholder="Buscar por nome ou placa..."
                    class="search-input"
                    aria-label="Busca"
                    />
                </div>
                <button onclick="modalAdicionarViagem()" class="btn primary">Adicionar nova viagem</button>
            </div>
            <div class="table-wrapper">
                <table aria-label="Integrantes cadastrados">
                    <thead>
                        <tr>
                            <th>Motorista</th>
                            <th>Veículo</th>
                            <th>Modelo do Veículo</th>
                            <th>Carga</th>
                            <th>Peso</th>
                            <th>Data Início</th>
                            <th>Data Término</th>
                            <th>Status</th>
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

    <div id="modalAdicionarViagem" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Nova viagem</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="viagem_cadastrar.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>">

            <div class="form-group">
                <label for="nome">Motorista</label>
                <?php 
                    $id = (int)$_GET['idtransportadora'];
                    $sql3 = "SELECT usuario.idusuario, usuario.nome 
                            FROM usuario 
                            JOIN transportadora_usuario ON usuario.idusuario = transportadora_usuario.idusuario 
                            WHERE transportadora_usuario.idtransportadora = $id
                            AND usuario.gerente = 0
                            AND NOT EXISTS (
                                SELECT 1 FROM viagem 
                                WHERE viagem.idusuario = usuario.idusuario AND viagem.status = 0
                            )";

                    $motoristas = $conn->query($sql3);
                    if ($motoristas->num_rows > 0) {
                        echo '<select name="idusuario" id="idusuario">';
                        while ($row = $motoristas->fetch_assoc()) {
                            if ($row['idusuario'] == $_SESSION['id']){
                                echo '<option value="' . $row['idusuario'] . '">' . $row['nome'] . ' - Você</option>';
                                continue;
                            }
                            echo '<option value="' . $row['idusuario'] . '">' . $row['nome'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "<small>Nenhum motorista encontrado</small>";
                    }
                ?>
            </div>

            <div class="form-group">
                <label for="veiculo">Veículo</label>
                <?php 
                    $id = (int)$_GET['idtransportadora'];
                    $sql4 = "SELECT idveiculo, placa, modelo 
                            FROM veiculo 
                            WHERE idtransportadora = $id
                            AND NOT EXISTS (
                            SELECT 1 FROM viagem 
                            WHERE viagem.idveiculo = veiculo.idveiculo AND viagem.status = 0
                        )";
                    $veiculos = $conn->query($sql4);
                    if ($veiculos->num_rows > 0) {
                        echo '<select name="idveiculo" id="idveiculo">';
                        while ($row = $veiculos->fetch_assoc()) {
                            echo '<option value="' . $row['idveiculo'] . '">' . $row['placa'] . ' - ' . $row['modelo'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "<small>Nenhum veículo encontrado</small>";
                    }
                ?>
            </div>
                <div class="form-group">
                    <label for="carga">Carga</label>
                    <input placeholder="Escreva a carga da viagem" type="text" id="carga" name="carga" required>
                </div>
                <div class="form-group">
                    <label for="peso">Peso</label>
                    <input placeholder="Escreva o peso da carga" type="text" id="peso" name="peso" required>
                </div>
                <div class="form-group">
                    <label for="obs">Observação</label>
                    <input placeholder="Escreva uma observação da viagem" type="text" id="obs" name="obs">
                </div>
                <div class="form-group">
                    <label for="data_inicio">Data Início</label>
                    <input id="data_inicio" name="data_inicio" type="datetime-local" class="form-control">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="enderecoOrigem">Endereço de origem</label>
                        <input id="enderecoOrigem" placeholder="Rua, Estado, Bairro, País" name="enderecoOrigem" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="coordenadasOrigem">Coordenadas de origem</label>
                        <input id="coordenadasOrigem" name="coordenadasOrigem" placeholder="-123.123123, 123.123123123" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="enderecoDestino">Endereço do destino</label>
                        <input id="enderecoDestino" name="enderecoDestino" placeholder="Rua, Estado, Bairro, País" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="coordenadasDestino">Coordenadas do destino</label>
                        <input id="coordenadasDestino" name="coordenadasDestino" placeholder="-123.123123, 123.123123123" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn secondary" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalPagamentos" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; border-radius:8px; max-width:90%; width:1000px; padding:20px; position:relative; max-height:90vh; overflow-y:auto;">
            <h2 style="margin-bottom:20px;">Pagamentos da Viagem</h2>
            <button onclick="fecharModalPagamentos()" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:20px; cursor:pointer;">&times;</button>
            <table class="styled-table" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                <th>Nome do Usuário</th>
                <th>Destinatário</th>
                <th>Valor</th>
                <th>Litragem</th>
                <th>CPF</th>
                <th>Ações</th>
                </tr>
            </thead>
            <tbody id="modalPagamentosBody">
                <!-- Linhas vão ser adicionadas por JS -->
            </tbody>
            </table>
        </div>
    </div>

    <script>
        function getDateInSaoPaulo() {
            const date = new Date();
            const saoPauloOffset = -6 * 60;  
            const currentOffset = date.getTimezoneOffset();  

            const adjustedDate = new Date(date.getTime() + (currentOffset + saoPauloOffset) * 60000);

            const formattedDate = adjustedDate.toISOString().slice(0, 16);

            document.getElementById('data_inicio').value = formattedDate;
        }

        window.onload = getDateInSaoPaulo;
    </script>
    
    <div id="modalEditarViagem" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Viagem</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="viagem_editar.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>">
                <div class="form-group">
                    <label for="nome">Motorista</label>
                    <?php 
                        $sql3 = "SELECT usuario.idusuario, usuario.nome 
                            FROM usuario 
                            JOIN transportadora_usuario ON usuario.idusuario = transportadora_usuario.idusuario 
                            WHERE transportadora_usuario.idtransportadora = $id";
                        $motoristas = $conn->query($sql3);
                        if ($motoristas->num_rows > 0) {
                            echo '<select name="idusuario" id="idusuario">';
                            while ($row = $motoristas->fetch_assoc()) {
                                echo '<option value="' . $row['idusuario'] . '">' . $row['nome'] . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo "Nenhum motorista encontrado";
                        }
                    ?>
                </div>
            <div class="form-group">
                <label for="veiculo">Veículo</label>
                <?php 
                    $id = (int)$_GET['idtransportadora'];
                    $sql4 = "SELECT idveiculo, placa, modelo 
                            FROM veiculo 
                            WHERE idtransportadora = $id
                            AND NOT EXISTS (
                            SELECT 1 FROM viagem 
                            WHERE viagem.idveiculo = veiculo.idveiculo AND viagem.status = 0
                        )";
                    $veiculos = $conn->query($sql4);
                    if ($veiculos->num_rows > 0) {
                        echo '<select name="idveiculo" id="idveiculo">';
                        while ($row = $veiculos->fetch_assoc()) {
                            echo '<option value="' . $row['idveiculo'] . '">' . $row['placa'] . ' - ' . $row['modelo'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "<small>Nenhum veículo encontrado</small>";
                    }
                ?>
            </div>
                <div class="form-group">
                    <label for="peso">Peso</label>
                    <input placeholder="Escreva o peso da carga" type="text" id="peso" name="peso" required>
                </div>
                <div class="form-group">
                    <label for="obs">Observação</label>
                    <input placeholder="Escreva uma observação da viagem" type="text" id="obs" name="obs" >
                </div>
                <div class="form-group">
                    <label for="data_inicio">Data Início</label>
                    <input id="data_inicio" name="data_inicio" type="datetime-local" class="form-control">
                </div>
                <div class="form-group">
                    <label for="data_termino">Data Término</label>
                    <small>Opcional, pode ser editao ou preenchido a qualquer momento.</small>
                    <input id="data_termino" name="data_termino" type="datetime-local" class="form-control">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="enderecoOrigem">Endereço de origem</label>
                        <input id="enderecoOrigem" name="enderecoOrigem" placeholder="Rua, Estado, Bairro, País" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="coordenadasOrigem">Coordenadas do destino</label>
                        <input id="coordenadasOrigem" name="coordenadasOrigem" placeholder="-123.123123, 123.123123123" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="enderecoDestino">Endereço do destino</label>
                        <input id="enderecoDestino" name="enderecoDestino" placeholder="Rua, Estado, Bairro, País" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="coordenadasDestino">Coordenadas do destino</label>
                        <input id="coordenadasDestino" name="coordenadasDestino" placeholder="-123.123123, 123.123123123" class="form-control">
                    </div>
                </div>
                
                <input type="hidden" name="idviagem">

                <div class="modal-footer">
                    <button type="button" class="btn secondary" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalMapa" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Localização do Pagamento</h2>
                <span onclick="fecharModalMapa()" class="close">&times;</span>
            </div>
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    <div id="modalMapaTempoReal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Localização atual da viagem</h2>
                <span onclick="fecharModalMapaTempoReal()" class="close">&times;</span>
            </div>
            <div id="mapTempoReal" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    <div id="modalPagamento" class="modal" style="display: none;">
        <div class="modal-content" style="height: fit-content">
            <div class="modal-header">
                <h2>Detalhes do Pagamento</h2>
                <span onclick="fecharModalPagamento()" class="close">&times;</span>
            </div>

            <div class="modal-body">
                <div class="info-pagamento">
                    <p><strong>Usuário:</strong> <span id="detalheUsuario"></span></p>
                    <p><strong>Posto:</strong> <span id="detalhePosto"></span></p>
                    <p><strong>Veículo:</strong> <span id="detalheVeiculo"></span></p>
                    <p><strong>Litragem:</strong> <span id="detalheLitragem"></span> L</p>
                    <p><strong>Valor:</strong> R$ <span id="detalheValor"></span></p>
                    <p><strong>Distância Percorrida:</strong> <span id="detalheDistancia"></span> km</p>
                    <p><strong>Data do Pagamento:</strong> <span id="detalheData"></span></p>
                    <p><strong>Destinatário:</strong> <span id="detalheDestinatario"></span></p>
                    <p><strong>CPF do Pagador:</strong> <span id="detalheCpf"></span></p>
                </div>
            </div>
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
                    </svg>
                    `,
            x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`,
            save: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#2563eb" viewBox="0 0 24 24">
                        <path d="M17 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-2-4zm-1 16h-8v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4zm-1-10H9V5h6v4z"/>
                    </svg>
                    `,
            eye: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3"></circle><path d="M2 12c2-4 6-7 10-7s8 3 10 7c-2 4-6 7-10 7s-8-3-10-7z"></path></svg>`,
            map: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21 3 6"/>
                    <line x1="9" y1="3" x2="9" y2="18"/>
                    <line x1="15" y1="6" x2="15" y2="21"/>
                </svg>
                `,
            payment: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="green" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="14" x="2" y="5" rx="2"/>
                        <line x1="2" y1="10" x2="22" y2="10"/>
                    </svg>
                    `,
        }

        function fecharModalMapa() {
            document.getElementById('modalMapa').style.display = 'none'
        }

        function fecharModalMapaTempoReal(){
            document.getElementById('modalMapaTempoReal').style.display = 'none'
        }

        function fecharModal() {
            document.querySelectorAll('.modal').forEach(element => {
                element.style.display = 'none'
            })
        }
        
        function modalAdicionarViagem() {
            document.getElementById('modalAdicionarViagem').style.display = 'block'
        }

        const modalAdicionar = document.querySelector('#modalAdicionarViagem')
        modalAdicionar.querySelector('[name="enderecoOrigem"]').addEventListener('blur', () => {
            const endereco = document.querySelector('[name="enderecoOrigem"]').value;

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(endereco)}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const { lat, lon, display_name } = data[0];
                        console.log("Endereço encontrado:", display_name);
                        console.log("Latitude:", lat);
                        console.log("Longitude:", lon);
                        modalAdicionar.querySelector('[name="coordenadasOrigem"]').value = lat + ', ' + lon
                    } else {
                        console.log("Endereço não encontrado");
                    }
                })
                .catch(err => console.error("Erro:", err));
        });
        modalAdicionar.querySelector('[name="enderecoDestino"]').addEventListener('blur', () => {
            const endereco = modalAdicionar.querySelector('[name="enderecoDestino"]').value;

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(endereco)}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const { lat, lon, display_name } = data[0];
                        console.log("Endereço encontrado:", display_name);
                        console.log("Latitude:", lat);
                        console.log("Longitude:", lon);
                        modalAdicionar.querySelector('[name="coordenadasDestino"]').value = lat + ', ' + lon
                    } else {
                        console.log("Endereço não encontrado");
                    }
                })
                .catch(err => console.error("Erro:", err));
        });
        const modalEditar = document.querySelector('#modalEditarViagem')
        modalEditar.querySelector('[name="enderecoOrigem"]').addEventListener('blur', () => {
            const endereco = modalEditar.querySelector('[name="enderecoOrigem"]').value;

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(endereco)}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const { lat, lon, display_name } = data[0];
                        console.log("Endereço encontrado:", display_name);
                        console.log("Latitude:", lat);
                        console.log("Longitude:", lon);
                        modalEditar.querySelector('[name="coordenadasOrigem"]').value = lat + ', ' + lon
                    } else {
                        console.log("Endereço não encontrado");
                    }
                })
                .catch(err => console.error("Erro:", err));
        });
        modalEditar.querySelector('[name="enderecoDestino"]').addEventListener('blur', () => {
            const endereco = modalEditar.querySelector('[name="enderecoDestino"]').value;

            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(endereco)}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const { lat, lon, display_name } = data[0];
                        console.log("Endereço encontrado:", display_name);
                        console.log("Latitude:", lat);
                        console.log("Longitude:", lon);
                        modalEditar.querySelector('[name="coordenadasDestino"]').value = lat + ', ' + lon
                    } else {
                        console.log("Endereço não encontrado");
                    }
                })
                .catch(err => console.error("Erro:", err));
        });

        function abrirModalEditarViagem(dados) {
            const form = document.querySelector('#modalEditarViagem form')
            
            form.querySelector('[name="idusuario"]').value = dados.idusuario || ''
            form.querySelector('[name="peso"]').value = dados.peso || ''
            form.querySelector('[name="obs"]').value = dados.obs || ''
            form.querySelector('[name="data_inicio"]').value = dados.data_inicio || ''
            form.querySelector('[name="data_termino"]').value = dados.data_termino || ''
            form.querySelector('[name="enderecoOrigem"]').value = dados.enderecoOrigem || ''
            form.querySelector('[name="coordenadasOrigem"]').value = dados.latitudeOrigem + ', ' + dados.longitudeOrigem || ''
            form.querySelector('[name="enderecoDestino"]').value = dados.enderecoDestino || ''
            form.querySelector('[name="coordenadasDestino"]').value = dados.latitudeDestino + ', ' + dados.longitudeDestino || ''
            
            let hiddenId = form.querySelector('input[name="idviagem"]')
            hiddenId.value = dados.idviagem

            document.getElementById('modalEditarViagem').style.display = 'block'
        }

        function excluirViagem(idviagem) {
            Swal.fire({
                title: "Tem certeza?",
                text: "Esta ação excluirá permanentemente a viagem!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Sim, excluir!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `viagem_deletar.php?idviagem=${idviagem}&idtransportadora=` + <?= $_SESSION['idtransportadora'] ?>
                }
            })
        }

        function excluirPagamento(idpagamento){
            Swal.fire({
                title: "Tem certeza?",
                text: "Esta ação excluirá permanentemente o pagamento!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Sim, excluir!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `pagamento_deletar.php?idpagamento=${idpagamento}&idtransportadora=` + <?= $_SESSION['idtransportadora'] ?>
                }
            })
        }

        function abrirModalPagamentos(pagamentos) {
            const tbody = document.getElementById('modalPagamentosBody');
            tbody.innerHTML = '';

            if (pagamentos.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Nenhum pagamento encontrado.</td></tr>`;
            } else {
                pagamentos.forEach(req => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td data-label="Nome do usuário" class="font-medium">${req.nome || '-'}</td>
                        <td data-label="Nome do destinatário">${req.destinatario}</td>
                        <td data-label="Valor">R$ ${parseFloat(req.valor).toFixed(2)}</td>
                        <td data-label="Litragem">${parseFloat(req.litragem).toFixed(2)} L</td>
                        <td data-label="CPF">${req.cpfPagador}</td>
                        <td data-label="Ações">
                            <div class="actions">
                                <button onclick='abrirMapa(${req.latitudePagamento}, ${req.longitudePagamento}, ${req.latitudePosto}, ${req.longitudePosto}, ${JSON.stringify(req.nome_posto)}, ${JSON.stringify(req.endereco_posto)}, ${req.idposto})' class="btn-icon btn-map" title="Ver no Mapa">
                                    ${icons.map}
                                </button>
                                <button onclick='abrirModalDetalhesPagamentos(${JSON.stringify(req)})' class="btn-icon btn-eye" title="Ver detalhes do pagamento" data-idpagamento="${req.idpagamento}">
                                    ${icons.eye}
                                </button>
                                <button onclick='excluirPagamento(${req.idpagamento})' class="btn-icon btn-deny" title="Excluir">
                                    ${icons.x}
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            document.getElementById('modalPagamentos').style.display = 'flex';
        }

        function abrirModalDetalhesPagamentos(pagamentos){
            document.getElementById('detalheUsuario').innerText = pagamentos.nomeUsuario;
            document.getElementById('detalhePosto').innerText = pagamentos.nomePosto;
            document.getElementById('detalheVeiculo').innerText = pagamentos.placa;
            document.getElementById('detalheLitragem').innerText = pagamentos.litragem;
            document.getElementById('detalheValor').innerText = pagamentos.valor;
            document.getElementById('detalheDistancia').innerText = pagamentos.distancia;
            document.getElementById('detalheData').innerText = pagamentos.data;
            document.getElementById('detalheDestinatario').innerText = pagamentos.destinatario;
            document.getElementById('detalheCpf').innerText = pagamentos.cpfPagador;

            document.getElementById('modalPagamento').style.display = 'flex';

            const latitude = parseFloat(pagamentos.latitudePagamento);
            const longitude = parseFloat(pagamentos.longitudePagamento);
            initMap(latitude, longitude);
        }

        function fecharModalPagamento() {
            document.getElementById('modalPagamento').style.display = 'none';
        }

        function initMap(lat, lng) {
            document.getElementById('map').innerHTML = ''; // reset map container

            const map = L.map('map').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map).bindPopup('Local do pagamento').openPopup();

        }

        function fecharModalPagamentos() {
            document.getElementById('modalPagamentos').style.display = 'none';
        }

        function getStatusClass(status) {
            switch (parseInt(status)) {
                case 0:
                    return {'classe' : 'badge-pending', 'frase' : 'pendente'}
                case 1:
                    return {'classe' : 'badge-success', 'frase' : 'concluída'}
                default:
                    return ''
            }
        }
 
        function renderTable(filtered) {
            const tbody = document.getElementById('tableBody')
            tbody.innerHTML = ''

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="3">Nenhuma viagem encontrada.</td></tr>`
                return
            }

            filtered.forEach(req => {
                const tr = document.createElement('tr')
                const status = getStatusClass(req.status)

                let html = `
                <td data-label="Nome" class="font-medium">${req.nome}</td>
                <td data-label="Placa">${req.placa}</td>
                <td data-label="Modelo">${req.modelo}</td>
                <td data-label="Carga">${req.carga}</td>
                <td data-label="Peso">${req.peso}</td>
                <td data-label="Data de início">${req.data_inicio}</td>
                <td data-label="Data de término">${!req.data_termino || req.data_termino === '0000-00-00 00:00:00' ? 'Em andamento' : req.data_termino}</td>
                <td data-label="Status"><div class="badge ${status.classe}">${status['frase']}</div></td>
                <td data-label="Ações">
                    <div class="actions">
                    <button onclick='abrirMapaTempoReal(${JSON.stringify(req)})' class="btn-icon btn-map" title="Excluir">
                        ${icons.map}
                    </button>
                        <button class="btn-icon btn-edit" title="Editar viagem" data-idviagem="${req.idviagem}">
                            ${icons.edit}
                        </button>
                        <button onclick='abrirModalPagamentos(${JSON.stringify(req.pagamentos)})' class="btn-icon btn-view" title="Ver pagamentos da viagem" data-idviagem="${req.idviagem}">
                            ${icons.payment}
                        </button>
                        <button onclick='excluirViagem(${req.idviagem})' class="btn-icon btn-deny" title="Excluir">
                            ${icons.x}
                        </button>
                    </div>
                </td>
                `
                tr.innerHTML = html

                tbody.appendChild(tr)
            })
            document.querySelectorAll(".btn-edit").forEach(el => {
                const idviagem = el.getAttribute("data-idviagem")
                el.addEventListener("click", () => {
                    abrirModalEditarViagem(requests[idviagem])
                })
            })
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

        async function abrirMapaTempoReal(viagem) {
            console.log(viagem);
            document.getElementById('modalMapaTempoReal').style.display = 'block';

            mapboxgl.accessToken = 'pk.eyJ1IjoibHVjYXM1NTVhbmRyaWFuaSIsImEiOiJjbWJhMDBqYm0wNW5rMmxvbDl5eHcyYXRnIn0.PCgnmuGP-tgdJity6h2LUg';

            const map = new mapboxgl.Map({
                container: 'mapTempoReal',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [viagem.longitudeAtual, viagem.latitudeAtual],
                zoom: 14
            });

            map.addControl(new mapboxgl.NavigationControl());

            const origem = [viagem.longitudeAtual, viagem.latitudeAtual];
            const destino = [viagem.longitudeDestino, viagem.latitudeDestino];

            new mapboxgl.Marker({ color: 'red' })
                .setLngLat(origem)
                .setPopup(new mapboxgl.Popup().setHTML("<strong>Local do motorista</strong>"))
                .addTo(map);

            new mapboxgl.Marker({ color: 'green' })
                .setLngLat(destino)
                .setPopup(new mapboxgl.Popup().setHTML(`<strong>Destino</strong><br>${viagem.enderecoDestino}`))
                .addTo(map);

            const query = await fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${origem[0]},${origem[1]};${destino[0]},${destino[1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`);
            const data = await query.json();

            const route = data.routes[0].geometry;

            map.on('load', () => {
                map.addSource('route', {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'properties': {},
                        'geometry': route
                    }
                });

                map.addLayer({
                    'id': 'route',
                    'type': 'line',
                    'source': 'route',
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': '#0074D9',
                        'line-width': 5
                    }
                });

                const bounds = new mapboxgl.LngLatBounds();
                route.coordinates.forEach(coord => bounds.extend(coord));
                map.fitBounds(bounds, { padding: 20 });
            });

            setInterval(async () => {
                const response = await fetch(`pegar_localizacao.php?idviagem=${viagem.idviagem}&idtransportadora=` + <?= $_SESSION['idtransportadora'] ?>);
                const updatedViagem = await response.json();

                map.setCenter([updatedViagem.longitude_atual, updatedViagem.latitude_atual]);

                const marker = new mapboxgl.Marker({ color: 'red' })
                    .setLngLat([updatedViagem.longitude_atual, updatedViagem.latitude_atual])
                    .setPopup(new mapboxgl.Popup().setHTML("<strong>Local do motorista</strong>"))
                    .addTo(map);
                
                const bounds = new mapboxgl.LngLatBounds();
                bounds.extend([updatedViagem.longitude_atual, updatedViagem.latitude_atual]);
                map.fitBounds(bounds, { padding: 20 });
            }, 10000); 
        }

        // Verificacoes
        modalAdicionar.querySelector('form').addEventListener('submit', function(event) {
            const idusuario = modalAdicionar.querySelector('#idusuario');
            const idveiculo = modalAdicionar.querySelector('#idveiculo');
            const carga = modalAdicionar.querySelector('#carga');
            const peso = modalAdicionar.querySelector('#peso');
            const obs = modalAdicionar.querySelector('#obs');
            const dataInicio = modalAdicionar.querySelector('#data_inicio');
            const enderecoOrigem = modalAdicionar.querySelector('#enderecoOrigem');
            const coordenadasOrigem = modalAdicionar.querySelector('#coordenadasOrigem');
            const enderecoDestino = modalAdicionar.querySelector('#enderecoDestino');
            const coordenadasDestino = modalAdicionar.querySelector('#coordenadasDestino');

            const idusuarioValor = idusuario.value.trim();
            const idveiculoValor = idveiculo.value.trim();
            const cargaValor = carga.value.trim();
            const pesoValor = peso.value.trim();
            const obsValor = obs.value.trim();
            const dataInicioValor = dataInicio.value.trim();
            const enderecoOrigemValor = enderecoOrigem.value.trim();
            const coordenadasOrigemValor = coordenadasOrigem.value.trim();
            const enderecoDestinoValor = enderecoDestino.value.trim();
            const coordenadasDestinoValor = coordenadasDestino.value.trim();

            if (!/^\d+$/.test(idusuarioValor)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Usuário inválido',
                    text: 'ID do usuário deve ser numérico.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    idusuario.focus();
                });
                return;
            }

            if (!/^\d+$/.test(idveiculoValor)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Veículo inválido',
                    text: 'ID do veículo deve ser numérico.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    idveiculo.focus();
                });
                return;
            }

            if (cargaValor.length === 0 || cargaValor.length > 100) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Carga inválida',
                    text: 'A carga deve conter entre 1 e 100 caracteres.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    carga.focus();
                });
                return;
            }

            if (isNaN(pesoValor) || parseFloat(pesoValor) <= 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peso inválido',
                    text: 'Informe um peso válido e positivo.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    peso.focus();
                });
                return;
            }

            if (obsValor.length > 100) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Observação inválida',
                    text: 'Observação deve ter no máximo 100 caracteres.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    obs.focus();
                });
                return;
            }

            if (!dataInicioValor || isNaN(Date.parse(dataInicioValor))) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data inválida',
                    text: 'Informe uma data de início válida.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    dataInicio.focus();
                });
                return;
            }

            if (!coordenadasOrigemValor.includes(',') || coordenadasOrigemValor.split(',').length !== 2) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Coordenadas de origem inválidas',
                    text: 'Informe latitude e longitude separados por vírgula.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasOrigem.focus();
                });
                return;
            }

            if (!coordenadasDestinoValor.includes(',') || coordenadasDestinoValor.split(',').length !== 2) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Coordenadas de destino inválidas',
                    text: 'Informe latitude e longitude separados por vírgula.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasDestino.focus();
                });
                return;
            }

            const [latOrigem, longOrigem] = coordenadasOrigemValor.split(',').map(val => val.trim());
            const [latDestino, longDestino] = coordenadasDestinoValor.split(',').map(val => val.trim());

            if (isNaN(latOrigem) || isNaN(longOrigem)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Latitude/Longitude de origem inválida',
                    text: 'As coordenadas de origem devem ser números válidos.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasOrigem.focus();
                });
                return;
            }

            if (isNaN(latDestino) || isNaN(longDestino)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Latitude/Longitude de destino inválida',
                    text: 'As coordenadas de destino devem ser números válidos.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasDestino.focus();
                });
                return;
            }
        });

        modalEditar.querySelector('form').addEventListener('submit', function(event) {
            const idusuario = modalEditar.querySelector('#idusuario');
            const idveiculo = modalEditar.querySelector('#idveiculo');
            const carga = modalEditar.querySelector('#carga');
            const peso = modalEditar.querySelector('#peso');
            const obs = modalEditar.querySelector('#obs');
            const dataInicio = modalEditar.querySelector('#data_inicio');
            const enderecoOrigem = modalEditar.querySelector('#enderecoOrigem');
            const coordenadasOrigem = modalEditar.querySelector('#coordenadasOrigem');
            const enderecoDestino = modalEditar.querySelector('#enderecoDestino');
            const coordenadasDestino = modalEditar.querySelector('#coordenadasDestino');

            const idusuarioValor = idusuario.value.trim();
            const idveiculoValor = idveiculo.value.trim();
            const cargaValor = carga.value.trim();
            const pesoValor = peso.value.trim();
            const obsValor = obs.value.trim();
            const dataInicioValor = dataInicio.value.trim();
            const enderecoOrigemValor = enderecoOrigem.value.trim();
            const coordenadasOrigemValor = coordenadasOrigem.value.trim();
            const enderecoDestinoValor = enderecoDestino.value.trim();
            const coordenadasDestinoValor = coordenadasDestino.value.trim();

            if (!/^\d+$/.test(idusuarioValor)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Usuário inválido',
                    text: 'ID do usuário deve ser numérico.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    idusuario.focus();
                });
                return;
            }

            if (!/^\d+$/.test(idveiculoValor)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Veículo inválido',
                    text: 'ID do veículo deve ser numérico.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    idveiculo.focus();
                });
                return;
            }

            if (cargaValor.length === 0 || cargaValor.length > 100) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Carga inválida',
                    text: 'A carga deve conter entre 1 e 100 caracteres.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    carga.focus();
                });
                return;
            }

            if (isNaN(pesoValor) || parseFloat(pesoValor) <= 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peso inválido',
                    text: 'Informe um peso válido e positivo.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    peso.focus();
                });
                return;
            }

            if (obsValor.length > 100) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Observação inválida',
                    text: 'Observação deve ter no máximo 100 caracteres.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    obs.focus();
                });
                return;
            }

            if (!dataInicioValor || isNaN(Date.parse(dataInicioValor))) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data inválida',
                    text: 'Informe uma data de início válida.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    dataInicio.focus();
                });
                return;
            }

            if (!coordenadasOrigemValor.includes(',') || coordenadasOrigemValor.split(',').length !== 2) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Coordenadas de origem inválidas',
                    text: 'Informe latitude e longitude separados por vírgula.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasOrigem.focus();
                });
                return;
            }

            if (!coordenadasDestinoValor.includes(',') || coordenadasDestinoValor.split(',').length !== 2) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Coordenadas de destino inválidas',
                    text: 'Informe latitude e longitude separados por vírgula.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasDestino.focus();
                });
                return;
            }

            const [latOrigem, longOrigem] = coordenadasOrigemValor.split(',').map(val => val.trim());
            const [latDestino, longDestino] = coordenadasDestinoValor.split(',').map(val => val.trim());

            if (isNaN(latOrigem) || isNaN(longOrigem)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Latitude/Longitude de origem inválida',
                    text: 'As coordenadas de origem devem ser números válidos.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasOrigem.focus();
                });
                return;
            }

            if (isNaN(latDestino) || isNaN(longDestino)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Latitude/Longitude de destino inválida',
                    text: 'As coordenadas de destino devem ser números válidos.',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    coordenadasDestino.focus();
                });
                return;
            }
        });
      
        renderTable(Object.values(requests))
            
        const searchInput = document.getElementById('searchInput')
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase()
            const filtered = Object.values(requests).filter(r =>
                r.nome.toLowerCase().includes(term) ||
                r.placa.toLowerCase().includes(term)
            )
            renderTable(filtered)
        })

    </script>
  </body>
  </html>   
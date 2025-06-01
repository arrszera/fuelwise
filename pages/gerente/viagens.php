
<?php 
    include('autenticacaoGerente.php');

    include('../../elements/connection.php');
    
            $query = "SELECT * FROM viagem 
            JOIN usuario ON viagem.idusuario = usuario.idusuario
            JOIN veiculo ON viagem.idveiculo = veiculo.idveiculo
            JOIN transportadora_usuario ON usuario.idusuario = transportadora_usuario.idusuario
            WHERE transportadora_usuario.idtransportadora = " . (int)$_GET['idtransportadora'] . "  ";  
  

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
                    'modelo' => $row['modelo'],
                    'enderecoOrigem' => $row['endereco_origem'],
                    'latitudeOrigem' => $row['latitude_origem'],
                    'longitudeOrigem' => $row['longitude_origem'],
                    'enderecoDestino' => $row['endereco_destino'],
                    'latitudeDestino' => $row['latitude_destino'],
                    'longitudeDestino' => $row['longitude_destino'],
                ];
            }
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
                <h1>Viagens Iniciadas</h1>
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
                            <th>Observação</th>
                            <th>Data Início</th>
                            <th>Data Término</th>
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
                            AND NOT EXISTS (
                            SELECT 1 FROM viagem 
                            WHERE viagem.idusuario = usuario.idusuario AND viagem.status = 0
                        )
                    ";
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
    
    <!-- TODO, permitir editar veiculo -->
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/index.js"></script>

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
                    `
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
                    window.location.href = `viagem_deletar.php?idviagem=${idviagem}&idtransportadora=` + <?php echo $_SESSION['idtransportadora'] ?>
                }
            })
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

                let html = `
                <td data-label="Nome" class="font-medium">${req.nome}</td>
                <td data-label="Placa">${req.placa}</td>
                <td data-label="Modelo">${req.modelo}</td>
                <td data-label="Carga">${req.carga}</td>
                <td data-label="Peso">${req.peso}</td>
                <td data-label="Observações">${req.obs}</td>
                <td data-label="Data de início">${req.data_inicio}</td>
                <td data-label="Data de término">${req.data_termino == 0 || !req.data_termino ? 'Em andamento' : req.data_termino}</td>
                <td data-label="Ações">
                    <div class="actions">
                        <button class="btn-icon btn-edit" title="Editar viagem" data-idviagem="${req.idviagem}">
                            ${icons.edit}
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
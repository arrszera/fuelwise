
<?php 
    include('autenticacaoGerente.php');

    include('../../elements/connection.php');
    
    $query = "SELECT * FROM veiculo 
    JOIN transportadora ON veiculo.idtransportadora  = transportadora.idtransportadora 
    WHERE transportadora.idtransportadora = ".$_GET['idtransportadora'];

    $resultado = $conn->query($query);
#    if ($resultado === false) {
#       die("Erro na consulta: " . $conn->error);
#    }
    
    $requests = [];
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $idveiculo = (int)$row['idveiculo'];

            if (!isset($requests[$idveiculo])) {
                $requests[$idveiculo] = [
                    'idveiculo' => $idveiculo,
                    'placa' => $row['placa'],
                    'modelo' => $row['modelo'],
                    'eixos' => $row['eixos'],
                    'litragem' => $row['litragem'],
                    'observacao' => $row['observacao'],
                ];
            }
        }
    } 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Veículos Cadastrados</title>
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
                <h1>Veículos Cadastrados</h1>
                <p>Revise e gerencie os veículos cadastrados.</p>
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
                    placeholder="Buscar por placa ou modelo..."
                    class="search-input"
                    aria-label="Busca"
                    />
                </div>
                <button onclick="modalAdicionarVeiculo()" class="btn primary">Adicionar novo veículo</button>
            </div>
            <div class="table-wrapper">
                <table aria-label="Integrantes cadastrados">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Eixos</th>
                            <th>Litragem</th>
                            <th>Observação</th>
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

    <div id="modalAdicionarVeiculo" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Novo Veículo</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="veiculo_cadastrar.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>">
                <div class="form-group">
                    <label for="placa">Placa do Veículo</label>
                    <input placeholder="Escreva a placa do veículo" type="text" id="placa" name="placa" required>
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input placeholder="Escreva o modelo do veículo" type="text" id="modelo" name="modelo" required>
                </div>
                <div class="form-group">
                    <label for="eixos">Eixos</label>
                    <input placeholder="Escreva o número de eixos do veículo" type="text" id="eixos" name="eixos" required>
                </div>
                <div class="form-group">
                    <label for="litragem">Litragem</label>
                    <input placeholder="Escreva a litragem do veículo" type="text" id="litragem" name="litragem" required>
                </div>
                <div class="form-group">
                    <label for="observacao">Observacao</label>
                    <input placeholder="Escreva a observacao do veículo" type="text" id="observacao" name="observacao" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn secondary" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    
    <div id="modalEditarVeiculo" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Veículo</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="veiculo_editar.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>">
                <div class="form-group">
                <label for="placa">Placa do Veículo</label>
                    <input placeholder="Escreva a placa do veículo" type="text" id="placa" name="placa" required>
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input placeholder="Escreva o modelo do veículo" type="text" id="modelo" name="modelo" required>
                </div>
                <div class="form-group">
                    <label for="eixos">Eixos</label>
                    <input placeholder="Escreva o número de eixos do veículo" type="text" id="eixos" name="eixos" required>
                </div>
                <div class="form-group">
                    <label for="litragem">Litragem</label>
                    <input placeholder="Escreva a litragem do veículo" type="text" id="litragem" name="litragem" required>
                </div>
                <div class="form-group">
                    <label for="observacao">Observacao</label>
                    <input placeholder="Escreva a observacao do veículo" type="text" id="observacao" name="observacao" >
                </div>
                <input type="hidden" name="idveiculo">
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
        
        function modalAdicionarVeiculo() {
            document.getElementById('modalAdicionarVeiculo').style.display = 'block'
        }

        function abrirModalEditarVeiculo(dados) {
            const form = document.querySelector('#modalEditarVeiculo form')
            
            form.querySelector('[name="placa"]').value = dados.placa || ''
            form.querySelector('[name="modelo"]').value = dados.modelo || ''
            form.querySelector('[name="eixos"]').value = dados.eixos || ''
            form.querySelector('[name="litragem"]').value = dados.litragem || ''
            form.querySelector('[name="observacao"]').value = dados.observacao || ''
            
            let hiddenId = form.querySelector('input[name="idveiculo"]')
            hiddenId.value = dados.idveiculo

            document.getElementById('modalEditarVeiculo').style.display = 'block'
        }

        function excluirVeiculo(idveiculo) {
            Swal.fire({
                title: "Tem certeza?",
                text: "Esta ação excluirá permanentemente o veículo!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Sim, excluir!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `veiculo_deletar.php?idveiculo=${idveiculo}&idtransportadora=` + <?php echo $_SESSION['idtransportadora'] ?>
                }
            })
        }
        
        function renderTable(filtered) {
            const tbody = document.getElementById('tableBody')
            tbody.innerHTML = ''

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="3">Nenhum veículo encontrado.</td></tr>`
                return
            }

            filtered.forEach(req => {
                const tr = document.createElement('tr')

                let html = `
                <td class="font-medium">${req.placa}</td>
                <td>${req.modelo}</td>
                <td>${req.eixos}</td>
                <td>${req.litragem}</td>
                <td>${req.observacao}</td>
                <td>
                    <div class="actions">
                        <button class="btn-icon btn-edit" title="Editar veiculo" data-idveiculo="${req.idveiculo}">
                            ${icons.edit}
                        </button>
                
                            <button onclick='excluirVeiculo(${req.idveiculo})' class="btn-icon btn-deny" title="Excluir">
                                ${icons.x}
                            </button>
                            
                    </div>
                </td>
                `
                tr.innerHTML = html

                tbody.appendChild(tr)
            })
            document.querySelectorAll(".btn-edit").forEach(el => {
                const idveiculo = el.getAttribute("data-idveiculo")
                el.addEventListener("click", () => {
                    abrirModalEditarVeiculo(requests[idveiculo])
                })
            })
        }
                
        renderTable(Object.values(requests))
            
        const searchInput = document.getElementById('searchInput')
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase()
            const filtered = Object.values(requests).filter(r =>
                r.placa.toLowerCase().includes(term) ||
                r.modelo.toLowerCase().includes(term)
            )
            renderTable(filtered)
        })

    document.addEventListener('DOMContentLoaded', function() {
    const modalAdicionar = document.querySelector('#modalAdicionarVeiculo');
    if (!modalAdicionar) return;

    modalAdicionar.querySelector('form').addEventListener('submit', function(event) {
        const placa = modalAdicionar.querySelector('#placa');
        const modelo = modalAdicionar.querySelector('#modelo');
        const eixos = modalAdicionar.querySelector('#eixos');
        const litragem = modalAdicionar.querySelector('#litragem');

        const placaValor = placa.value.trim();
        const modeloValor = modelo.value.trim();
        const eixosValor = eixos.value.trim();
        const litragemValor = litragem.value.trim();

        if (placaValor.length != 7) {
            event.preventDefault()
            Swal.fire({
                icon: 'warning',
                title: 'Placa inválida',
                text: 'Placa inválida.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                placa.focus()
            });
            return;
        }

        if (modeloValor.length < 3 || modeloValor.length > 45) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Modelo inválido',
                text: 'O modelo deve conter de 3 a 45 caracteres.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                modelo.focus()
            });
            return;
        }

        if (eixosValor != int  || eixosValor.length > 3) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Eixo inválido',
                text: 'Número de eixos inválido.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                eixos.focus()
            });
            return;
        }

        if (litragemValor.length <= 2) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Litragem inválida',
                text: 'Litragem inválido.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                litragem.focus()
            });
            return;
        }
    })

    const formEditar = document.querySelector('#modalEditarPosto')
    formEditar.querySelector('form').addEventListener('submit', function(event) {
        const placa = modalAdicionar.querySelector('#placa');
        const modelo = modalAdicionar.querySelector('#modelo');
        const eixos = modalAdicionar.querySelector('#eixos');
        const litragem = modalAdicionar.querySelector('#litragem');

        const placaValor = placa.value.trim();
        const modeloValor = modelo.value.trim();
        const eixosValor = eixos.value.trim();
        const litragemValor = litragem.value.trim();

        if (placaValor.length != 7) {
            event.preventDefault()
            Swal.fire({
                icon: 'warning',
                title: 'Placa inválida',
                text: 'Placa inválida.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                placa.focus()
            });
            return;
        }

        if (modeloValor.length < 3 || modeloValor.length > 45) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Modelo inválido',
                text: 'O modelo deve conter de 3 a 45 caracteres.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                modelo.focus()
            });
            return;
        }

        if (eixosValor != int  || eixosValor.length > 3) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Eixo inválido',
                text: 'Número de eixos inválido.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                eixos.focus()
            });
            return;
        }

        if (litragemValor.length <= 2) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Litragem inválida',
                text: 'Litragem inválido.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                litragem.focus()
            });
            return;
        }
    })
})
    </script>
  </body>
  </html>   
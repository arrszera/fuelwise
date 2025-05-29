<?php 
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include('../../elements/connection.php');
    
    $sql = "SELECT p.idposto, p.nome, p.endereco, c.idcombustivel, p.latitude, p.longitude, c.tipo, c.preco 
            FROM posto p    
            LEFT JOIN combustivel c ON p.idposto = c.idposto 
            ORDER BY p.idposto DESC";
    $result = $conn->query($sql);
    
    $requests = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $idposto = (int)$row['idposto'];

            if (!isset($requests[$idposto])) {
                $requests[$idposto] = [
                    'idposto' => $idposto,
                    'nome' => $row['nome'],
                    'endereco' => $row['endereco'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'combustiveis' => []
                ];
            }
            if (!empty($row['tipo'])) {
                $requests[$idposto]['combustiveis'][] = [
                    'idcombustivel' => $row['idcombustivel'],
                    'tipo' => $row['tipo'],
                    'preco' => $row['preco']
                ];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Postos Cadastrados</title>
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
                <h1>Postos Cadastrados</h1>
                <p>Revise e gerencie os postos cadastrados.</p>
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
                    placeholder="Buscar por nome ou endereço..."
                    class="search-input"
                    aria-label="Busca"
                    />
                </div>
                <button onclick="ModalAdicionarPosto()" class="btn primary">Adicionar novo posto</button>
            </div>
            <div class="table-wrapper">
                <table aria-label="Postos cadastrados">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Coordenadas</th>
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

    <div id="modalAdicionarPosto" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Novo Posto</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="posto_cadastrar.php">
                <div class="form-group">
                    <label for="nome">Nome do Posto</label>
                    <input placeholder="Escreva o nome do Posto" type="text" id="nome" name="nomePosto" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input placeholder="Escreva o endereço do posto" type="text" id="enderecoPosto" name="enderecoPosto" required>
                </div>
                <div class="form-group">
                    <label for="coordenadas">Coordenadas</label>
                    <input placeholder="Escreva as coordenadas do posto (latitude, longitude)" type="text" id="coordenadasPosto" name="coordenadasPosto" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn secondary" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditarPosto" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar dados do Posto</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="posto_alterar.php">
                <div class="form-group">
                    <label for="nome">Nome do Posto</label>
                    <input placeholder="Escreva o nome do Posto" type="text" id="nome" name="nomePosto" required minlength="2" maxlength="45">
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input placeholder="Escreva o endereço do posto" type="text" id="enderecoPosto" name="enderecoPosto" required minlength="7" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="coordenadas">Coordenadas</label>
                    <input placeholder="Escreva as coordenadas do posto (latitude, longitude)" type="text" id="coordenadasPosto" name="coordenadasPosto" required>
                </div>
                <input type="hidden" name="idposto">
                <div class="modal-footer">
                    <button type="button" class="btn secondary" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalCombustiveis" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Combustíveis do posto</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <div class="modal-footer">
                <button class="btn primary" onclick="abrirModalAdicionarCombustivel(this)">Adicionar novo</button>
            </div>
        </div>
    </div>
    
    <div id="modalAdicionarCombustivel" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Novo Combustível</h2>
                <span onclick="fecharModalCombustivel()" class="close">&times;</span>
            </div>
            <form method="POST" action="combustivel_cadastrar.php">
                <div class="form-group">
                    <label for="tipoCombustivel">Tipo de combustível</label>
                    <select name="tipoCombustivel" required>
                        <option value="" selected disabled>Selecione um tipo de combustível</option>
                        <option value="1">Diesel</option>
                        <option value="2">Etanol</option>
                        <option value="3">Gasolina</option>
                        <option value="4">Gasolina Aditivada</option>
                        <option value="5">Diesel S10</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="precoCombustivel">Preço</label>
                    <input placeholder="Escreva o preço do combustível" type="number" step="0.01" id="precoCombustivel" name="precoCombustivel" required>
                </div>
                <input type="hidden" name="idposto" id="idposto">
                <div class="modal-footer">
                    <button type="button" class="btn secondary" onclick="fecharModalCombustivel()">Cancelar</button>
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
            fuel: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                    <path d="M12 2C10.54 4.1 5 10.12 5 14.5C5 18.09 8.13 21 12 21C15.87 21 19 18.09 19 14.5C19 10.12 13.46 4.1 12 2ZM12 19C9.24 19 7 16.76 7 14.5C7 12.7 10.31 8.53 12 6.45C13.69 8.53 17 12.7 17 14.5C17 16.76 14.76 19 12 19Z"/>
                </svg>`,
            x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`,
            save: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#2563eb" viewBox="0 0 24 24">
                        <path d="M17 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-2-4zm-1 16h-8v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4zm-1-10H9V5h6v4z"/>
                    </svg>
                    `,
            edit: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L9 17.713 4.5 19.5l1.787-4.5 10.575-11.513z"/>
                    </svg>
                    `
        }

        document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function(event) {
        const nome = document.getElementById('nome');
        const endereco = document.getElementById('enderecoPosto');

        const nomeValor = nome.value.trim();
        const enderecoValor = endereco.value.trim();

        if (nomeValor.length < 2 || nomeValor.length > 45) {
            event.preventDefault(); // Impede o envio do formulário
            Swal.fire({
                icon: 'warning',
                title: 'Nome inválido',
                text: 'O nome do posto deve ter entre 2 e 45 caracteres.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                nome.focus();
            });
            return;
        }

        if (enderecoValor.length < 7 || enderecoValor.length > 100) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Endereço inválido',
                text: 'Digite um endereço válido.',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                endereco.focus();
            });
            return;
        }
    });
});


        function ModalAdicionarPosto() {
            document.getElementById('modalAdicionarPosto').style.display = 'block';
        }

        function abrirModalEditarPosto(dados){
            const modal = document.getElementById('modalEditarPosto')

            modal.querySelector('#nomePosto').value = dados.nome
            modal.querySelector('#enderecoPosto').value = dados.endereco
            modal.querySelector('[name="coordenadasPosto"]').value = dados.latitude + ', ' + dados.longitude
            modal.querySelector('[name="idposto"]').value = dados.idposto

            modal.style.display = 'block'
        }
        const modaEditar = document.querySelector('#modalEditarPosto')
        const elemento = modaEditar.querySelector('[name="enderecoPosto"]')
        elemento.addEventListener('blur', () => {
            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(elemento.value)}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const { lat, lon, display_name } = data[0];
                        modaEditar.querySelector('[name="coordenadasPosto"]').value = lat + ', ' + lon
                        console.log("Endereço encontrado:", display_name);
                        console.log("Latitude:", lat);
                        console.log("Longitude:", lon);
                    } else {
                        console.log("Endereço não encontrado");
                    }
                })
                .catch(err => console.error("Erro:", err));
        })
        const modalAdicionar = document.querySelector('#modalAdicionarPosto')
        const elemento2 = modalAdicionar.querySelector('[name="enderecoPosto"]')
        elemento2.addEventListener('blur', () => {
            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(elemento2.value)}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const { lat, lon, display_name } = data[0];
                        modalAdicionar.querySelector('[name="coordenadasPosto"]').value = lat + ', ' + lon
                        console.log("Endereço encontrado:", display_name);
                        console.log("Latitude:", lat);
                        console.log("Longitude:", lon);
                    } else {
                        console.log("Endereço não encontrado");
                    }
                })
                .catch(err => console.error("Erro:", err));
        })
        
        function abrirModalCombustiveis(combustiveis, idposto) {
            const modal = document.getElementById('modalCombustiveis')
            const modalAdicionar = document.getElementById('modalAdicionarCombustivel')
            const content = modal.querySelector('.modal-content')
            modalAdicionar.querySelector('#idposto').value = idposto
            
            const oldTable = content.querySelector('table')
            if (oldTable) oldTable.remove()
            
            const table = document.createElement('table')
            table.classList.add('modal-table') 
            
            table.innerHTML = `
            <thead> 
                <tr>
                    <th>Tipo</th>
                    <th>Preço (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            ${combustiveis.length > 0 ? combustiveis.map(c => {
                let tipoCombustivel = pegarCombustivel(c.tipo)
                
                return `
                <tr>
                    <td>${tipoCombustivel}</td>
                    <td><input type="number" step="0.01" value='${parseFloat(c.preco).toFixed(2)}' id='preco-${c.idcombustivel}'></td>
                    <td>
                        <div class="actions">
                            <button onclick='excluirCombustivel(${c.idcombustivel})' class="btn-icon btn-deny" title="Excluir">
                            ${icons.x}
                            </button>
                            <button onclick='salvarCombustivel(${c.idcombustivel})' class="btn-icon" title="Salvar alterações">
                            ${icons.save}
                            </button>
                        </div>
                    </td>
                </tr>`;
            }).join('') :
            `<tr><td colspan="2">Nenhum combustível cadastrado.</td></tr>`
            } ` // condicional na mesma linha
            
            content.appendChild(table)
            
            modal.style.display = 'block'
        }

        function adicionarCombustivel(){
            window.href.location = `combustivel_cadastrar.php`
        }
        
        function salvarCombustivel(idcombustivel){
            const precoInput = document.getElementById(`preco-${idcombustivel}`);
            const novoPreco = parseFloat(precoInput.value).toFixed(2);
            
            if (isNaN(novoPreco) || novoPreco <= 0) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Por favor, insira um valor válido para o preço.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return;
            }
            
            window.location.href = `combustivel_cadastrar.php?idcombustivel=${idcombustivel}&precoCombustivel=${novoPreco}`
        }

        function excluirCombustivel(idcombustivel){
            Swal.fire({
                title: 'Excluir combustível',
                text: 'Você tem certeza que deseja excluir esse combustível?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Não, cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `combustivel_deletar.php?id=${idposto}`;
                }
            });        
        }
        
        function abrirModalAdicionarCombustivel(botao){
            const idposto = botao.id
            
            let modal = document.getElementById('modalAdicionarCombustivel')
            modal.style.display = 'block'
            modal.value = idposto
        }
        
        function fecharModal() {
            document.querySelectorAll('.modal').forEach(element => {
                element.style.display = 'none';
            });
        }
        
        function excluirPosto(idposto) {
            Swal.fire({
                title: "Tem certeza?",
                text: "Esta ação excluirá permanentemente o posto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Sim, excluir!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `posto_deletar.php?id=${idposto}`;
                }
            });
        }
        
        function renderTable(filtered) {
            const tbody = document.getElementById('tableBody')
            tbody.innerHTML = ''

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="3">Nenhum posto encontrado.</td></tr>`
                return
            }

            filtered.forEach(req => {
                const tr = document.createElement('tr')

                tr.innerHTML = `
                <td class="font-medium">${req.nome}</td>
                <td>${req.endereco}</td>
                <td>${req.latitude}, ${req.longitude}</td>
                <td>
                    <div class="actions">
                        <button class="btn-icon btn-view" title="Ver combustíveis" data-idposto="${req.idposto}">
                            ${icons.fuel}
                        </button>
                        <button class="btn-icon btn-edit" title="Editar dados" data-idposto="${req.idposto}">
                            ${icons.edit}
                        </button>
                        <button onclick='excluirPosto(${req.idposto})' class="btn-icon btn-deny" title="Excluir">
                            ${icons.x}
                        </button>
                    </div>
                </td>
                `

                tbody.appendChild(tr)
            })

            document.querySelectorAll(".btn-edit").forEach(el => {
                const idposto = el.getAttribute("data-idposto")
                el.addEventListener("click", () => {
                    abrirModalEditarPosto(requests[idposto])
                })
            })

            document.querySelectorAll(".btn-view").forEach(el => {
                const idposto = el.getAttribute("data-idposto")
                el.addEventListener("click", () => {
                    abrirModalCombustiveis(requests[idposto].combustiveis, idposto)
                })
            })
        }
                
        renderTable(Object.values(requests))
            
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase()
            const filtered = Object.values(requests).filter(r =>
                r.nome.toLowerCase().includes(term) ||
                r.endereco.toLowerCase().includes(term)
            )
            renderTable(filtered)
        })
        
        function fecharModalCombustivel(){
            document.getElementById('modalAdicionarCombustivel').style.display = 'none'
        }
        
        function pegarCombustivel(tipo){
            switch (tipo) {
                case '1':
                    return 'Diesel';
                    break;
                case '2':
                    return 'Etanol';
                    break;
                case '3':
                    return 'Gasolina';
                    break;
                case '4':
                    return 'Gasolina Aditivada';
                    break;
                case '5':
                    return 'Diesel S10';
                    break;
                default:
                    return 'Desconhecido';
            }
        }

    </script>
  </body>
  </html>
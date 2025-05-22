<?php 
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include('../../elements/alert.php');
    include('../../elements/connection.php');

    $sql = "SELECT * FROM posto ORDER BY idposto DESC";
    $result = $conn->query($sql);

    $requests = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $requests[] = [
                'idposto' => (int)$row['idposto'],
                'nome' => $row['nome'],
                'endereco' => $row['endereco'],
            ];
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
            include('../../elements/alert.php')
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

    <div id="modalCombustiveis" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detalhes do Posto</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <p><strong>Nome:</strong> <span id="modal-nome"></span></p>
            <p><strong>Endereço:</strong> <span id="modal-endereco"></span></p>
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
                    <input type="text" id="nome" name="nomePosto" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="enderecoPosto" name="enderecoPosto" required>
                </div>
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
            fuel: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                    <path d="M12 2C10.54 4.1 5 10.12 5 14.5C5 18.09 8.13 21 12 21C15.87 21 19 18.09 19 14.5C19 10.12 13.46 4.1 12 2ZM12 19C9.24 19 7 16.76 7 14.5C7 12.7 10.31 8.53 12 6.45C13.69 8.53 17 12.7 17 14.5C17 16.76 14.76 19 12 19Z"/>
                </svg>`,
            x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`
        };

        function ModalAdicionarPosto() {
            document.getElementById('modalAdicionarPosto').style.display = 'block';
        }

        // PLACEHOLDER TODO
        function abrirModal(request) {
            document.getElementById('modal-nome').textContent = request.nome;
            document.getElementById('modal-endereco').textContent = request.endereco;
            document.getElementById('modal').style.display = 'block';
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
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="3">Nenhum posto encontrado.</td></tr>`;
                return;
            }

            filtered.forEach(req => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="font-medium">${req.nome}</td>
                    <td>${req.endereco}</td>
                    <td>
                        <div class="actions">
                            <button onclick='abrirModal(req)' class="btn-icon btn-view" title="Ver combustíveis">
                                ${icons.fuel}
                            </button>
                            <button onclick='excluirPosto(${req.idposto})' class="btn-icon btn-delete" title="Excluir">
                                ${icons.x}
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        renderTable(requests);

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase();
            const filtered = requests.filter(r =>
                r.nome.toLowerCase().includes(term) ||
                r.endereco.toLowerCase().includes(term)
            );
            renderTable(filtered);
        });
    </script>
  </body>
</html>
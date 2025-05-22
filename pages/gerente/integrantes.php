
<?php 
    include('autenticacaoGerente.php');

    include('../../elements/connection.php');
    
            $query = "SELECT usuario.idusuario AS idusuario, email, usuario.nome AS nome_usuario, usuario.telefone AS telefone_usuario, cpf, gerente 
            FROM transportadora_usuario AS tu   
            JOIN usuario ON tu.idusuario = usuario.idusuario 
            JOIN transportadora ON tu.idtransportadora = transportadora.idtransportadora  
            WHERE tu.idtransportadora = ".$_GET['idtransportadora'];

            $resultado = $conn->query($query);
 #           if ($resultado === false) {
 #   die("Erro na consulta: " . $conn->error);
 #           }
    
    $requests = [];
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $idusuario = (int)$row['idusuario'];

            if (!isset($requests[$idusuario])) {
                $requests[$idusuario] = [
                    'idusuario' => $idusuario,
                    'email' => $row['email'],
                    'nome_usuario' => $row['nome_usuario'],
                    'telefone_usuario' => $row['telefone_usuario'],
                    'cpf' => $row['cpf'],
                ];
            }}
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Integrantes Cadastrados</title>
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
                <h1>Integrantes Cadastrados</h1>
                <p>Revise e gerencie os integrantes cadastrados.</p>
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
                <button onclick="ModalAdicionarIntegrante()" class="btn primary">Adicionar novo integrante</button>
            </div>
            <div class="table-wrapper">
                <table aria-label="Integrantes cadastrados">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>CPF</th>
                            <th></th>
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

    <div id="ModalAdicionarIntegrante" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Novo Integrante</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="integrantes.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>">
                <div class="form-group">
                    <label for="nome_usuario">Nome do Integrante</label>
                    <input placeholder="Escreva o nome do integrante" type="text" id="nome_usuario" name="nome_usuario" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input placeholder="Escreva o email do integrante" type="text" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Telefone</label>
                    <input placeholder="Escreva o telefone do integrante" type="text" id="telefone_usuario" name="telefone_usuario" required>
                </div>
                <div class="form-group">
                    <label for="endereco">CPF</label>
                    <input placeholder="Escreva o CPF do integrante" type="text" id="cpf" name="cpf" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Senha</label>
                    <input placeholder="Escreva a senha do integrante" type="password" id="senha" name="senha" required>
                    <small id="infoPage1" class="form-text text-muted">Seus dados não serão compartilhados com terceiros.</small>
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
            x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`,
            save: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#2563eb" viewBox="0 0 24 24">
                        <path d="M17 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-2-4zm-1 16h-8v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4zm-1-10H9V5h6v4z"/>
                    </svg>
                    `
        }

        function ModalAdicionarIntegrante() {
            document.getElementById('ModalAdicionarIntegrante').style.display = 'block';
        }

        
        function fecharModal() {
            document.querySelectorAll('.modal').forEach(element => {
                element.style.display = 'none';
            });
        }
        
        function excluirIntegrante(idusuario) {
            Swal.fire({
                title: "Tem certeza?",
                text: "Esta ação excluirá permanentemente o integrante!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Sim, excluir!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `deletar_integrante.php?id=${idusuario}`;
                }
            });
        }
        
        // TODO funcao de alterar posto ja existente
        function renderTable(filtered) {
            const tbody = document.getElementById('tableBody')
            tbody.innerHTML = ''

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="3">Nenhum integrante encontrado.</td></tr>`
                return
            }

            filtered.forEach(req => {
                const tr = document.createElement('tr')

                tr.innerHTML = `
                <td class="font-medium">${req.nome_usuario}</td>
                <td>${req.email}</td>
                <td>${req.telefone_usuario}</td>
                <td>${req.cpf}</td>
                <td>
                    <div class="actions">
                        <button class="btn-icon btn-view" title="Ver combustíveis" data-idusuario="${req.idusuario}">
                            ${icons.fuel}
                        </button>
                        <button onclick='excluirPosto(${req.idusuario})' class="btn-icon btn-deny" title="Excluir">
                            ${icons.x}
                        </button>
                    </div>
                </td>
                `

                tbody.appendChild(tr)
            })

        }
                
        renderTable(Object.values(requests))
            
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase()
            const filtered = Object.values(requests).filter(r =>
                r.nome_usuario.toLowerCase().includes(term) ||
                r.endereco.toLowerCase().includes(term)
            )
            renderTable(filtered)
        })

    </script>
  </body>
  </html>
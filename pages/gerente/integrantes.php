
<?php 
    include('autenticacaoGerente.php');

    include('../../elements/connection.php');
    
    $query = "SELECT usuario.idusuario AS idusuario, email, usuario.nome AS nome_usuario, usuario.telefone AS telefone_usuario, cpf, gerente 
    FROM transportadora_usuario AS tu   
    JOIN usuario ON tu.idusuario = usuario.idusuario 
    JOIN transportadora ON tu.idtransportadora = transportadora.idtransportadora  
    WHERE tu.idtransportadora = ".$_GET['idtransportadora'];

    $resultado = $conn->query($query);
#    if ($resultado === false) {
#       die("Erro na consulta: " . $conn->error);
#    }
    
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
                    'gerente' => $row['gerente'],
                ];
            }
        }
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
                <button onclick="modalAdicionarIntegrante()" class="btn primary">Adicionar novo integrante</button>
            </div>
            <div class="table-wrapper">
                <table aria-label="Integrantes cadastrados">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>CPF</th>
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

    <div id="modalAdicionarIntegrante" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Novo Integrante</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="integrante_cadastrar.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>">
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
                    <small class="form-text text-muted">Seus dados não serão compartilhados com terceiros.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn secondary" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    
    <div id="modalEditarIntegrante" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Integrante</h2>
                <span onclick="fecharModal()" class="close">&times;</span>
            </div>
            <form method="POST" action="integrante_editar.php?idtransportadora=<?php echo $_GET['idtransportadora']; ?>">
                <div class="form-group">
                    <label for="nome_usuario">Nome do Integrante</label>
                    <input placeholder="Escreva o nome do integrante" type="text" name="nome_usuario" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input placeholder="Escreva o email do integrante" type="text" name="email" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Telefone</label>
                    <input placeholder="Escreva o telefone do integrante" type="text" name="telefone_usuario" required>
                </div>
                <div class="form-group">
                    <label for="endereco">CPF</label>
                    <input placeholder="Escreva o CPF do integrante" type="text" name="cpf" required>
                </div>
                <input type="hidden" name="idusuario">
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
        
        function modalAdicionarIntegrante() {
            document.getElementById('modalAdicionarIntegrante').style.display = 'block'
        }

        function abrirModalEditarIntegrante(dados) {
            const form = document.querySelector('#modalEditarIntegrante form')
            
            form.querySelector('[name="nome_usuario"]').value = dados.nome_usuario || ''
            form.querySelector('[name="email"]').value = dados.email || ''
            form.querySelector('[name="telefone_usuario"]').value = dados.telefone_usuario || ''
            form.querySelector('[name="cpf"]').value = dados.cpf || ''
            
            let hiddenId = form.querySelector('input[name="idusuario"]')
            hiddenId.value = dados.idusuario

            document.getElementById('modalEditarIntegrante').style.display = 'block'
        }

        const modalEditar = document.getElementById('modalEditarIntegrante');

        modalEditar.querySelector('form').addEventListener('submit', function(event) {
            const nomeElement = modalEditar.querySelector('[name="nome_usuario"]')
            const cpfElement = modalEditar.querySelector('[name="cpf"]')
            const emailElement = modalEditar.querySelector('[name="email"]')
            const telefoneElement = modalEditar.querySelector('[name="telefone_usuario"]')

            const nome = nomeElement.value.trim()
            const cpf = cpfElement.value.trim().replace(/\D/g, '')
            const email = emailElement.value.trim()
            const telefone = telefoneElement.value.trim().replace(/\D/g, '')

            if (nome.length <= 2 || nome.length > 90) {
                event.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Nome inválido',
                    text: 'O nome deve ter entre 2 e 90 caracteres.',
                    confirmButtonColor: '#2563eb'
                }).then(() => nomeElement.focus())
                return
            }

            if (!/^\d{11}$/.test(cpf)) {
                event.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'CPF inválido',
                    text: 'O CPF deve conter exatamente 11 dígitos numéricos.',
                    confirmButtonColor: '#2563eb'
                }).then(() => cpfElement.focus())
                return
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'E-mail inválido',
                    text: 'Informe um e-mail válido.',
                    confirmButtonColor: '#2563eb'
                }).then(() => emailElement.focus())
                return
            }

            if (telefone.lenght < 11 || telefone.length > 15) {
                event.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Telefone inválido',
                    text: 'Informe um telefone válido (somente números, entre 10 e 15 dígitos).',
                    confirmButtonColor: '#2563eb'
                }).then(() => telefoneElement.focus())
                return
            }
        })

        const modalAdicionar = document.getElementById('modalAdicionarIntegrante');

        modalAdicionar.querySelector('form').addEventListener('submit', function(event) {
            const nomeElement = modalAdicionar.querySelector('[name="nome_usuario"]')
            const cpfElement = modalAdicionar.querySelector('[name="cpf"]')
            const emailElement = modalAdicionar.querySelector('[name="email"]')
            const telefoneElement = modalAdicionar.querySelector('[name="telefone_usuario"]')

            const nome = nomeElement.value.trim()
            const cpf = cpfElement.value.trim().replace(/\D/g, '')
            const email = emailElement.value.trim()
            const telefone = telefoneElement.value.trim().replace(/\D/g, '')

            if (nome.length < 2 || nome.length > 90) {
                event.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Nome inválido',
                    text: 'O nome deve ter entre 2 e 90 caracteres.',
                    confirmButtonColor: '#2563eb'
                }).then(() => nomeElement.focus())
                return
            }

            if (!/^\d{11}$/.test(cpf.replace(/\D/g, ''))) {
                event.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'CPF inválido',
                    text: 'O CPF deve conter exatamente 11 dígitos numéricos.',
                    confirmButtonColor: '#2563eb'
                }).then(() => cpfElement.focus())
                return
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'E-mail inválido',
                    text: 'Informe um e-mail válido.',
                    confirmButtonColor: '#2563eb'
                }).then(() => emailElement.focus())
                return
            }

            if (telefone.lenght > 15 || telefone.length < 11) {
                event.preventDefault()
                Swal.fire({
                    icon: 'warning',
                    title: 'Telefone inválido',
                    text: 'Informe um telefone válido (somente números, entre 10 e 15 dígitos).',
                    confirmButtonColor: '#2563eb'
                }).then(() => telefoneElement.focus())
                return
            }
        })

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
                    window.location.href = `integrante_deletar.php?idusuario=${idusuario}&idtransportadora=` + <?php echo $_SESSION['idtransportadora'] ?>
                }
            })
        }
        
        function renderTable(filtered) {
            const tbody = document.getElementById('tableBody')
            tbody.innerHTML = ''

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="3">Nenhum integrante encontrado.</td></tr>`
                return
            }

            filtered.forEach(req => {
                const tr = document.createElement('tr')

                let html = `
                <td data-label="Nome" class="font-medium">${req.nome_usuario}</td>
                <td data-label="Email">${req.email}</td>
                <td data-label="Telefone">${req.telefone_usuario}</td>
                <td data-label="CPF">${req.cpf}</td>
                <td data-label="Ações">
                    <div class="actions">
                        <button class="btn-icon btn-edit" title="Editar usuário" data-idusuario="${req.idusuario}">
                            ${icons.edit}
                        </button>
                `
                if (req.idusuario != <?php echo $_SESSION['id'] ?>){
                    html += `
                            <button onclick='excluirIntegrante(${req.idusuario})' class="btn-icon btn-deny" title="Excluir">
                                ${icons.x}
                            </button>
                            `
                }
                html += `
                    </div>
                </td>
                `
                tr.innerHTML = html

                tbody.appendChild(tr)
            })
            document.querySelectorAll(".btn-edit").forEach(el => {
                const idusuario = el.getAttribute("data-idusuario")
                el.addEventListener("click", () => {
                    abrirModalEditarIntegrante(requests[idusuario])
                })
            })
        }
                
        renderTable(Object.values(requests))
            
        const searchInput = document.getElementById('searchInput')
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase()
            const filtered = Object.values(requests).filter(r =>
                r.nome_usuario.toLowerCase().includes(term) ||
                r.email.toLowerCase().includes(term)
            )
            renderTable(filtered)
        })

    </script>
  </body>
  </html>
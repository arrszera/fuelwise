<?php 

    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }

    include('../../elements/connection.php');

    $sql = "SELECT * FROM solicitacao ORDER BY status ASC";
    $result = $conn->query($sql);

    $requests = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $requests[] = [
                'idsolicitacao' => (int)$row['idsolicitacao'],
                'nomeTransportadora' => $row['nomeTransportadora'],
                'nomeUsuario' => $row['nomeUsuario'],
                'emailUsuario' => $row['emailUsuario'],
                'cidade' => $row['cidade'],
                'estado' => $row['estado'],
                'endereco' => $row['endereco'],
                'telefoneEmpresa' => $row['telefoneEmpresa'],
                'telefoneUsuario' => $row['telefoneUsuario'],
                'cep' => $row['cep'],
                'cpf' => $row['cpf'],
                'cnpj' => $row['cpf'],
                'sobrenome' => $row['sobrenome'],
                'status' => $row['status'],
                // 'data' => $row['created_at  '], 
            ];
        }
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
  <title>Solicitações</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../../css/solicitacoes_v2.css" rel="stylesheet">
  <link href="../../css/index.css" rel="stylesheet">
  <link href="../../css/header.css" rel="stylesheet">
  <link href="../../css/sidebar.css" rel="stylesheet">
  <link href="../../css/footer.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <?php 
            include('../../elements/sidebar.php');
            include('../../elements/alert.php');
        ?>
    </div>
    <div class="main">
        <?php 
            include('../../elements/header.php');
        ?>
        <div class="content">
            <header class="page-header">
                <h1>Solicitações de Cadastro</h1>
                <p>Revise e aprove ou negue as solicitações de cadastro de transportadoras.</p>
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
                    placeholder="Filtrar por nome de empresa ou gerente..."
                    class="search-input"
                    aria-label="Search"
                    />
                </div>
            </div>

            <div class="table-wrapper">
                <table aria-label="Registration requests table">
                <thead>
                    <tr>
                    <th>Empresa</th>
                    <th>Gerente</th>
                    <th>Email</th>
                    <!-- <th>Data</th> -->
                    <th>Status</th>
                    <th class="w-120px" style="">Ações</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Linhas serão inseridas via JS -->
                </tbody>
                </table>
            </div>
        </div>
        <!-- <?php include('../../elements/footer.php') ?> -->
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
			<div class="modal-header">
				<h2>Detalhes da Solicitação</h2>
				<span onclick="fecharModal()" class="close">&times;</span>
			</div>
            <p><strong>Empresa:</strong> <span id="modal-nomeTransportadora"></span></p>
            <p><strong>CNPJ:</strong> <span id="modal-cnpj"></span></p>
            <p><strong>Telefone da Empresa:</strong> <span id="modal-telefone-empresa"></span></p>
            <p><strong>Logradouro:</strong> <span id="modal-endereco"></span></p>
            <p><strong>CEP:</strong> <span id="modal-cep"></span></p>
            <p><strong>Cidade:</strong> <span id="modal-cidade"></span></p>
            <p><strong>Gerente:</strong> <span id="modal-nomeUsuario"></span></p>
            <p><strong>Email:</strong> <span id="modal-emailUsuario"></span></p>
            <p><strong>Telefone Pessoal:</strong> <span id="modal-telefone-pessoal"></span></p>
            <p><strong>CPF:</strong> <span id="modal-cpf"></span></p>
            <p><strong>Status:</strong> <span id="modal-status"></span></p>
        </div>
    </div>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../js/index.js"></script>
  
  <script>
    const requests = <?php echo json_encode($requests); ?>

    function formatDate(date) {
      const options = { year: 'numeric', month: 'short', day: '2-digit' };
      return date.toLocaleDateString('en-US', options);
    }

    const icons = {
      eye: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3"></circle><path d="M2 12c2-4 6-7 10-7s8 3 10 7c-2 4-6 7-10 7s-8-3-10-7z"></path></svg>`,
      check: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><polyline points="20 6 9 17 4 12"></polyline></svg>`,
      x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`
    };

    // TODO Adicionar pontuacao nos campos de cnpj, cpf, telefone e afins...
    function abrirModal(request) {
        console.log(request)
        document.getElementById('modal-nomeTransportadora').textContent = request.nomeTransportadora 
        document.getElementById('modal-cnpj').textContent = request.cnpj 
        document.getElementById('modal-telefone-empresa').textContent = request.telefoneEmpresa
        document.getElementById('modal-endereco').textContent = request.endereco
        document.getElementById('modal-cep').textContent = request.cep 
        document.getElementById('modal-cidade').textContent = request.cidade 
        document.getElementById('modal-nomeUsuario').textContent = request.nomeUsuario + ' ' + request.sobrenome 
        document.getElementById('modal-emailUsuario').textContent = request.emailUsuario 
        document.getElementById('modal-telefone-pessoal').textContent = request.telefoneUsuario
        document.getElementById('modal-cpf').textContent = request.cpf
        document.getElementById('modal-status').textContent = getStatusClass(request.status).frase 

        document.getElementById('modal').style.display = 'block';
    }

	function fecharModal(){
		document.getElementById('modal').style.display = 'none';
	}

    function getStatusClass(status) {
        switch (parseInt(status)) {
            case 0:
                return {'classe' : 'badge-pending', 'frase' : 'pendente'}
            case 1:
                return {'classe' : 'badge-success', 'frase' : 'aprovado'}
            case 2:
                return {'classe' : 'badge-denied', 'frase' : 'recusado'}
            default:
                return ''
        }
    }

    function negarSolicitacao(idsolicitacao){
        Swal.fire({
            title: "Tem certeza?",
            text: "Você não será capaz de tornar uma solicitação pendente de novo! Caso a solicitação tenha sido aprovada, deletará todos registros da mesma.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sim, tenho certeza!"
        }).then((result) => {
            if (result.isConfirmed){
                window.location.href = `solicitacoes_negar.php?id=${idsolicitacao}`
            }
        })
    }

    function aprovarSolicitacao(idsolicitacao){
        Swal.fire({
            title: "Tem certeza?",
            text: "Você não será capaz de tornar uma solicitação pendente de novo!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sim, tenho certeza!"
        }).then((result) => {
            if (result.isConfirmed){
                window.location.href = `solicitacoes_aprovar.php?id=${idsolicitacao}`
            }
        })
    }

    // Renderiza as linhas da tabela filtradas
    function renderTable(filtered) {
		const tbody = document.getElementById('tableBody');
		tbody.innerHTML = '';

		if (filtered.length === 0) {
			tbody.innerHTML = `<tr><td class="no-results" colspan="6">Nenhum registro foi encontrado.</td></tr>`;
			return;
		}

		filtered.forEach(req => {
			let status = getStatusClass(req.status);
			const tr = document.createElement('tr');

			html = `
				<td data-label="Nome da Transportadora" class="font-medium">${req.nomeTransportadora}</td>
				<td data-label="Nome do usuário">${req.nomeUsuario}</td>
				<td data-label="Email">${req.emailUsuario}</td>
				<td data-label="Status"><span class="badge ${status.classe}">${status.frase}</span></td>
				<td data-label="Ações">
					<div class="actions">
						<button class="btn-icon btn-view" title="Ver mais detalhes" aria-label="Ver detalhes de ${req.nomeTransportadora}">
							${icons.eye}
						</button>
            `
            if (!(req.status == 1)){
                html += `
                    <button onclick='aprovarSolicitacao(${req.idsolicitacao})' class="btn-icon btn-approve" title="Aprovar">
                        ${icons.check}
                    </button>
                `
            }
            if (!(req.status == 2)){
                html += `
                    <button onclick='negarSolicitacao(${req.idsolicitacao})' class="btn-icon btn-deny" title="Negar">
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
			document.querySelectorAll(".btn-view").forEach(el => el.addEventListener("click", () => {
				abrirModal(req)
			}))
		});
	}
	
    renderTable(requests);
	
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', () => {
      const term = searchInput.value.toLowerCase();
      const filtered = requests.filter(r =>
        r.nomeTransportadora.toLowerCase().includes(term) ||
        r.nomeUsuario.toLowerCase().includes(term) ||
        r.emailUsuario.toLowerCase().includes(term)
      );
      renderTable(filtered);
    });
  </script>
</body>
</html>

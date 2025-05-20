<?php 
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include('../../elements/alert.php');

    include('../../elements/connection.php');

    $sql = "SELECT idsolicitacao, nomeTransportadora, nomeUsuario, emailUsuario, status FROM solicitacao ORDER BY status ASC";
    $result = $conn->query($sql);

    $requests = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $requests[] = [
                'idsolicitacao' => (int)$row['idsolicitacao'],
                'nomeTransportadora' => $row['nomeTransportadora'],
                'nomeUsuario' => $row['nomeUsuario'],
                'emailUsuario' => $row['emailUsuario'],
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

            <div class="search-container">
                <svg class="icon" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="11" cy="11" r="7"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input
                id="searchInput"
                type="search"
                placeholder="Search by company or manager name..."
                class="search-input"
                aria-label="Search"
                />
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
        <?php include('../../elements/footer.php') ?>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../js/index.js"></script>
  
  <script>
    const requests = <?php echo json_encode($requests); ?>

    function formatDate(date) {
      const options = { year: 'numeric', month: 'short', day: '2-digit' };
      return date.toLocaleDateString('en-US', options);
    }

    // Ícones inline SVG
    const icons = {
      eye: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3"></circle><path d="M2 12c2-4 6-7 10-7s8 3 10 7c-2 4-6 7-10 7s-8-3-10-7z"></path></svg>`,
      check: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><polyline points="20 6 9 17 4 12"></polyline></svg>`,
      x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`
    };

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
        tbody.innerHTML = `
          <tr>
            <td class="no-results" colspan="6">Nenhum registro foi encontrado.</td>
          </tr>
        `;
        return;
      }

      filtered.forEach(req => {
        let status = getStatusClass(req.status)
        const tr = document.createElement('tr')
// <td>${formatDate(req.date)}</td>
        tr.innerHTML = `
          <td class="font-medium">${req.nomeTransportadora}</td>
          <td>${req.nomeUsuario}</td>
          <td>${req.emailUsuario}</td>
          
          <td><span class="badge ${status['classe']}">${status['frase']}</span></td>
          <td>
            <div class="actions">
              <button class="btn-icon btn-view" title="Ver mais detalhes" aria-label="Ver detalhes de ${req.nomeTransportadora}">
                ${icons.eye}
              </button>
              <button onclick='aprovarSolicitacao(${req.idsolicitacao})' class="btn-icon btn-approve" title="Aprovar" aria-label="Aprovar a solicitação de ${req.nomeTransportadora}">
                ${icons.check}
              </button>
              <button onclick='negarSolicitacao(${req.idsolicitacao})' class="btn-icon btn-deny" title="Negar" aria-label="Negar ${req.nomeTransportadora}">
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
        r.nomeTransportadora.toLowerCase().includes(term) ||
        r.nomeUsuario.toLowerCase().includes(term) ||
        r.emailUsuario.toLowerCase().includes(term)
      );
      renderTable(filtered);
    });
  </script>
</body>
</html>

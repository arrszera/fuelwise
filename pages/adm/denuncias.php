<?php 
session_start(); 
if (!($_SESSION['role'] == 3)){
    header('Location: ../index.php');
    exit;
}
include('../../elements/connection.php');

$sql = "SELECT d.*, u.nome AS nomeUsuario, u.email FROM denuncia d 
        JOIN usuario u ON d.idusuario = u.idusuario 
        ORDER BY d.data_criacao DESC";
$result = $conn->query($sql);

$denuncias = [];

if ($result->num_rows > 0) {
    while($denuncia = $result->fetch_assoc()) {
        $anexos = [];

        $anexo_sql = "SELECT * FROM anexos WHERE iddenuncia = " . $denuncia['iddenuncia'];
        $anexo_result = $conn->query($anexo_sql);

        if ($anexo_result->num_rows > 0) {
            while ($anexo = $anexo_result->fetch_assoc()) {
                $baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/FuelWise/';
                $relativePath = str_replace('../', '/', $anexo['path']);

                $anexos[] = [
                    'nome_arquivo' => $anexo['nome_arquivo'],
                    'path' => $baseUrl . $relativePath,
                ];
            }
        }

        $denuncias[] = [
            'iddenuncia' => (int)$denuncia['iddenuncia'],
            'titulo' => $denuncia['titulo'],
            'motivo' => $denuncia['motivo'],
            'data_criacao' => $denuncia['data_criacao'],
            'nomeUsuario' => $denuncia['nomeUsuario'],
            'email' => $denuncia['email'],
            'anexos' => $anexos
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Denúncias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../../css/solicitacoes_v2.css" rel="stylesheet">
  <link href="../../css/index.css" rel="stylesheet">
  <link href="../../css/header.css" rel="stylesheet">
  <link href="../../css/sidebar.css" rel="stylesheet">
  <link href="../../css/footer.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <?php include('../../elements/sidebar.php'); ?>
        <?php include('../../elements/alert.php'); ?>
    </div>
    <div class="main">
        <?php include('../../elements/header.php'); ?>
        <div class="content">
            <header class="page-header">
                <h1>Denúncias</h1>
                <p>Visualize as denúncias recebidas e seus respectivos anexos.</p>
            </header>

            <div class="search-wrapper">
                <div class="search-container">
                    <svg class="icon" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="11" cy="11" r="7"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input id="searchInput" type="search" placeholder="Filtrar por título ou autor..." class="search-input" />
                </div>
            </div>

            <div class="table-wrapper">
                <table aria-label="Tabela de denúncias">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Data</th>
                            <th class="w-120px">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal" class="modal">
        <div style="margin-top: 15px" class="modal-content">
			<div class="modal-header">
				<h2>Detalhes da Denúncia</h2>
				<span onclick="fecharModal()" class="close">&times;</span>
			</div>
            <p><strong>Título:</strong> <span id="modal-titulo"></span></p>
            <p><strong>Motivo:</strong> <span id="modal-motivo"></span></p>
            <p><strong>Autor:</strong> <span id="modal-nomeUsuario"></span></p>
            <p><strong>Email:</strong> <span id="modal-emailUsuario"></span></p>
            <p><strong>Data:</strong> <span id="modal-data"></span></p>
            <p><strong>Anexos:</strong></p>
            <ul id="modal-anexos"></ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const denuncias = <?php echo json_encode($denuncias); ?>;

         const icons = {
            x: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`,
            eye: `<svg class="icon" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3"></circle><path d="M2 12c2-4 6-7 10-7s8 3 10 7c-2 4-6 7-10 7s-8-3-10-7z"></path></svg>`,
        }


        function abrirModal(denuncia) {
            document.getElementById('modal-titulo').textContent = denuncia.titulo;
            document.getElementById('modal-motivo').textContent = denuncia.motivo;
            document.getElementById('modal-nomeUsuario').textContent = denuncia.nomeUsuario;
            document.getElementById('modal-emailUsuario').textContent = denuncia.email;
            document.getElementById('modal-data').textContent = denuncia.data_criacao;

            const ul = document.getElementById('modal-anexos');
            ul.innerHTML = '';

            if (denuncia.anexos.length === 0) {
                ul.innerHTML = '<li>Nenhum anexo disponível.</li>';
            } else {
                denuncia.anexos.forEach(anexo => {
                    const li = document.createElement('li');
                    const ext = anexo.nome_arquivo.split('.').pop().toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                        li.innerHTML = `<img src="${anexo.path}" alt="${anexo.nome_arquivo}" style="max-width: 100%; margin-bottom: 10px;" />`;
                    } else if (ext === 'pdf') {
                        li.innerHTML = `<iframe src="${anexo.path}" width="100%" height="400px" style="border: none;"></iframe>`;
                    } else {
                        li.innerHTML = `<a href="${anexo.path}" target="_blank">${anexo.nome_arquivo}</a>`;
                    }
                    li.innerHTML += '<br><br>'
                    ul.appendChild(li);
                });
            }

            document.getElementById('modal').style.display = 'block';
        }

        function fecharModal(){
            document.getElementById('modal').style.display = 'none';
        }

        function renderTable(filtered) {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td class="no-results" colspan="4">Nenhuma denúncia encontrada.</td></tr>`;
                return;
            }

            filtered.forEach(d => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="font-medium">${d.titulo}</td>
                    <td>${d.nomeUsuario}</td>
                    <td>${d.data_criacao}</td>
                    <td>
                        <div class="actions">
                            <button class="btn-icon btn-view" title="Ver detalhes" aria-label="Ver detalhes da denúncia">
                                ${icons.eye}
                            </button>
                            <button onclick="excluirDenuncia(${d.iddenuncia})" class="btn-icon btn-deny" title="excluir" aria-label="Excluir denúncia">
                                ${icons.x}
                            </button>
                        </div>
                    </td>
                `;
                tr.querySelector('.btn-view').addEventListener('click', () => abrirModal(d));
                tbody.appendChild(tr);
            });
        }

        function excluirDenuncia(id){
            Swal.fire({
                title: 'Excluir denúncia',
                text: 'Você tem certeza que deseja excluir essa denúncia?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Não, cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `denuncia_deletar.php?iddenuncia=${id}`
                }
            });        
        } 

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase();
            const filtered = denuncias.filter(d =>
                d.titulo.toLowerCase().includes(term) ||
                d.nomeUsuario.toLowerCase().includes(term)
            );
            renderTable(filtered);
        });

        renderTable(denuncias);
    </script>
</body>
</html>

<?php 

    include('autenticacaoGerente.php');

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
                <p>Veja os postos cadastrados.</p>
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
            </div>
            <div class="table-wrapper">
                <table aria-label="Postos cadastrados">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Coordenadas</th>
                            <th>Combustíveis</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Linhas serão inseridas via JS -->
                    </tbody>
                </table>
            </div>
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

        }

        document.addEventListener('DOMContentLoaded', function() {
        });

        
        function abrirModalCombustiveis(combustiveis, idposto) {
            const modal = document.getElementById('modalCombustiveis')
            const content = modal.querySelector('.modal-content')
            const idInput = document.querySelector('#modalCombustiveis #idposto')
            if (idInput) {
                idInput.value = idposto
            }            

            const oldTable = content.querySelector('table')
            if (oldTable) oldTable.remove()
            
            const table = document.createElement('table')
            table.classList.add('modal-table') 
            
            table.innerHTML = `
            <thead> 
                <tr>
                    <th>Tipo</th>
                    <th>Preço (R$)</th>
                </tr>
            </thead>
            <tbody>
            ${combustiveis.length > 0 ? combustiveis.map(c => {
                let tipoCombustivel = pegarCombustivel(c.tipo)
                
                return `
                <tr>
                    <td data-label="Tipo">${tipoCombustivel}</td>
                    <td data-label="Preço"><span id='preco-${c.idcombustivel}'>${parseFloat(c.preco).toFixed(2)}</span></td>
                    </td>
                </tr>`;
            }).join('') :
            `<tr><td colspan="2">Nenhum combustível cadastrado.</td></tr>`
            } ` // condicional na mesma linha
            
            content.appendChild(table)
            
            modal.style.display = 'block'
        }

        
     
        function fecharModal() {
            document.querySelectorAll('.modal').forEach(element => {
                element.style.display = 'none';
            });
        }

      function renderTable(filtered) {
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '';

    if (filtered.length === 0) {
        tbody.innerHTML = `<tr><td class="no-results" colspan="4">Nenhum posto encontrado.</td></tr>`;
        return;
    }

    filtered.forEach(req => {
        const tr = document.createElement('tr');

        const combustiveisList = req.combustiveis.length > 0
            ? `<ul class="nested-combustiveis">
                ${req.combustiveis.map(c => `
                    <li>${pegarCombustivel(c.tipo)} - R$ ${parseFloat(c.preco).toFixed(2)}</li>
                `).join('')}
              </ul>`
            : 'Nenhum combustível cadastrado.';

        tr.innerHTML = `
            <td data-label="Nome" class="font-medium">${req.nome}</td>
            <td data-label="Endereço">${req.endereco}</td>
            <td data-label="Coordenadas">${req.latitude}, ${req.longitude}</td>
            <td data-label="Lista de combustíveis">${combustiveisList}</td>
        `;

        tbody.appendChild(tr);
    });
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
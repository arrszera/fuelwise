<?php 
    include('autenticacaoGerente.php');

    include('../../elements/connection.php');

    $veiculosQuery = "SELECT COUNT(*) AS total FROM veiculo WHERE idtransportadora = ".$_GET['idtransportadora'];
    $veiculosResult = $conn->query($veiculosQuery);
    $totalVeiculos = 0;
    if ($veiculosResult && $row = $veiculosResult->fetch_assoc()) {
        $totalVeiculos = (int)$row['total'];
    }

    $usuariosQuery = "SELECT COUNT(*) AS total FROM transportadora_usuario WHERE idtransportadora = ".$_GET['idtransportadora'] ;
    $usuariosResult = $conn->query($usuariosQuery);
    $totalUsuarios = 0;
    if ($usuariosResult && $row = $usuariosResult->fetch_assoc()) {
        $totalUsuarios = (int)$row['total'];
    }

    $viagensQuery = "SELECT COUNT(*) AS total FROM viagem
    JOIN transportadora_usuario ON transportadora_usuario.idusuario = viagem.idusuario
    WHERE transportadora_usuario.idtransportadora = ".$_GET['idtransportadora'] ;
    $viagensResult = $conn->query($viagensQuery);
    $totalViagens = 0;
    if ($viagensResult && $row = $viagensResult->fetch_assoc()) {
        $totalViagens = (int)$row['total'];
    }

    // Pega o id da transportadora da sessão
$idTransportadora = intval($_SESSION['idtransportadora']);

// Query para média de gasto por viagem dos últimos 12 meses
$mediaGastoPorViagemQuery = "
    SELECT 
        DATE_FORMAT(dataPagamento, '%Y-%m') AS mes,
        SUM(valor) AS total_gasto,
        COUNT(idviagem) AS total_viagens
    FROM pagamento
    WHERE idtransportadora = $idTransportadora
      AND dataPagamento >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY mes
    ORDER BY mes
";

$resultadoMedia = $conn->query($mediaGastoPorViagemQuery);

$dadosGraficoMedia = [];

if ($resultadoMedia && $resultadoMedia->num_rows > 0) {
    while ($linha = $resultadoMedia->fetch_assoc()) {
        $totalGasto = (float)$linha['total_gasto'];
        $totalViagens = (int)$linha['total_viagens'];
        $mediaGasto = $totalViagens > 0 ? $totalGasto / $totalViagens : 0;

        $dadosGraficoMedia[] = [
            'mes' => $linha['mes'],
            'media_gasto' => round($mediaGasto, 2)
        ];
    }
}

    
    $dataGrafico = [];
    
    $sql = "
    SELECT 
        DATE_FORMAT(dataPagamento, '%Y-%m') AS mes,
        SUM(valor) AS total_gasto,
        SUM(distanciaPercorrida) AS total_distancia
    FROM pagamento
    WHERE idtransportadora = " . intval($_SESSION['idtransportadora']) . "
        AND dataPagamento >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY mes
    ORDER BY mes
    ";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataGrafico[] = [
                'mes' => $row['mes'],
                'gastos' => (float)$row['total_gasto'],
                'distancia' => (float)$row['total_distancia'],
            ];
        }
    }
    $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $mesAtual = $now->format('Y-m');
    $gastosMensais = 0;

    foreach ($dataGrafico as $item) {
        if ($item['mes'] === $mesAtual) {
            $gastosMensais += $item['gastos'];
        }
    }
?>
<script>
  const graficoData = <?php echo json_encode($dataGrafico); ?>;
  const dadosMediaGastoViagem = <?php echo json_encode($dadosGraficoMedia); ?>;

</script>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Início</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../css/solicitacoes_v2.css" rel="stylesheet">
    <link href="../../css/index.css" rel="stylesheet">
    <link href="../../css/header.css" rel="stylesheet">
    <link href="../../css/sidebar.css" rel="stylesheet">
    <link href="../../css/footer.css" rel="stylesheet">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
    <style>
        body{
            background-color: #f3f4f6;
        }
        #dadosExibidos, #dadosExibidos2{
            margin-bottom: 12px;
        }

        #dadosExibidos2{
            justify-content: center;
        }

        #map {
            height: 400px;
            width: 60%;
            border-radius: 8px;
        }

        .map-container{
            display: flex;
            justify-content: space-around;
        }

        .card{
            border: 1px solid #ddd;
            padding: 0px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .cards{
            display: flex;
            flex-direction: column;
            width: 35%;
            gap: 10px;
        }
        .card-body{
            padding: 10px 15px;
        }
        .card-header{
            padding: 10px;
        }
        h2{
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        p{
            font-size: 0.9rem;
            font-weight: 200;
            color: #555;
        }
        .row{
            margin-top: 15px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            gap: 2%;
        }
        .buttons{
            margin-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            overflow: hidden !important;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            position: relative;
        }
        .modal-content h3 {
            margin-top: 0;
        }
        .modal-content input, select {
            width: 100%;
            margin-top: 0px;
            padding: 8px;
        }
        .modal-buttons {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }
        .modal-buttons button {
            padding: 8px 12px;
        }
        .dashboards{
            display: flex;
            justify-content: space-between;
            gap: 2%;
            width: 100%;
        }

        .dashboard{
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            border: solid #DDDDDD 1px;
            width: 33%;
            height: 100px;
            background-color: white;
        }

        .dashboard p{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            font-weight: 500;
        }

        .dashboard h2, .row h2{
            font-weight: 600;
        }

        @media screen and (max-width: 798px) {
            #map{
                width: 100%;
            }

            .map-container{
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            .cards{
                width: 100%;
                flex-direction: column;
            }

            .card{
                width: 100%;
            }

            .dashboards{
                flex-direction: column;
                gap: 20px;
            }

            .dashboard{
                width: 100%;
            }

            .row{
                flex-direction: column;
                gap: 20px
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include('../../elements/sidebar.php') ?>
        <?php include('../../elements/alert.php'); ?>
    </div>

    <div class="main">
        <?php include('../../elements/header.php'); ?>
        <div class="content">
            <header class="page-header">
                <h1>Início</h1>
                <p>Visualize e gerencie dados da sua transportadora.</p>
            </header>

            <div class="dashboards">
                <div class="dashboard">
                    <p>Veículos cadastrados 
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#BBBBBB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="7" width="15" height="10" rx="2" ry="2"></rect>
                        <path d="M16 7h5l2 5v5h-7"></path>
                        <circle cx="5.5" cy="17.5" r="2"></circle>
                        <circle cx="18.5" cy="17.5" r="2"></circle>
                        </svg>
                    </p>

                    <h2><?php echo $totalVeiculos; ?></h2>
                </div>
            
                <div class="dashboard">
                    <p>Usuarios cadastrados
                        <svg width="16" height="16" fill="none" stroke="#BBBBBB" stroke-width="1.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 21v-1a7 7 0 0114 0v1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </p>

                    <h2><?php echo $totalUsuarios; ?></h2>

                </div>

                <div class="dashboard">
                    <p>Viagens cadastradas  
                        <svg width="16" height="16" fill="none" stroke="#BBBBBB" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                    </p> 

                    <h2><?php echo $totalViagens; ?></h2>

                </div>

                <div class="dashboard">
                    <p>Gastos mensais  
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#BBB" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="14" x="2" y="5" rx="2"/>
                        <line x1="2" y1="10" x2="22" y2="10"/>
                        </svg>

                    </p> 

                    <h2><?php echo $gastosMensais; ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="card" style="padding: 20px; width: 100%; height: 100%">
                    <h2>Gastos mensais de combustível</h2>
                    <canvas id="graficoGastosDistancia"></canvas>
                </div>
                <div class="card" style="padding: 20px; width: 100%; height: 100%">
                    <h2>Média Mensal de Gasto por Viagem</h2>
                    <canvas id="graficoMediaGastoViagem"></canvas>
                </div>


            </div>
        </div>
    </div>

<script src="../../js/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('graficoGastosDistancia').getContext('2d');

  const labels = graficoData.map(item => item.mes);
  const dadosGastos = graficoData.map(item => item.gastos);
  const dadosDistancia = graficoData.map(item => item.distancia);

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Gastos (R$)',
          data: dadosGastos,
          borderColor: '#8884d8',
          backgroundColor: '#8884d855',
          tension: 0.3
        },
        {
          label: 'Distância (km)',
          data: dadosDistancia,
          borderColor: '#82ca9d',
          backgroundColor: '#82ca9d55',
          tension: 0.3
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.dataset.label || '';
              return label + ': ' + context.formattedValue;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctxMedia = document.getElementById('graficoMediaGastoViagem').getContext('2d');

  const labelsMedia = dadosMediaGastoViagem.map(item => item.mes);
  const dadosMedia = dadosMediaGastoViagem.map(item => item.media_gasto);

  new Chart(ctxMedia, {
    type: 'line',
    data: {
      labels: labelsMedia,
      datasets: [{
        label: 'Média de gasto por viagem (R$)',
        data: dadosMedia,
        borderColor: '#4caf50',
        backgroundColor: '#4caf5055',
        tension: 0.3,
        fill: true,
        pointRadius: 5,
        pointHoverRadius: 7
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: true, position: 'top' },
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'R$ ' + context.formattedValue;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'R$ (Reais)' }
        },
        x: {
          title: { display: true, text: 'Mês' }
        }
      }
    }
  });
</script>

</body>
</html>
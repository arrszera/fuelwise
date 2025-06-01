<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include('../../elements/connection.php');

    $veiculosQuery = "SELECT COUNT(*) AS total FROM veiculo";
    $veiculosResult = $conn->query($veiculosQuery);
    $totalVeiculos = 0;
    if ($veiculosResult && $row = $veiculosResult->fetch_assoc()) {
        $totalVeiculos = (int)$row['total'];
    }

    $usuariosQuery = "SELECT COUNT(*) AS total FROM transportadora_usuario";
    $usuariosResult = $conn->query($usuariosQuery);
    $totalUsuarios = 0;
    if ($usuariosResult && $row = $usuariosResult->fetch_assoc()) {
        $totalUsuarios = (int)$row['total'];
    }

    $viagensQuery = "SELECT COUNT(*) AS total FROM viagem";
    $viagensResult = $conn->query($viagensQuery);
    $totalViagens = 0;
    if ($viagensResult && $row = $viagensResult->fetch_assoc()) {
        $totalViagens = (int)$row['total'];
    }

    $denunciasQuery = "SELECT COUNT(*) AS total FROM denuncia";
    $denunciasResult = $conn->query($denunciasQuery);
    $totalDenuncias = 0;
    if ($denunciasResult && $row = $denunciasResult->fetch_assoc()) {
        $totalDenuncias = (int)$row['total'];
    }

    $transportadorasQuery = "SELECT COUNT(*) AS total FROM transportadora";
    $transportadorasResult = $conn->query($transportadorasQuery);
    $totalTransportadoras = 0;
    if ($transportadorasResult && $row = $transportadorasResult->fetch_assoc()) {
        $totalTransportadoras = (int)$row['total'];
    }

    $postosQuery = "SELECT COUNT(*) AS total FROM posto";
    $postosResult = $conn->query($postosQuery);
    $totalPostos = 0;
    if ($postosResult && $row = $postosResult->fetch_assoc()) {
        $totalPostos = (int)$row['total'];
    }

    $dataGraficoUsuarios = [];

    $sqlUsuarios = "
    SELECT 
        DATE_FORMAT(datalogin, '%Y-%m') AS mes,
        COUNT(*) AS total_usuarios
    FROM transportadora_usuario
    WHERE datalogin >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY mes
    ORDER BY mes
    ";

    $resultUsuarios = $conn->query($sqlUsuarios);
    if ($resultUsuarios && $resultUsuarios->num_rows > 0) {
        while ($row = $resultUsuarios->fetch_assoc()) {
            $dataGraficoUsuarios[] = [
                'mes' => $row['mes'],
                'usuarios' => (int)$row['total_usuarios'],
            ];
        }
    }

    $dataGraficoTransportadoras = [];

    $sqlTransportadoras = "
    SELECT 
        DATE_FORMAT(dataCriacao, '%Y-%m') AS mes,
        COUNT(*) AS total_transportadoras
    FROM transportadora
    WHERE dataCriacao >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY mes
    ORDER BY mes
    ";

    $resultTransportadoras = $conn->query($sqlTransportadoras);
    if ($resultTransportadoras && $resultTransportadoras->num_rows > 0) {
        while ($row = $resultTransportadoras->fetch_assoc()) {
            $dataGraficoTransportadoras[] = [
                'mes' => $row['mes'],
                'quantidade' => (int)$row['total_transportadoras'],
            ];
        }
    }
?>

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
            min-height: fit-content;
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
                    <p>Denúncias pendentes  
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#BBBBBB" stroke-width="1.8">
                        <path d="M12 9v4" stroke-linecap="round" />
                        <circle cx="12" cy="17" r="1" />
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        </svg>

                    </p> 

                    <h2><?php echo $totalDenuncias; ?></h2>

                </div>

                <div class="dashboard">
                    <p>Transportadoras cadastradas  
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#BBBBBB" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M3 12a9 9 0 0 1 15.5-6.36M21 12a9 9 0 0 1-15.5 6.36" />
                            <polyline points="3 7 3 3 7 3" />
                            <polyline points="21 17 21 21 17 21" />
                        </svg>
                    </p> 
                    <h2><?php echo $totalTransportadoras; ?></h2>
                </div>


                <div class="dashboard">
                    <p>Postos Cadastrados  
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#BBBBBB" stroke-width="1.8">
                        <path d="M3 3h10v18H3z" />
                        <path d="M14 8h2a2 2 0 0 1 2 2v5a2 2 0 0 0 2 2h1" />
                        <circle cx="7" cy="17" r="1" />
                        </svg>
                    <h2><?php echo $totalPostos; ?></h2>

                </div>
            </div>
            <div class="row">
                <div class="card" style="padding: 20px; width: 100%; height: 100%">
                    <h2>Usuário cadastrados</h2>
                    <canvas id="graficoUsuarios"></canvas>
                </div>
                <div class="card" style="padding: 20px; width: 100%; height: 100%">
                    <h2>Transportadoras cadastradas</h2>
                    <canvas id="graficoTransportadoras"></canvas>
                </div>
            </div>
        </div>
    </div>

<script src="../../js/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const graficoUsuariosData = <?= json_encode($dataGraficoUsuarios) ?>;

  const ctxUsuarios = document.getElementById('graficoUsuarios').getContext('2d');
  const labelsUsuarios = graficoUsuariosData.map(item => item.mes);
  const dadosUsuarios = graficoUsuariosData.map(item => item.usuarios);

  new Chart(ctxUsuarios, {
    type: 'line',
    data: {
      labels: labelsUsuarios,
      datasets: [
        {
          label: 'Usuários Cadastrados',
          data: dadosUsuarios,
          borderColor: '#ff6384',
          backgroundColor: '#ff638455',
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
              return 'Usuários: ' + context.formattedValue;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      }
    }
  });
</script>

<script>
  const graficoTransportadorasData = <?= json_encode($dataGraficoTransportadoras) ?>;

  const ctxTransportadoras = document.getElementById('graficoTransportadoras')?.getContext('2d');

  if (ctxTransportadoras) {
    const labelsTransportadoras = graficoTransportadorasData.map(item => item.mes);
    const dadosTransportadoras = graficoTransportadorasData.map(item => item.quantidade);

    new Chart(ctxTransportadoras, {
      type: 'line',
      data: {
        labels: labelsTransportadoras,
        datasets: [{
          label: 'Transportadoras Criadas',
          data: dadosTransportadoras,
          borderColor: '#36a2eb',
          backgroundColor: '#36a2eb55',
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Transportadoras: ' + context.formattedValue;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  }
</script>

<script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
</body>
</html>
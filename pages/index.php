<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='../css/header.css'>
    <link rel='stylesheet' href='../css/index.css'>
    <!-- fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">     
    <!--  -->
    <title>Document</title>
</head>
<body>
    <?php include('../elements/header.php') ?>

    <div class="inicio" id="inicio">

    </div>


  <!-- Header -->
  <header>
    <nav class="top-nav">
      <a href="#">Início</a>
      <a href="#funcionalidades">Funcionalidades</a>
      <a href="#como-funciona">Como Funciona</a>
      <a href="#contato">Contato</a>
      <a href="cadastro.html" class="cadastro-link">Cadastre-se</a>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <h1>FullWise</h1>
    <p>A revolução no abastecimento de frotas começa aqui.</p>
  </section>

  <!-- Funcionalidades -->
  <section class="section" id="funcionalidades">
    <h2>Funcionalidades Principais</h2>
    <div class="grid">
      <div class="card">
        <h3>🔄 Pagamento Automatizado via PIX</h3>
        <p>Geração de QR Code e autorização instantânea do gerente para liberar o abastecimento.</p>
      </div>
      <div class="card">
        <h3>⛽ Postos Filiados</h3>
        <p>Visualize postos parceiros com preços atualizados em tempo real.</p>
      </div>
      <div class="card">
        <h3>📍 Localização em Tempo Real</h3>
        <p>Acompanhe a localização dos caminhões da sua frota com precisão.</p>
      </div>
      <div class="card">
        <h3>👷 Cadastro de Funcionários</h3>
        <p>Adicione e gerencie os motoristas da sua transportadora com facilidade.</p>
      </div>
      <div class="card">
        <h3>🔐 Segurança em Primeiro Lugar</h3>
        <p>Notificações para aprovação de pagamentos e proteção de dados com criptografia.</p>
      </div>
      <div class="card">
        <h3>💡 Sem Planos Pagos</h3>
        <p>Utilize via site ou aplicativo, sem mensalidades, sem surpresas.</p>
      </div>
    </div>
  </section>

  <!-- Como Funciona -->
  <section class="section" id="como-funciona">
    <h2>Como Funciona</h2>
    <ol>
      <li>Caminhoneiro solicita abastecimento no posto filiado.</li>
      <li>Plataforma gera QR Code para pagamento via PIX.</li>
      <li>Gerente recebe notificação e autoriza ou nega a transação.</li>
      <li>Abastecimento liberado e informações registradas automaticamente.</li>
    </ol>
  </section>

  <!-- Destaques -->
  <section class="section destaque">
    <h2>Vantagens para Gerentes de Frota</h2>
    <ul>
      <li>Redução de custos com fraudes e desvios.</li>
      <li>Abastecimentos centralizados e rastreados.</li>
      <li>Melhoria no controle operacional.</li>
      <li>Economia de tempo e recursos administrativos.</li>
    </ul>
  </section>

  <!-- Rodapé -->
  <footer id="contato">
    <p>© 2025 FullWise - Plataforma Inteligente de Combustível</p>
    <p><a href="mailto:contato@fullwise.com">contato@fullwise.com</a></p>
  </footer>
    

    <!-- JS -->
    <script src="../js/index.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
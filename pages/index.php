<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php 
        include_once('../config.php');
        include(ROOT_PATH . '/elements/head.php');
    ?>
    <link rel='stylesheet' href='<?php echo ROOT_PATH ?>/css/home.css'>
    <title>Document</title>
</head>
<body>
    <?php include(ROOT_PATH . '/elements/header.php') ?>
    
    <div class="inicio" id="inicio">

    </div>

  <!-- Hero Section -->
  <section class="hero">
    <h1>FuelWise</h1>
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
    <script src="<?php echo ROOT_PATH ?>/js/index.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>

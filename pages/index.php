<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php 
        include_once('../config.php');
        include('../elements/head.php');
    ?>

    <link rel='stylesheet' href='../css/header.css'>
    <link rel='stylesheet' href='../css/home2.css'> 
    <title>Home</title>
</head>
<body>
    <?php include('../elements/header.php') ?>
    
    <div class="inicio" id="inicio">

    </div>

  <!-- Hero Section -->
  <section class="hero">
    <h1 style="overflow-y: hidden">FuelWise</h1>
    <p>A revolução no abastecimento de frotas começa aqui.</p>
    <p><strong>Gestão eficiente, pagamento instantâneo, controle total.</strong></p>
  </section>

  <!-- Sobre -->
  <section class="section" id="sobre">
    <h2>Sobre a FullWise</h2>
    <p>A FullWise é uma plataforma inteligente que conecta caminhoneiros, transportadoras e postos de combustível, trazendo mais agilidade, segurança e transparência para o processo de abastecimento de frotas.</p>
    <p>Com pagamentos via PIX autorizados em tempo real pelos gerentes, rastreamento de caminhões e emissão de notas fiscais automáticas, a FullWise facilita a gestão completa de frotas rodoviárias.</p>
  </section>

  <!-- Funcionalidades -->
  <section class="section" id="funcionalidades">
    <h2>Funcionalidades Principais</h2>
    <div class="grid">
      <div class="card">
        <h3>🔄 Pagamento Automatizado via PIX</h3>
        <p>Geração de QR Code e autorização do gerente para liberar o abastecimento de forma segura e rápida.</p>
      </div>
      <div class="card">
        <h3>⛽ Postos e Preços em Tempo Real</h3>
        <p>Visualização de postos parceiros próximos e seus respectivos valores atualizados de combustível.</p>
      </div>
      <div class="card">
        <h3>📍 Localização de Frotas</h3>
        <p>Monitore a posição dos caminhões em tempo real, melhorando a logística e a segurança da carga.</p>
      </div>
      <div class="card">
        <h3>👥 Cadastro de Funcionários e Caminhões</h3>
        <p>Gerencie motoristas e associe veículos a cada condutor diretamente pela plataforma.</p>
      </div>
      <div class="card">
        <h3>🧾 Emissão de Notas Fiscais</h3>
        <p>Os postos filiados emitem notas fiscais automaticamente após o pagamento confirmado.</p>
      </div>
      <div class="card">
        <h3>💬 Comunicação Inteligente (Em breve)</h3>
        <p>Futuramente, um chat interno permitirá comunicação direta entre motoristas e gerentes.</p>
      </div>
    </div>
  </section>

  <!-- Usuários -->
  <section class="section" id="usuarios">
    <h2>Usuários e Responsabilidades</h2>
    <div class="grid">
      <div class="card">
        <h3>👷 Caminhoneiros</h3>
        <p>Solicitam abastecimentos de forma rápida e segura diretamente pelo aplicativo.</p>
      </div>
      <div class="card">
        <h3>🛡️ Gerentes de Transportadoras</h3>
        <p>Autorizam pagamentos, acompanham abastecimentos e monitoram a frota em tempo real.</p>
      </div>
      <div class="card">
        <h3>⛽ Postos de Combustível</h3>
        <p>Realizam o abastecimento, emitem notas fiscais e recebem pagamentos instantaneamente.</p>
      </div>
    </div>
  </section>

  <!-- Destaques -->
  <section class="section destaque">
    <h2>Vantagens da FullWise</h2>
    <ul>
      <li> Redução de custos com fraudes e desvios.</li>
      <li> Transparência total em cada transação.</li>
      <li> Facilidade na emissão de relatórios e auditorias.</li>
      <li> Agilidade nos pagamentos via PIX.</li>
      <li> Zero mensalidade: sem surpresas, sem planos pagos.</li>
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

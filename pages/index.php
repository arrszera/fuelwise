<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FuelWise - Solução de Gerenciamento de Frotas</title>
  <link rel="stylesheet" href="../css/index.css" />
  <link rel="stylesheet" href="../css/header.css" />
  <link rel="stylesheet" href="../css/footer.css" />
  <link rel="stylesheet" href="../css/landing.css" />
</head>
<body>
  <?php include('../elements/header.php')?>

  <section class="hero">
    <div class="container hero-content">
      <div class="hero-text">
        <h1>Solução de gerenciamento total de frota</h1>
        <p>
          A FuelWise oferece às transportadoras controle total sobre o abastecimento de seus veículos durante as viagens,
          centralizando os registros de pagamento, localização, gestão de motoristas e veículos — tudo em um só lugar.
        </p>
        <div class="hero-buttons">
          <a href="cadastro_transportadora.php" class="btn-outline">Comece já</a>
          <a href="/contact" class="btn-outline">Contatar equipe</a>
        </div>
      </div>
      <div class="hero-image">
        <div class="image-box">
          <img src="https://placehold.co/800x600/1E40AF/FFFFFF?text=FuelWise" alt="Painel da FuelWise" />
          <div class="badge">Otimize gastos em combustíveis em até 15%</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Funcionalidades -->
  <section class="features">
    <div class="container">
      <h2>Gerenciamento de frota completo</h2>
      <p>
        A FuelWise oferece todas as ferramentas necessárias para gerenciar sua frota, pagamentos e equipe em uma única plataforma integrada.
      </p>
      <div class="features-grid">
        <div class="card">
          <div class="icon">🚗</div>
          <h3>Gerenciamento de veículos</h3>
          <p>Rastreie sua frota com dados em tempo real e perfil exclusivo de veículo.</p>
        </div>
        <div class="card">
          <div class="icon">💳</div>
          <h3>Integração de pagamento</h3>
          <p>Centralize todos pagamentos de combustíveis e gere relatórios detalhados.</p>
        </div>
        <div class="card">
          <div class="icon">🗺️</div>
          <h3>Otimização de rota</h3>
          <p>Encontre a melhor rota e postos de combustíveis mais próximos para maximizar a eficiência.</p>
        </div>
        <div class="card">
          <div class="icon">👥</div>
          <h3>Gerenciamento de time</h3>
          <p>Gerencie motoristas e equipe com permissões baseadas em funções e perfis detalhados.</p>
        </div>
        <div class="card">
          <div class="icon">📄</div>
          <h3>Análise e relatórios</h3>
          <p>Obtenha insights com relatórios personalizados e painéis de análise em tempo real.</p>
        </div>
        <div class="card">
          <div class="icon">⛽</div>
          <h3>Catálogo de postos</h3>
          <p>Acesse informações atualizadas sobre postos de combustíveis, preços e comodidades.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="cta">
    <div class="cta-elements">
      <div>
        <h2>Pronto para otimizar as operações da sua frota?</h2>
        <p>
          Junte-se a centenas de transportadoras que já reduziram custos e melhoraram a eficiência com a FuelWise.
        </p>
      </div>
      <a href="cadastro_transportadora.php" class="btn-white">Inicie seu teste gratuito</a>
    </div>
  </section>

  <!-- Depoimentos -->
  <section class="testimonials">
    <div class="container">
      <h2>Confiado por Gestores de Frotas</h2>
      <p>Veja o que nossos clientes dizem sobre como a FuelWise transformou suas operações.</p>
      <div class="testimonials-grid">
        <div class="card">
          <p class="quote">"A FuelWise transformou completamente a forma como gerenciamos o abastecimento da nossa frota."</p>
          <p class="author">João Silva<br/><span>Gestor de Frotas, Acme Logística</span></p>
        </div>
        <div class="card">
          <p class="quote">"Acompanhar os gastos com combustível em tempo real nos deu uma visibilidade sem precedentes."</p>
          <p class="author">Maria Rodrigues<br/><span>Diretora de Operações, FastFreight</span></p>
        </div>
        <div class="card">
          <p class="quote">"O aplicativo com localizador de postos facilitou o dia a dia e ainda reduziu os custos."</p>
          <p class="author">Roberto Souza<br/><span>CEO, Transportes Souza</span></p>
        </div>
      </div>
    </div>
  </section>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>
</body>
</html>

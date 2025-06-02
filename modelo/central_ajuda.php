<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Central de Ajuda - FuelWise</title>
  <link rel="stylesheet" href="../css/index.css" />
  <link rel="stylesheet" href="../css/header.css" />
  <link rel="stylesheet" href="../css/footer.css" />
  <link rel="stylesheet" href="../css/landing.css" />
</head>
<body>
  <?php 
    include('../elements/header.php');
    include('../elements/alert.php');

    if (isset($_SESSION['id'])) {
      if ($_SESSION['adm'] == 0 && $_SESSION['gerente'] == 0) {
        header("Location: motorista/index.php?idtransportadora=" . $_SESSION['idtransportadora']);
        exit;
      }
    }
  ?>

<main class="container">
  <header>
    <h1>Central de Ajuda - FuelWise</h1>
  </header>

  <section>
    <h2>Perguntas Frequentes (FAQ)</h2>

    <h3>Como faço para cadastrar minha transportadora no FuelWise?</h3>
    <p>Para cadastrar sua transportadora no FuelWise, acesse a página de <strong>registro</strong>, preencha as informações solicitadas, como nome da empresa, CNPJ, e dados de contato, e siga as instruções para completar o cadastro. Após o envio, sua conta passará por uma análise para validação de informações, garantindo a segurança e a conformidade da plataforma.</p>

    <h3>Como registro o abastecimento de um caminhão?</h3>
    <p>Após realizar o login na plataforma, acesse a área de <strong>Abastecimentos</strong> no menu principal. Clique em <strong>“Novo Abastecimento”</strong> e preencha os dados necessários, como data, horário, valor, local de abastecimento, motorista responsável, quilometragem do veículo e tipo de combustível. É importante preencher todas as informações corretamente para gerar relatórios precisos e manter o controle financeiro atualizado.</p>

    <h3>Posso visualizar relatórios das viagens realizadas?</h3>
    <p>Sim. O FuelWise oferece relatórios detalhados sobre cada viagem realizada, incluindo dados como quilometragem percorrida, consumo de combustível, custo por viagem, e análise de desempenho da frota. Para acessar, vá até a seção <strong>Relatórios</strong> e selecione o período ou o veículo desejado. Você também pode exportar os relatórios em formatos como PDF ou Excel para facilitar o acompanhamento.</p>

    <h3>Como gerencio os motoristas e veículos da minha frota?</h3>
    <p>No painel administrativo, você encontrará a seção <strong>Gerenciamento de Frota</strong>. Lá, é possível adicionar novos motoristas e veículos, editar as informações existentes, como nome, CPF, CNH, placas dos caminhões e dados de manutenção, ou remover cadastros quando necessário. Essa área foi criada para facilitar a organização e a gestão eficiente da sua frota de transporte.</p>

    <h3>O FuelWise oferece suporte em tempo real?</h3>
    <p>O suporte do FuelWise está disponível por e-mail e através de formulários de contato na plataforma. Nossa equipe responderá o mais rápido possível, em horário comercial, para garantir que suas dúvidas e problemas sejam resolvidos com agilidade. Para dúvidas urgentes, recomendamos o e-mail: <a href="mailto:suporte@fuelwise.com">suporte@fuelwise.com</a>.</p>

    <h3>O FuelWise tem um aplicativo móvel?</h3>
    <p>Sim! O FuelWise possui um aplicativo para dispositivos móveis, disponível para Android e iOS, permitindo que motoristas e gestores acessem informações em tempo real, registrem abastecimentos, consultem relatórios e gerenciem suas atividades de forma prática, diretamente pelo celular.</p>

    <h2>Contato</h2>
    <p>Se você ainda tem dúvidas ou precisa de suporte adicional, entre em contato com a nossa equipe de atendimento pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a> ou <a href="mailto:suporte@fuelwise.com">suporte@fuelwise.com</a>.</p>
    <p>Estamos à disposição para ajudar a tornar sua experiência com o FuelWise a melhor possível!</p>
  </section>
</main>


  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>
</body>
</html>

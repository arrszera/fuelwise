<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Política de Privacidade - FuelWise</title>
  <link rel="stylesheet" href="../css/index.css" />
  <link rel="stylesheet" href="../css/header.css" />
  <link rel="stylesheet" href="../css/footer.css" />
  <link rel="stylesheet" href="../css/landing.css" />
</head>
<body>
  <?php 
    include('../elements/header.php');
    include('../elements/alert.php');

    if (isset($_SESSION['id'])){
      if ($_SESSION['adm'] == 0 && $_SESSION['gerente'] == 0){
        header("Location: motorista/index.php?idtransportadora=".$_SESSION['idtransportadora']); exit;
      }
    }
  ?>
</head>

<body>
  <header>
    <h1>Política de Privacidade - FuelWise</h1>
  </header>

  <main>
    <h2>1. Coleta de Dados</h2>
    <p>O aplicativo FuelWise coleta informações essenciais para o funcionamento de suas funcionalidades, como dados de localização, histórico de abastecimentos e informações do usuário para gestão de frota e controle financeiro.</p>

    <h2>2. Uso dos Dados</h2>
    <p>Os dados coletados são utilizados exclusivamente para aprimorar a experiência do usuário, gerar relatórios de viagens, exibir postos de combustíveis com localização e preços atualizados, e garantir a segurança financeira das transportadoras.</p>

    <h2>3. Compartilhamento de Dados</h2>
    <p>O FuelWise não compartilha informações pessoais com terceiros sem o consentimento prévio do usuário, exceto quando necessário para cumprir obrigações legais.</p>

    <h2>4. Segurança</h2>
    <p>Adotamos medidas de segurança para proteger os dados dos usuários contra acessos não autorizados, alterações, divulgações ou destruições.</p>

    <h2>5. Alterações na Política</h2>
    <p>Reservamo-nos o direito de alterar esta Política de Privacidade a qualquer momento. Recomenda-se que os usuários a revisem periodicamente.</p>

    <h2>6. Contato</h2>
    <p>Em caso de dúvidas sobre esta Política de Privacidade, entre em contato conosco pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>
  </main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>

</body>
</html>

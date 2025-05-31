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
  <h1>Termos de Serviço - FuelWise</h1>
  </header>

  <main>

<h2>1. Aceitação dos Termos</h2>
<p>Ao utilizar o FuelWise, o usuário concorda com os termos e condições estabelecidos neste documento. É importante que o usuário leia atentamente estas informações antes de utilizar o aplicativo.</p>

<h2>2. Uso do Aplicativo</h2>
<p>O FuelWise é destinado exclusivamente para auxiliar transportadoras de caminhões no gerenciamento de abastecimentos, controle de frota, geração de relatórios de viagens e monitoramento de postos de combustíveis credenciados.</p>

<h2>3. Responsabilidades do Usuário</h2>
<p>O usuário é responsável por fornecer informações precisas, manter suas credenciais de acesso seguras e utilizar a plataforma de forma ética e em conformidade com as leis aplicáveis.</p>

<h2>4. Limitação de Responsabilidade</h2>
<p>O FuelWise não se responsabiliza por eventuais danos ou prejuízos decorrentes do uso da plataforma, incluindo, mas não se limitando a, problemas técnicos, indisponibilidades temporárias ou imprecisões de dados fornecidos por terceiros.</p>

<h2>5. Alterações nos Termos</h2>
<p>O FuelWise reserva-se o direito de alterar estes Termos de Serviço a qualquer momento, mediante aviso prévio. Recomenda-se que o usuário revise periodicamente este documento para estar ciente de eventuais mudanças.</p>

<h2>6. Contato</h2>
<p>Em caso de dúvidas ou solicitações relacionadas a estes Termos de Serviço, o usuário pode entrar em contato pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>

  </main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>

</body>
</html>

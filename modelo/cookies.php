<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Política de Cookies - FuelWise</title>
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

  <header>
    <h1>Política de Cookies - FuelWise</h1>
  </header>

  <main>
    <h2>1. O que são Cookies?</h2>
    <p>Cookies são pequenos arquivos de texto armazenados no seu dispositivo quando você visita o nosso site ou utiliza o aplicativo FuelWise. Eles ajudam a melhorar a sua experiência, lembrando preferências e fornecendo funcionalidades personalizadas.</p>

    <h2>2. Como Utilizamos Cookies</h2>
    <p>O FuelWise utiliza cookies para armazenar informações de sessão, coletar dados estatísticos sobre o uso da plataforma, e personalizar conteúdos de acordo com suas preferências. Não utilizamos cookies para fins publicitários de terceiros.</p>

    <h2>3. Gerenciamento de Cookies</h2>
    <p>Você pode desativar ou excluir os cookies nas configurações do seu navegador. No entanto, isso pode impactar a funcionalidade e o desempenho do FuelWise.</p>

    <h2>4. Alterações na Política de Cookies</h2>
    <p>Podemos atualizar esta Política de Cookies a qualquer momento. Recomendamos que você a revise periodicamente para se manter informado sobre eventuais mudanças.</p>

    <h2>5. Contato</h2>
    <p>Se tiver dúvidas ou solicitações relacionadas a esta Política de Cookies, entre em contato pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>
  </main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>
</body>
</html>

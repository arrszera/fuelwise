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

  <header>
    <h1>Central de Ajuda - FuelWise</h1>
  </header>

  <main>
    <h2>Perguntas Frequentes (FAQ)</h2>

    <h3>Como faço para cadastrar minha transportadora no FuelWise?</h3>
    <p>Para cadastrar sua transportadora, acesse a página de registro, preencha as informações solicitadas e siga as instruções para completar o cadastro.</p>

    <h3>Como registro o abastecimento de um caminhão?</h3>
    <p>Após o login, acesse a seção de abastecimentos e clique em "Novo Abastecimento". Preencha as informações solicitadas, como data, hora, valor, local e motorista responsável.</p>

    <h3>Posso visualizar relatórios das viagens realizadas?</h3>
    <p>Sim, o FuelWise gera relatórios detalhados de cada viagem, incluindo informações sobre quilometragem, consumo de combustível e gastos.</p>

    <h3>Como gerencio os motoristas e veículos da minha frota?</h3>
    <p>Na área de gerenciamento, você pode adicionar, editar ou excluir dados de motoristas e veículos, facilitando o controle da frota.</p>

    <h3>Quem posso contatar para suporte?</h3>
    <p>Para suporte técnico ou dúvidas, entre em contato pelo e-mail: <a href="mailto:suporte@fuelwise.com">suporte@fuelwise.com</a>.</p>

    <h2>Contato</h2>
    <p>Caso precise de mais ajuda, não hesite em nos contatar pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>
  </main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>
</body>
</html>

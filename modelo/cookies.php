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

<main class="container">
  <header>
    <h1>Política de Cookies - FuelWise</h1>
  </header>

  <section>
    <h2>1. O que são Cookies?</h2>
    <p>Cookies são pequenos arquivos de texto armazenados no seu dispositivo (computador, smartphone ou tablet) quando você acessa o site ou utiliza o aplicativo FuelWise. Eles permitem que o site reconheça o seu dispositivo em visitas futuras, facilitando a navegação, personalizando conteúdos e ajudando a melhorar a experiência do usuário.</p>
    <p>Os cookies não coletam informações sensíveis ou pessoais sem o seu consentimento prévio, e você pode gerenciar suas preferências a qualquer momento.</p>

    <h2>2. Como Utilizamos Cookies</h2>
    <p>O FuelWise utiliza cookies para os seguintes fins:</p>
    <ul>
      <li><strong>Cookies Essenciais:</strong> Necessários para o funcionamento do site e do aplicativo, como autenticação de usuários, manutenção de sessões e segurança da plataforma.</li>
      <li><strong>Cookies de Desempenho:</strong> Coletam informações sobre como os usuários interagem com o FuelWise, como páginas visitadas, tempo de navegação e erros encontrados, para melhorar o desempenho e corrigir problemas.</li>
      <li><strong>Cookies de Funcionalidade:</strong> Permitem lembrar suas preferências, como idioma, região e configurações personalizadas, para oferecer uma experiência mais adequada às suas necessidades.</li>
      <li><strong>Cookies de Análise:</strong> Utilizados para gerar estatísticas anônimas e entender o comportamento de uso da plataforma, como frequência de visitas, páginas acessadas e interações gerais.</li>
    </ul>
    <p><strong>Importante:</strong> O FuelWise <strong>não utiliza cookies para publicidade de terceiros</strong> ou para coleta de dados sensíveis sem o seu consentimento.</p>

    <h2>3. Gerenciamento de Cookies</h2>
    <p>Você tem o controle sobre o uso de cookies e pode, a qualquer momento, desativar ou excluir cookies diretamente nas configurações do seu navegador. No entanto, desativar alguns cookies pode afetar a funcionalidade do site e limitar o uso de determinados recursos do FuelWise.</p>
    <p>Para gerenciar cookies no seu navegador, siga as instruções específicas para cada sistema (como Google Chrome, Mozilla Firefox, Microsoft Edge, Safari, entre outros). Consulte a documentação oficial do navegador para obter orientações detalhadas.</p>

    <h2>4. Alterações na Política de Cookies</h2>
    <p>O FuelWise reserva-se o direito de atualizar esta Política de Cookies a qualquer momento, a fim de refletir mudanças legais, técnicas ou de funcionalidade. Recomendamos que você revise esta política periodicamente para estar ciente de eventuais alterações. Quaisquer mudanças relevantes serão comunicadas por meio do nosso site ou aplicativo.</p>

    <h2>5. Contato</h2>
    <p>Em caso de dúvidas, solicitações ou para exercer seus direitos relacionados a esta Política de Cookies, entre em contato com a equipe do FuelWise pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>
  </section>
</main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>
</body>
</html>

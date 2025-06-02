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

  <main class="container">
  <header>
    <h1>Termos de Serviço - FuelWise</h1>
  </header>

  <section>
    <h2>1. Aceitação dos Termos</h2>
    <p>Ao acessar ou utilizar o FuelWise, o usuário declara que leu, compreendeu e concorda em estar vinculado a estes Termos de Serviço, bem como a quaisquer políticas e orientações adicionais que possam ser publicadas pela empresa. Caso o usuário não concorde com algum dos termos, recomenda-se que não utilize a plataforma.</p>

    <h2>2. Uso do Aplicativo</h2>
    <p>O FuelWise é uma solução digital desenvolvida para auxiliar transportadoras no gerenciamento de abastecimentos de caminhões, controle de frota, geração de relatórios de viagens e monitoramento de postos de combustíveis credenciados. O uso do aplicativo deve ser realizado de forma responsável e exclusivamente para os fins propostos pela plataforma.</p>
    <p>É proibido utilizar o FuelWise para fins ilícitos, enganosos, fraudulentos ou de maneira que possa prejudicar a operação da plataforma ou os direitos de terceiros.</p>

    <h2>3. Cadastro e Responsabilidades do Usuário</h2>
    <p>Para acessar determinadas funcionalidades do FuelWise, o usuário deverá realizar um cadastro fornecendo informações precisas, completas e atualizadas. É de responsabilidade do usuário manter seus dados corretos, assim como proteger suas credenciais de acesso (login e senha), evitando o uso não autorizado da conta.</p>
    <p>O usuário concorda em utilizar a plataforma de forma ética, respeitando as leis e regulamentos aplicáveis, não interferindo no funcionamento do sistema e não infringindo direitos de propriedade intelectual ou outros direitos de terceiros.</p>

    <h2>4. Privacidade e Proteção de Dados</h2>
    <p>O FuelWise coleta e trata dados pessoais de acordo com sua <a href="../modelo/privacidade.php">Política de Privacidade</a>. O usuário concorda que a coleta, armazenamento e uso de suas informações serão realizados para viabilizar a prestação dos serviços oferecidos pela plataforma, sempre respeitando a legislação vigente sobre proteção de dados pessoais.</p>

    <h2>5. Limitação de Responsabilidade</h2>
    <p>O FuelWise é fornecido "no estado em que se encontra" e "conforme disponível". Embora nos esforcemos para oferecer um serviço seguro, estável e confiável, não garantimos que o aplicativo estará livre de erros, interrupções ou falhas. A empresa não se responsabiliza por danos diretos ou indiretos, incluindo, mas não se limitando a, perda de dados, perda de lucros, interrupções de negócio, falhas técnicas, indisponibilidade temporária do sistema ou imprecisões de informações obtidas de terceiros.</p>

    <h2>6. Alterações nos Termos</h2>
    <p>O FuelWise poderá atualizar estes Termos de Serviço a qualquer momento, a seu exclusivo critério, mediante aviso prévio aos usuários, seja por meio da própria plataforma ou por e-mail. A continuidade do uso do FuelWise após a publicação das alterações será considerada como aceitação das novas condições.</p>
    <p>Recomendamos que o usuário consulte periodicamente este documento para estar ciente de quaisquer atualizações.</p>

    <h2>7. Propriedade Intelectual</h2>
    <p>Todos os direitos relacionados ao FuelWise, incluindo seu nome, logotipo, design, código-fonte, funcionalidades, textos, imagens e demais elementos, são de propriedade exclusiva da empresa desenvolvedora e estão protegidos pelas leis de direitos autorais, marcas registradas e demais legislações aplicáveis. É proibida a reprodução, distribuição ou modificação de qualquer conteúdo do FuelWise sem autorização prévia e expressa do titular dos direitos.</p>

    <h2>8. Rescisão e Encerramento de Conta</h2>
    <p>O FuelWise reserva-se o direito de encerrar ou suspender o acesso do usuário à plataforma a qualquer momento, sem aviso prévio, caso seja identificado o descumprimento destes Termos de Serviço, uso indevido da plataforma ou qualquer outra violação de direitos.</p>
    <p>O usuário também pode solicitar o encerramento de sua conta a qualquer momento, mediante solicitação por e-mail.</p>

    <h2>9. Legislação Aplicável e Foro</h2>
    <p>Estes Termos de Serviço são regidos pelas leis brasileiras. Quaisquer disputas ou controvérsias oriundas da utilização do FuelWise deverão ser resolvidas no foro da comarca de Curitiba, Paraná, Brasil, com exclusão de qualquer outro, por mais privilegiado que seja.</p>

    <h2>10. Contato</h2>
    <p>Em caso de dúvidas, sugestões ou solicitações relacionadas a estes Termos de Serviço, o usuário pode entrar em contato com a equipe do FuelWise pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>
  </section>
</main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>

</body>
</html>

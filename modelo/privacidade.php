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

<main class="container">
  <header>
    <h1>Política de Privacidade - FuelWise</h1>
  </header>

  <section>
    <h2>1. Coleta de Dados Pessoais</h2>
    <p>O FuelWise coleta informações pessoais e de uso do aplicativo com o objetivo de proporcionar uma melhor experiência ao usuário e garantir o funcionamento adequado das funcionalidades oferecidas. Os dados coletados incluem, mas não se limitam a:</p>
    <ul>
      <li>Dados de identificação pessoal: nome, e-mail, CPF, telefone, empresa associada;</li>
      <li>Dados de localização geográfica (GPS) para monitoramento de viagens e localização de postos de combustível;</li>
      <li>Histórico de abastecimentos, consumo de combustível e quilometragem percorrida;</li>
      <li>Dados técnicos, como endereço IP, tipo de dispositivo, sistema operacional e registros de acesso à plataforma.</li>
    </ul>
    <p>A coleta é realizada com o consentimento do usuário e sempre que necessário para a execução do contrato de serviços oferecido pela plataforma.</p>

    <h2>2. Finalidade do Uso dos Dados</h2>
    <p>Os dados coletados são utilizados exclusivamente para as seguintes finalidades:</p>
    <ul>
      <li>Gerenciar e otimizar o controle de frota, incluindo monitoramento de abastecimentos e desempenho de veículos;</li>
      <li>Fornecer relatórios gerenciais e de viagens personalizados para as transportadoras;</li>
      <li>Apresentar informações sobre postos de combustíveis credenciados, como localização, preços e serviços disponíveis;</li>
      <li>Manter a segurança das operações financeiras e integridade dos dados processados pelo sistema;</li>
      <li>Enviar notificações relacionadas ao uso do sistema, atualizações de funcionalidades ou alterações nos termos;</li>
      <li>Cumprir obrigações legais, regulatórias ou atender solicitações de autoridades competentes.</li>
    </ul>

    <h2>3. Compartilhamento de Dados</h2>
    <p>O FuelWise não compartilha dados pessoais com terceiros sem o consentimento explícito do usuário, exceto nas seguintes hipóteses:</p>
    <ul>
      <li>Quando necessário para cumprir obrigações legais ou atender solicitações judiciais ou de autoridades competentes;</li>
      <li>Para a execução de serviços essenciais à operação da plataforma, como hospedagem de dados e serviços de nuvem, assegurando que esses terceiros respeitem as normas de segurança e confidencialidade;</li>
      <li>Em casos de fusão, aquisição ou reestruturação societária, mediante aviso prévio ao usuário.</li>
    </ul>

    <h2>4. Armazenamento e Segurança dos Dados</h2>
    <p>O FuelWise adota medidas técnicas e administrativas adequadas para proteger os dados pessoais contra acessos não autorizados, perdas, destruição, alterações ou divulgações indevidas. Isso inclui:</p>
    <ul>
      <li>Armazenamento seguro em servidores protegidos;</li>
      <li>Controle de acesso restrito às informações;</li>
      <li>Uso de criptografia e protocolos de segurança nas transmissões de dados;</li>
      <li>Treinamento da equipe sobre boas práticas de privacidade e proteção de dados.</li>
    </ul>
    <p>No entanto, o usuário reconhece que nenhum sistema é completamente invulnerável a ataques cibernéticos e que o FuelWise não pode garantir segurança absoluta.</p>

    <h2>5. Direitos do Usuário</h2>
    <p>Em conformidade com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018 - LGPD), o usuário tem direito a:</p>
    <ul>
      <li>Solicitar a confirmação da existência de tratamento de seus dados pessoais;</li>
      <li>Acessar, corrigir ou atualizar seus dados cadastrais;</li>
      <li>Solicitar a anonimização, bloqueio ou exclusão de dados desnecessários ou excessivos;</li>
      <li>Revogar o consentimento a qualquer momento, mediante solicitação formal;</li>
      <li>Solicitar a portabilidade dos dados para outro fornecedor de serviço;</li>
      <li>Obter informações sobre o compartilhamento de dados com terceiros.</li>
    </ul>
    <p>Para exercer esses direitos, o usuário deve entrar em contato com o FuelWise pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>

    <h2>6. Retenção de Dados</h2>
    <p>Os dados pessoais serão armazenados pelo tempo necessário para atender às finalidades descritas nesta política, respeitando prazos legais e regulatórios. Após esse período, os dados serão eliminados de forma segura, salvo se houver interesse legítimo ou obrigação legal de retenção.</p>

    <h2>7. Alterações na Política de Privacidade</h2>
    <p>O FuelWise se reserva o direito de alterar esta Política de Privacidade a qualquer momento. Alterações relevantes serão comunicadas por meio da plataforma ou por e-mail, e a versão atualizada estará sempre disponível para consulta. Recomenda-se que o usuário revise periodicamente este documento para estar ciente de possíveis mudanças.</p>

    <h2>8. Contato</h2>
    <p>Em caso de dúvidas, solicitações ou reclamações sobre esta Política de Privacidade, o usuário pode entrar em contato com a equipe do FuelWise pelo e-mail: <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a>.</p>

  </section>
</main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>

</body>
</html>

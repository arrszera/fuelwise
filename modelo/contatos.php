<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contato - FuelWise</title>
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
    <h1>Fale Conosco - FuelWise</h1>
    <p>Estamos aqui para ajudar! Entre em contato conosco pelo formulário abaixo ou pelos nossos canais de atendimento.</p>
  </header>

  <main class="container">
  <section class="contact-form-section">
    <h2>Formulário de Contato</h2>
    <form action="processa_contato.php" method="POST" class="contact-form">
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Seu nome" required />
      </div>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" required />
      </div>

      <div class="form-group">
        <label for="assunto">Assunto:</label>
        <input type="text" id="assunto" name="assunto" placeholder="Assunto da sua mensagem" required />
      </div>

      <div class="form-group">
        <label for="mensagem">Mensagem:</label>
        <textarea id="mensagem" name="mensagem" rows="6" placeholder="Digite sua mensagem aqui..." required></textarea>
      </div>

      <div class="form-group form-submit">
        <button type="submit">Enviar Mensagem</button>
      </div>
    </form>
  </section>
</main>
    </section>

    <section>
      <h2>Outros Canais de Atendimento</h2>
      <p><strong>E-mail Geral:</strong> <a href="mailto:contato@fuelwise.com">contato@fuelwise.com</a></p>
      <p><strong>Suporte Técnico:</strong> <a href="mailto:suporte@fuelwise.com">suporte@fuelwise.com</a></p>
      <p><strong>Telefone:</strong> +55 (11) 99999-9999</p>
      <p><strong>Endereço:</strong> Rua Exemplo, 123, Bairro Centro, São Paulo - SP, Brasil</p>
    </section>

    <section>
      <h2>Horário de Atendimento</h2>
      <p>De segunda a sexta-feira, das 9h às 18h (horário de Brasília).</p>
    </section>
  </main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>
</body>
</html>

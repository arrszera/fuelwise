<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Empresa</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/cadastro.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/footer.css">
</head>
<body class="body">

  <?php include('../elements/header.php') ?>

  <main class="main">
    <div class="card" role="main" aria-label="Formulário de login">
      <div class="card-header">
        <div class="logo-circle" aria-hidden="true"></div>
        <h1 class="title" style="margin-top: 1rem;">Bem-vindo de volta</h1>
        <p class="subtitle">Digite suas credenciais para acessar sua conta</p>
      </div>
      <div class="card-body">
        <form id="loginForm" action="" method="POST" novalidate>
          <div class='form-row'>
            <div class="form-group">
              <label for="email">E-mail</label>
              <input
                id="email"
                name="email"
                type="email"
                placeholder="joao.silva@exemplo.com"
                autocomplete="email"
              />
              <p class="hint"></p>
            </div>
          </div>
          <div class='form-row'>
            <div class="form-group">
              <label for="password">Senha</label>
              <input
                id="senha"
                name="senha"
                type="password"
                placeholder="********"
              />
              <p class="hint"></p>
            </div>
          </div>
          <div class="form-actions right">
            <button class="btn primary" type="button" onclick="validarLogin(event, this)">Entrar</button>
          </div>
        </form>
      </div>
      <div class="card-footer">
        <a href="#" class="btn-link">Esqueceu sua senha?</a>
        <p>
          Não tem uma conta? 
          <a href="cadastro_transportadora_v2.php" class="btn-link">Cadastre-se</a>
        </p>
      </div>
    </div>
  </main>

  <?php include('../elements/footer.php') ?>
  
  <script src='../js/index.js'></script>
  <script src='../js/login.js'></script>
</body>
</html>

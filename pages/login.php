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
        <div class="logo-circle" aria-hidden="true">
          <svg
                fill="#2563eb"
                width="48" height="48" 
                class="w-8 h-8" 
                viewBox="0 0 24 24" 
                fill="currentColor" 
                xmlns="http://www.w3.org/2000/svg"
                >
                <path 
                    d="M19.77 7.23L19.78 7.22L16.06 3.5L15 4.56L17.11 6.67C16.17 7.03 15.5 7.93 15.5 9C15.5 10.38 16.62 11.5 18 11.5C18.36 11.5 18.69 11.42 19 11.29V18.5C19 19.05 18.55 19.5 18 19.5C17.45 19.5 17 19.05 17 18.5V14C17 12.9 16.1 12 15 12H14V5C14 3.9 13.1 3 12 3H6C4.9 3 4 3.9 4 5V21H14V13.5H15.5V18.5C15.5 19.88 16.62 21 18 21C19.38 21 20.5 19.88 20.5 18.5V9C20.5 8.31 20.22 7.68 19.77 7.23ZM12 13.5V19H6V12H12V13.5ZM12 10H6V5H12V10ZM18 10C17.45 10 17 9.55 17 9C17 8.45 17.45 8 18 8C18.55 8 19 8.45 19 9C19 9.55 18.55 10 18 10Z" 
                />
            </svg>
        </div>
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
          <a href="cadastro_transportadora.php" class="btn-link">Cadastre-se</a>
        </p>
      </div>
    </div>
  </main>

  <?php include('../elements/footer.php') ?>
  
  <script src='../js/index.js'></script>
  <script src='../js/login.js'></script>
</body>
</html>

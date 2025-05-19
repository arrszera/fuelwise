<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Empresa</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/footer.css">
</head>
<body class="body">

  <?php include('../elements/header.php') ?>

  <main class="main">
    <div class="container">
      <div class="text-center">
        <div class="logo-circle"></div>
        <h1 class="title">Faça o Login na FuelWise</h1>
        <p class="subtitle">Preencha os dados abaixo para realizar seu Login na plataforma</p>
      </div>

      <div class="card">
        <div class="card-header">
          <h2>Login</h2>
        </div>
        <div class="card-body"> 
          <div class="tab-content" id="empresa">
            <form class="form">
                <div class="form-group">
                    <label>Email</label>
                    <input placeholder="Digite seu email" name='nomeEmpresa' />
                    <p class="hint hidden"></p>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" placeholder="********" name='senha'/>
                </div>
 
        </div>
        <div class="card-footer">
          Não possui uma conta? <a href="cadastro_transportadora_v2.php">Faça o Cadastro da Transportadora</a>
        </div>
      </div>
    </div>
  </main>
  <?php include('../elements/footer.php') ?>
  
  <script src='../js/index.js'></script>
  <script src='../js/cadastro.js'></script>
</body>
</html>

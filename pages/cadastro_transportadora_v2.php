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
  <?php
    include('../elements/header.php');
    include('../elements/alert.php'); 
  ?>

  <main class="main">
    <div class="container">
      <div class="text-center">
        <div class="logo-circle">
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
        <h1 class="title">Cadastre sua Empresa</h1>
        <p class="subtitle">Preencha o formulário abaixo para solicitar uma conta para sua empresa</p>
      </div>

      <div class="card">
        <div class="card-header">
          <h2>Cadastro da Empresa</h2>
          <p>Preencha ambas as seções para concluir seu cadastro</p>
        </div>
        <div class="card-body">
          <div class="tabs">
            <button class="tab-btn active" data-tab="empresa">Informações da Empresa</button>
            <button class="tab-btn" data-tab="pessoal">Informações Pessoais</button>
          </div>

          <div class="tab-content" id="empresa">
            <form class="form" method="POST" action="">
                <div class="form-group">
                    <label>Nome da Empresa</label>
                    <input placeholder="Nome da empresa" name="nomeEmpresa" 
                           value="<?= htmlspecialchars($_POST['nomeEmpresa'] ?? '') ?>" />
                    <p class="hint hidden"></p>
                </div>
                <div class="form-group">
                  <label>Logradouro</label>
                  <textarea placeholder="Nome da rua" name="endereco"><?= htmlspecialchars($_POST['endereco'] ?? '') ?></textarea>
                  <p class="hint hidden"></p>
                </div>
                <div class="form-row">
                  <div class="form-group">
                      <label>CEP</label>
                      <input placeholder="01000-000" name="cep"
                             value="<?= htmlspecialchars($_POST['cep'] ?? '') ?>" />
                      <p class="hint hidden"></p>
                  </div>
                  <div class="form-group">
                      <label>Cidade</label>
                      <input placeholder="São Paulo" name="cidade"
                             value="<?= htmlspecialchars($_POST['cidade'] ?? '') ?>" />
                      <p class="hint hidden"></p>
                  </div>
                  <div class="form-group">
                      <label>Estado</label>
                      <input placeholder="SP" name="estado"
                             value="<?= htmlspecialchars($_POST['estado'] ?? '') ?>" />
                      <p class="hint hidden"></p>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                      <label>Telefone da Empresa</label>
                      <input placeholder="(11) 98765-4321" name="telefoneEmpresa"
                             value="<?= htmlspecialchars($_POST['telefoneEmpresa'] ?? '') ?>" />
                      <p class="hint hidden"></p>
                  </div>
                  <div class="form-group">
                      <label>CNPJ / Identificação Fiscal</label>
                      <input placeholder="12.345.678/0001-99" name="cnpj"
                             value="<?= htmlspecialchars($_POST['cnpj'] ?? '') ?>" />
                      <p class="hint">Número de Identificação Fiscal da Empresa</p>
                  </div>
                </div>
                <div class="form-actions right">
                  <button class="btn primary" type="button" onclick="alterarAba('empresa', 'pessoal')">Continuar para Informações Pessoais</button>
                </div>
            </form>
          </div>

          <div class="tab-content hidden" id="pessoal">
            <form class="form" method="POST" action="cadastro_transportadora_php_v2.php">
                <div class="form-row">
                  <div class="form-group">
                      <label>Nome</label>
                      <input placeholder="João" name="nomePessoal"
                             value="<?= htmlspecialchars($_POST['nomePessoal'] ?? '') ?>" />
                      <p class="hint hidden"></p>
                  </div>
                  <div class="form-group">
                      <label>Sobrenome</label>
                      <input placeholder="Silva" name="sobrenome"
                             value="<?= htmlspecialchars($_POST['sobrenome'] ?? '') ?>" />
                      <p class="hint hidden"></p>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label>CPF</label>
                    <input type="text" placeholder="Ex: 123.456.789-12" name="cpf"
                           value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" />
                    <p class="hint"></p>
                  </div>
                  <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" placeholder="joao.silva@exemplo.com" name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
                    <p class="hint">Este será seu usuário para login</p>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                      <label>Senha</label>
                      <input type="password" placeholder="********" name="senha" />
                      <p class="hint">A senha deve ter ao menos 8 caracteres</p>
                  </div>
                  <div class="form-group">
                      <label>Confirmar Senha</label>
                      <input type="password" placeholder="********" name="confirmarSenha" />
                      <p class="hint hidden"></p>
                  </div>
                  <div class="form-group">
                    <label>Telefone Pessoal</label>
                    <input placeholder="(11) 98765-4321" name="telefonePessoal"
                           value="<?= htmlspecialchars($_POST['telefonePessoal'] ?? '') ?>" />
                    <p class="hint hidden"></p>
                  </div>
                </div>
                <div class="form-actions space-between">
                    <button type="button" class="btn" onclick="alterarAba('pessoal', 'empresa', false)">Voltar para Informações da Empresa</button>
                    <button type="submit" class="btn primary" onclick="validarFormularioCompleto(event, this)">Enviar Cadastro</button>
                </div>
            </form>
          </div>
        </div>
        <div class="card-footer">
          Já tem uma conta? <a href="login.php">Faça login aqui</a>
        </div>
      </div>
    </div>
  </main>

  <?php include('../elements/footer.php') ?>

  <script src="../js/index.js"></script>
  <script src="../js/cadastro.js"></script>

</body>
</html>

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
        <div class="logo-circle"></div>
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

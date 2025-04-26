<?php 
    include('autenticacaoGerente.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar posto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' href='../../css/header.css'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include('../../elements/header.php'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h2> Atualizando o usuario: <?php echo $_GET['nome']; ?> </h2>
				<h2> ID : <?php echo $_GET['idusuario']; ?> </h2>
				</div>
		</div>
		
		<div class="row">
			<div class="col">
			<form method="POST" action="alterar_integrante_php.php?&idusuario=<?php echo $_GET['idusuario'];?>&idtransportadora=<?php echo $_GET['idtransportadora'];?>" onsubmit="">
                <div class="row">
                    <div class="col">
                        <p>Digite aqui o nome atualizado</p>
                        <input type="text"
                        name="nome" id="nome" class="form-control"
                        value="<?php echo $_GET['nome']; ?>" required>
                    </div>
                    <div class="col">
                        <p>Digite aqui o email atualizado</p>
                        <input type="text"
                        name="email" id="email" class="form-control"
                        value="<?php echo $_GET['email']; ?>" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <p>Digite aqui o email atualizado</p>
                        <input type="text"
                        name="telefone" id="telefone" class="form-control"
                        value="<?php echo $_GET['telefone']; ?>" required>
                    </div>
                    <div class="col">
                        <p>Digite aqui o CPF atualizado</p>
                        <input type="text"
                        name="cpf" id="cpf" class="form-control"
                        value="<?php echo $_GET['cpf']; ?>" required>
                    </div>
                    <input type="hidden" name="idRequerente" value="<?php echo $_SESSIOn['id'] ?>">
                </div>
                <button type="submit" class="mt-2 btn btn-primary">
                    Enviar
                </button>
			</form>
			</div>
		</div>
		
		
	</div>
    <script src="../../js/index.js"></script>
</body>
</html>

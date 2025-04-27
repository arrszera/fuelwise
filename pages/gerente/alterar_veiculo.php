<?php 
    include('autenticacaoGerente.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar veículo</title>
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
				<h2> Atualizando o veiculo: <?php echo $_GET['placa']; ?> </h2>
				<h2> ID : <?php echo $_GET['idveiculo']; ?> </h2>
				</div>
		</div>
		
		<div class="row">
			<div class="col">
			<form method="POST" action="alterar_veiculo_php.php?&idveiculo=<?php echo $_GET['idveiculo'];?>&idtransportadora=<?php echo $_GET['idtransportadora'];?>" onsubmit="">
                <div class="row">
                    <div class="col">
                        <p>Digite aqui a palca atualizada</p>
                        <input type="text"
                        name="placa" id="placa" class="form-control"
                        value="<?php echo $_GET['placa']; ?>" required>
                    </div>
                    <div class="col">
                        <p>Digite aqui o modelo atualizado</p>
                        <input type="text"
                        name="modelo" id="modelo" class="form-control"
                        value="<?php echo $_GET['modelo']; ?>" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <p>Digite aqui a quantidade de eixos atualizados</p>
                        <input type="text"
                        name="eixos" id="eixos" class="form-control"
                        value="<?php echo $_GET['eixos']; ?>" required>
                    </div>
                    <div class="col">
                        <p>Digite aqui a observação atualizada</p>
                        <input type="text"
                        name="observacao" id="observacao" class="form-control"
                        value="<?php echo $_GET['observacao']; ?>" required>
                    </div>
                    <input type="hidden" name="idRequerente" value="<?php echo $_SESSION['id'] ?>">
                </div>
                <button type="submit" class="mt-2 btn btn-primary">
                    Atualizar
                </button>
			</form>
			</div>
		</div>
		
		
	</div>
    <script src="../../js/index.js"></script>
</body>
</html>

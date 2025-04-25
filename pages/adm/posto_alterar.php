<?php 
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar posto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h2> Atualizando o posto: <?php echo $_GET['nome']; ?> </h2>
				<h2> ID : <?php echo $_GET['id']; ?> </h2>
				</div>
		</div>
		
		<div class="row">
			<div class="col">
			<form method="POST" action="posto_alterar_php.php?&id=<?php echo $_GET['id'];?>" onsubmit="">
                <div class="row">
                    <div class="col">
                        <p>Digite aqui o novo nome do posto</p>
                        <input type="text"
                        name="nomePosto" id="nomePosto" class="form-control"
                        value="<?php echo $_GET['nome']; ?>" required>
                    </div>

                    <div class="col">
                        <p>Digite aqui o novo endereço do posto</p>			
                        <input type="text"
                        name="enderecoPosto" id="enderecoPosto" class="form-control"
                        value="<?php echo $_GET['endereco']; ?>" required>
                    </div>

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

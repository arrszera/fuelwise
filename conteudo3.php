<?php
	if(isset($_POST['id_transp']) && isset($_POST['nome_transp']) && isset($_POST['endereco']) && isset($_POST['cnpj'])) {
		$obj = conecta_db();
		$query = "UPDATE tb_transportadora
		SET nome_transp = '".$_POST['nome_transp']."',
		endereco = '".$_POST['endereco']."'	,
		cnpj = '".$_POST['cnpj']."'
		WHERE id_transp = '".$_POST['id_transp']."'";
		$resultado = $obj->query($query);
		if($resultado){
			header("Location: index.php?page=1");
			exit();
		}else{
			echo "<span> class='alert alert-danger'> Não funcionou</span>";
		}
	}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>FuelWise</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h2> CRUD - Update - Atualizando a transportadora: <?php echo $_GET['nome']; ?> </h2>
			</div>
		</div>
	</div>
		<div class="row">
			<div class="col">
			
<form method="POST" action="conteudo3.php">
			<input type="hidden" name="id_transp" value="<?php echo $_GET['id']; ?>">
			<input type="text"
					name="nome_transp" class="form-control"
					placeholder="Digite o novo nome aqui">
					<input type="text"
					name="endereco" class="form-control"
					placeholder="Digite o novo endereco aqui">
					<input type="text"
					name="cnpj" class="form-control"
					placeholder="Digite o novo cnpj aqui">				
			<button type="submit" class="btn btn-primary">Enviar</button>
			</div>
		</div>
</body>
</html>

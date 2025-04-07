<?php
	if(isset($_POST['nome_posto'])){
		$obj = conecta_db();
		$query = "INSERT INTO tb_posto(nome_posto, endereco_posto) 
			VALUES ('".$_POST['nome_posto']."', '".$_POST['endereco_posto']."')";
		$resultado = $obj->query($query);

		if($resultado){
			header("location: index.php");
		}else{
			echo "<span> class='alert alert-danger'> Não funcionou</span>";
		}
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ADD POSTO</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h2> Inserir novo Posto de Combustível </h2>
			</div>
		</div>
	</div>
	<form method="POST" action ="index.php?page=4">
		<div class="row">
			<div class="col">
				<p>Digite aqui o nome do Posto</p>
				<input type="text"
				name="nome_posto" id="nome_posto" class="form-control"
				placeholder="XXXXXXX" required>
			</div>

				<div class="col">
				<p>Digite aqui o endereço</p>			
				<input type="text"
				name="endereco_posto" id="endereco_posto" class="form-control"
				placeholder="Rua xxxxxx 111" required>
			</div>

            
		</div>
		<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<script>

</script>
</body>
</html>

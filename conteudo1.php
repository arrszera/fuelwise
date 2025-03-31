<?php
	if(isset($_POST['nome_transp'])){
		$obj = conecta_db();
		$query = "INSERT INTO tb_transportadora(nome_transp, endereco, cnpj) 
			VALUES ('".$_POST['nome_transp']."', '".$_POST['endereco']."', '".$_POST['cnpj']."')";
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
  <title>Meu primeiro CRUD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h2> inserir nova transportadora </h2>
			</div>
		</div>
	</div>
	<form method="POST" action ="index.php?page=1">
		<div class="row">
			<div class="col">
				<input type="text"
				name="nome_transp" class="form-control"
				placeholder="Digite o nome aqui">
			</div>
				<div class="col">			
				<input type="text"
				name="endereco" class="form-control"
				placeholder="Digite seu endereco aqui">
			</div>
			<div class="col">
				<input type="text"
				name="cnpj" class="form-control"
				placeholder="Digite seu cnpj aqui">
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Enviar</button>
</form>

</body>
</html>

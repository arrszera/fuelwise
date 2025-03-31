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
				<h2> Inserir nova transportadora </h2>
			</div>
		</div>
	</div>
	<form method="POST" action ="index.php?page=1" onsubmit="return validarCNPJ()">
		<div class="row">
			<div class="col">
				<p>Digite aqui o nome da transportadora</p>
				<input type="text"
				name="nome_transp" id="nome_transp" class="form-control"
				placeholder="XXXXXXX" required>
			</div>

				<div class="col">
				<p>Digite aqui o endereço</p>			
				<input type="text"
				name="endereco" id="endereco" class="form-control"
				placeholder="Rua xxxxxx 111" required>
			</div>

			<div class="col">
			<p>Digite aqui o CNPJ</p>
				<input type="text"
				name="cnpj" id="cnpj" class="form-control"
				placeholder="11111111111111" required>
			</div>

		</div>
		<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<script>
		function validarCNPJ() {
			const cnpj = document.getElementById('cnpj').value;
			const cnpjRegex = /^\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2}$/;

			if (!cnpjRegex.test(cnpj)) {
				alert("CNPJ inválido! Digite no formato correto.");
				return false;
			}
			return true; 
		}
</script>
</body>
</html>

<?php
	if(isset($_POST['placa'])){
		$obj = conecta_db();
		$query = "INSERT INTO tb_caminhao(placa, modelo, eixos, observacao) 
			VALUES ('".$_POST['placa']."', '".$_POST['modelo']."', '".$_POST['eixos']."', '".$_POST['observacao']."')";
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
				<h2> Inserir novo caminhao </h2>
			</div>
		</div>
	</div>
	<form method="POST" action ="index.php?page=7" onsubmit="return validarCNPJ()">
		<div class="row">
			<div class="col">
				<p>Digite aqui a nova placa</p>
				<input type="text"
				name="placa" id="placa" class="form-control"
				placeholder="XXXXXXX" required>
			</div>

				<div class="col">
				<p>Digite aqui o modelo</p>			
				<input type="text"
				name="modelo" id="modelo" class="form-control"
				placeholder="XXXXXXX" required>
			</div>

			<div class="col">
			<p>Digite aqui os eixos</p>
				<input type="number"
				name="eixos" id="eixos" class="form-control"
				placeholder="11111111111111" max=3 required>
			</div>

            <div class="col">
			<p>Digite aqui a observação</p>
				<input type="text"
				name="observacao" id="observacao" class="form-control"
				placeholder="XXXXXXX" required>
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

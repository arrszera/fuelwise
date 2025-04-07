<?php
	if(isset($_POST['placa'])){
		$obj = conecta_db();
		$query = "INSERT INTO tb_caminhao(placa, modelo, eixos, observacao) 
			VALUES ('".$_POST['placa']."', '".$_POST['modelo']."', '".$_POST['eixos']."', '".$_POST['observacao']."')";
		$resultado = $obj->query($query);

		if($resultado){
			header("location: index.php");
		}else{
			echo "<span class='alert alert-danger'> Não funcionou</span>";
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
	<form method="POST" action="index.php?page=7" onsubmit="return validarFormulario()">
		<div class="row">
			<div class="col">
				<p>Digite aqui a placa*</p>
				<input type="text"
				name="placa" id="placa" class="form-control"
				placeholder="ABC1D23" required>
			</div>

			<div class="col">
				<p>Digite aqui o modelo*</p>			
				<input type="text"
				name="modelo" id="modelo" class="form-control"
				placeholder="Ex: Volvo FH" required>
			</div>

			<div class="col">
				<p>Digite aqui os eixos*</p>
				<input type="number"
				name="eixos" id="eixos" class="form-control"
				placeholder="3" min=3 max=10 required>
			</div>

            <div class="col">
				<p>Digite aqui a observação</p>
				<input type="text"
				name="observacao" id="observacao" class="form-control"
				placeholder="Ex: Caminhão em manutenção" required>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Enviar</button>
	</form>

	<script>
		function validarFormulario() {
			const placa = document.getElementById('placa').value.trim().toUpperCase();
			const regexPlaca = /^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/;

			if (!regexPlaca.test(placa)) {
				alert("Placa inválida! Use o formato ABC1D23 ou ABC1234.");
				return false;
			}
			return true;
		}
	</script>
</body>
</html>

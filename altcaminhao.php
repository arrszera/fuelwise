<?php
	if(isset($_POST['placa'])){
		$obj = conecta_db();
		$query = "UPDATE tb_caminhao
		SET placa = '".$_POST['placa']."',
		modelo = '".$_POST['modelo']."'	,
        eixos = '".$_POST['eixos']."',
		observacao = '".$_POST['observacao']."'
        WHERE id_caminhao = '".$_GET['id']."'";
		$resultado = $obj->query($query);
		if($resultado){
			header("location: index.php");
		}else{
			echo "<span class='alert alert-danger'>Não funcionou!</span>";
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
				<h2> Atualizando o caminhao de placa: <?php echo $_GET['placa']; ?> </h2>
				<h2> ID : <?php echo $_GET['id']; ?> </h2>
				</div>
		</div>
		
		<div class="row">
			<div class="col">
			
			<form 
			method="POST" 
			action="index.php?page=9&id=<?php echo $_GET['id'];?>">

		<div class="row">
			<div class="col">
				<p>Digite aqui a nova placa do caminhao</p>
				<input type="text"
				name="placa" id="placa" class="form-control"
				placeholder="XXXXXXX" required>
			</div>

				<div class="col">
				<p>Digite aqui o novo modelo</p>			
				<input type="text"
				name="modelo" id="modelo" class="form-control"
				placeholder="Volvo xxx" required>
			</div>

			<div class="col">
			<p>Digite aqui a nova quantidade de eixos</p>
				<input type="number"
				name="eixos" id="eixos" class="form-control"
				placeholder="1" max=3 min=1 required>
			</div>
            
			<div class="col">
			<p>Digite aqui a nova observação</p>
				<input type="text"
				name="observacao" id="observacao" class="form-control"
				placeholder="xxxxxxxx" required>
			</div>

			
		</div>
			<button type="submit" 
					class="mt-2 btn btn-primary">Enviar</button>
			
			</form>
			</div>
		</div>
		
		
	</div>
</body>
<script>

</script>
</html>

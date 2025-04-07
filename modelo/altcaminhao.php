<?php
include_once('conecta_db.php'); 
$obj = conecta_db();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM tb_caminhao WHERE id_caminhao = '$id'";
        $result = $obj->query($query);

        if ($result && $result->num_rows > 0) {
            $dados = $result->fetch_assoc();
        } else {
            echo "<span class='alert alert-danger'>transportadora não encontrado!</span>";
            exit;
        }
    }

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
<html lang="pt-br">
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
			action="index.php?page=9&id=<?php echo $_GET['id'];?>"
			onsubmit="return validarPlaca()">

		<div class="row">
			<div class="col">
				<p>Digite aqui a nova placa do caminhao</p>
				<input type="text"
				name="placa" id="placa" class="form-control"
				value="<?php echo $dados['placa']; ?>" required>
			</div>

				<div class="col">
				<p>Digite aqui o novo modelo</p>			
				<input type="text"
				name="modelo" id="modelo" class="form-control"
				value="<?php echo $dados['modelo']; ?>" required>
			</div>

			<div class="col">
			<p>Digite aqui a nova quantidade de eixos</p>
				<input type="number"
				name="eixos" id="eixos" class="form-control"
				placeholder="3" min=3 max=10 required>
			</div>
            
			<div class="col">
			<p>Digite aqui a nova observação</p>
				<input type="text"
				name="observacao" id="observacao" class="form-control"
				value="<?php echo $dados['observacao']; ?>" required>
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
	function validarPlaca() {
		const placa = document.getElementById('placa').value.toUpperCase();
		const regex = /^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/;

		if (!regex.test(placa)) {
			alert("Placa inválida! Digite no formato ABC1D23.");
			return false;
		}
		return true;
	}
</script>
</html>

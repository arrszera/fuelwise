<?php
	if(isset($_POST['nome_posto'])){
		$obj = conecta_db();
		$query = "UPDATE tb_posto
		SET nome_posto = '".$_POST['nome_posto']."',
		endereco_posto = '".$_POST['endereco_posto']."'	,
		cnpj = '".$_POST['cnpj']."',
        email_posto = '".$_POST['email_posto']."',
		senha_posto = '".$_POST['senha_posto']."'
        WHERE id_posto = '".$_GET['id']."'";
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
				<h2> Atualizando o posto: <?php echo $_GET['nome_posto']; ?> </h2>
				<h2> ID : <?php echo $_GET['id']; ?> </h2>
				</div>
		</div>
		
		<div class="row">
			<div class="col">
			
			<form 
			method="POST" 
			action="index.php?page=6&id=<?php echo $_GET['id'];?>"
			onsubmit="return validarCNPJ()">

		<div class="row">
			<div class="col">
				<p>Digite aqui o novo nome do posto</p>
				<input type="text"
				name="nome_posto" id="nome_posto" class="form-control"
				placeholder="XXXXXXX" required>
			</div>

				<div class="col">
				<p>Digite aqui o novo endereço</p>			
				<input type="text"
				name="endereco_posto" id="endereco_posto" class="form-control"
				placeholder="Rua xxxxxx 111" required>
			</div>

			<div class="col">
			<p>Digite aqui o novo CNPJ</p>
				<input type="text"
				name="cnpj" id="cnpj" class="form-control"
				placeholder="11111111111111" required>
			</div>
            
			<div class="col">
			<p>Digite aqui o novo Email</p>
				<input type="text"
				name="email_posto" id="email_posto" class="form-control"
				placeholder="11111111111111" required>
			</div>
            
			<div class="col">
			<p>Digite aqui a nova senha</p>
				<input type="password"
				name="senha_posto" id="senha_posto" class="form-control"
				placeholder="11111111111111" required>
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
</html>

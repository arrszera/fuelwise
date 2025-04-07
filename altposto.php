<?php
include_once('conecta_db.php'); 
$obj = conecta_db();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM tb_posto WHERE id_posto = '$id'";
        $result = $obj->query($query);

        if ($result && $result->num_rows > 0) {
            $dados = $result->fetch_assoc();
        } else {
            echo "<span class='alert alert-danger'>Posto não encontrado!</span>";
            exit;
        }
    }


	if(isset($_POST['nome_posto'])){
		$obj = conecta_db();
		$query = "UPDATE tb_posto
		SET nome_posto = '".$_POST['nome_posto']."',
		endereco_posto = '".$_POST['endereco_posto']."'	,
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
				<h2> Atualizando o posto: <?php echo $dados['nome_posto']; ?> </h2>
				<h2> ID : <?php echo $_GET['id']; ?> </h2>
				</div>
		</div>
		
		<div class="row">
			<div class="col">
			
			<form 
			method="POST" 
			action="index.php?page=6&id=<?php echo $_GET['id'];?>"
			>

		<div class="row">
			<div class="col">
				<p>Digite aqui o novo nome do posto</p>
				<input type="text"
				name="nome_posto" id="nome_posto" class="form-control"
				value="<?php echo $dados['nome_posto']; ?>" required>
			</div>

				<div class="col">
				<p>Digite aqui o novo endereço</p>			
				<input type="text"
				name="endereco_posto" id="endereco_posto" class="form-control"
				value="<?php echo $dados['endereco_posto']; ?>" required>
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

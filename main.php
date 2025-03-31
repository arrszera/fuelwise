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
				<h2> FuelWise </h2>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<a href="index.php?page=1" 
			class="btn btn-primary">Adicionar novo registo</a>
		
			<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>ID</th>
					<th>Nome</th>
					<th>ENDERECO</th>
					<th>CNPJ</th>
				</tr>
			
			</thead>
			<tbody>
			<?php
				$obj = conecta_db();
				$query = "SELECT * FROM tb_transportadora";
				$resultado = $obj->query($query);
				while($linha = $resultado->fetch_object()){
					$html = "<tr>";
					$html .= "<td>";
					$html .="<a href='index.php?page=2
					&id=" .$linha->id_transp."'
					class='btn btn-danger'>Excluir </a>";
					
					
					$html .= "<a href='index.php?page=3
					&id=" . $linha->id_transp ." 
					&nome=" . urlencode($linha->nome_transp) . "' 
					class='btn btn-success'>Alterar</a>";
						   
					$html .= "</td>";
					$html .= "<td>" .$linha->id_transp."</td>";
					$html .= "<td>" .$linha->nome_transp."</td>";
					$html .= "<td>" .$linha->endereco."</td>";
					$html .= "<td>" .$linha->cnpj."</td>";

					
					$html .= "</tr>";
					echo $html;
				}
			
			?>
			</tbody>
			</table>
			
			
		</div>
	</div>

</body>
</html>

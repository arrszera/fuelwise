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
	<h1>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</h1>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<h2> FuelWise </h2>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<a href="index.php?page=1" class="btn btn-primary">Adicionar nova transportadora</a>
			<a href="index.php?page=4" class="btn btn-primary">Adicionar novo posto</a>
			<a href="index.php?page=7" class="btn btn-primary">Adicionar novo caminhão</a>
			<br><br>

			<h3>Transportadoras Cadastradas</h3>
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
					$html .= "<a href='index.php?page=2&id=" . $linha->id_transp . "' class='btn btn-danger'>Excluir</a> ";
					$html .= "<a href='index.php?page=3&id=" . $linha->id_transp . "&nome=" . urlencode($linha->nome_transp) . "' class='btn btn-success'>Alterar</a>";
					$html .= "</td>";
					$html .= "<td>" . $linha->id_transp . "</td>";
					$html .= "<td>" . $linha->nome_transp . "</td>";
					$html .= "<td>" . $linha->endereco . "</td>";
					$html .= "<td>" . $linha->cnpj . "</td>";
					$html .= "</tr>";
					echo $html;
				}
			?>
			</tbody>
			</table>

			<br><br><br>
			<h3>Caminhões Cadastrados</h3>
			<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>ID</th>
					<th>PLACA</th>
					<th>MODELO</th>
					<th>EIXOS</th>
					<th>OBSERVAÇÃO</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$obj = conecta_db();
				$query = "SELECT * FROM tb_caminhao";
				$resultado = $obj->query($query);
				while($linha = $resultado->fetch_object()){
					$html = "<tr>";
					$html .= "<td>";
					$html .= "<a href='index.php?page=8&id=" . $linha->id_caminhao . "' class='btn btn-danger'>Excluir</a> ";
					$html .= "<a href='index.php?page=9&id=" . $linha->id_caminhao . "&nome=" . urlencode($linha->placa) . "' class='btn btn-success'>Alterar</a>";
					$html .= "</td>";
					$html .= "<td>" . $linha->id_caminhao . "</td>";
					$html .= "<td>" . $linha->placa . "</td>";
					$html .= "<td>" . $linha->modelo . "</td>";
					$html .= "<td>" . $linha->eixos . "</td>";
					$html .= "<td>" . $linha->observacao . "</td>";
					$html .= "</tr>";
					echo $html;
				}
			?>
			</tbody>
			</table>

			<br><br><br>
			<?php echo "<!-- CHEGUEI AQUI -->"; ?>
			<h3>Usuários Cadastrados</h3>
			<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>ID</th>
					<th>EMAIL</th>
					<th>NOME</th>
					<th>SENHA</th>
					<th>TELEFONE</th>
					<th>CPF</th>
					<th>GERENTE</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$obj = conecta_db();
				$query = "SELECT * FROM tb_usuario";
				$resultado = $obj->query($query);
				while($linha = $resultado->fetch_object()){
					$html = "<tr>";
					$html .= "<td>";
					$html .= "<a href='index.php?page=14&id=" . $linha->id_usuario . "' class='btn btn-danger'>Excluir</a> ";
					
					$html .= "<a href='index.php?page=13&id=" . $linha->id_usuario .  "&gerente=" . $linha->gerente . "' class='btn btn-success'>Alterar Cargo</a>";
					$html .= "</td>";
					$html .= "<td>" . $linha->id_usuario . "</td>";
					$html .= "<td>" . $linha->email . "</td>";
					$html .= "<td>" . $linha->nome . "</td>";
					$html .= "<td>" . $linha->senha . "</td>";
					$html .= "<td>" . $linha->telefone . "</td>";
					$html .= "<td>" . $linha->cpf . "</td>";
					$html .= "<td>" . $linha->gerente . "</td>";
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

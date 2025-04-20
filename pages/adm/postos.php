<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
    include_once('../../config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Postos</title>
  <?php include('../../elements/head.php'); ?>
  <link rel="stylesheet" href="../../css/solicitacoes.css">
  <link rel='stylesheet' href='../../css/header.css'>
    <link rel='stylesheet' href='../../css/index.css'>
</head>
<body>  
<?php include('../../elements/header.php'); ?>
<h3>Postos</h3>
<div class="table-container">
<form method="POST" action="posto_cadastrar_php.php">
    <input type="text" name="nomePosto" placeholder="Nome do Posto" required>
    <input type="text" name="enderecoPosto" placeholder="Endereço do Posto" required>
    <button type="submit" name="adicionarPosto" class="btn btn-primary">Adicionar Posto</button>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Nome Posto</th>
            <th>Endereco Posto</th>
        </tr>   
    </thead>
    <tbody>
    <?php
        include('../../elements/connection.php');
        $query = "SELECT * FROM posto";
        $resultado = $conn->query($query);
        while($linha = $resultado->fetch_object()){
            $html = "<tr>";

            $html .= "<td data-label='#'>";
            $html .= "<a href='posto_deletar_php.php?id=".$linha->idposto."' class='btn btn-danger'>Excluir</a> ";
            $html .= "<a href='posto_alterar_php.php?id=".$linha->idposto."&nome=".urlencode($linha->nome)."' class='btn btn-success'>Alterar</a>";
            $html .= "</td>";

            $html .= "<td data-label='ID'>" .$linha->idposto."</td>";
            $html .= "<td data-label='Nome Posto'>" .$linha->nome."</td>";
            $html .= "<td data-label='Endereco Posto'>" .$linha->endereco."</td>";

            $html .= "</tr>";
            echo $html; 
        }
    ?>

    </tbody>
</table>
</div>  

<script src="../../js/index.js"></script>
</body>
</html>
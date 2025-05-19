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
<a href="../../pages/adm/postos.php">
    <h3>Postos</h3>
</a>
<div class="table-container">
<form method="POST" action="posto_combustiveis_cadastrar_php.php">
<h2> Atualizando o posto: <?php echo $_GET['nome']; ?> </h2>
    <label for="tipoCombustivel">Tipo de Combustível:</label>
    <select name="tipoCombustivel" required>
        <option value="1">Diesel</option>
        <option value="2">Etanol</option>
        <option value="3">Gasolina</option>
        <option value="4">Gasolina Aditivada</option>
        <option value="5">Diesel S10</option>
    </select>
    <input type="number" step="0.01" min=0.01 name="precoCombustivel" placeholder="Preço do Combustível" required>
    <input type="hidden" name="idposto" value="<?php echo $_GET['id'] ?>">
    <input type="hidden" name="nomeposto" value="<?php echo $_GET['nome'] ?>">

    <button type="submit" name="adicionarCombustivel" class="btn btn-primary">Adicionar Combustível</button>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo de Combustíveis</th>
            <th>Valor do Combustível</th>
        </tr>   
    </thead>
    <tbody>
    <?php
        include('../../elements/connection.php');
        $query = "SELECT * FROM combustivel LEFT JOIN posto ON combustivel.idposto = posto.idposto 
                WHERE combustivel.idposto = " . (int)$_GET['id'] . "  
                ORDER BY idcombustivel DESC"
                ;
        $resultado = $conn->query($query);
        while($linha = $resultado->fetch_object()){
            $html = "<tr>";

            $html .= "<td data-label='#'>";
            $html .= "<a href='posto_combustiveis_deletar_php.php?idcombustivel=".$linha->idcombustivel."&idposto=".$linha->idposto."&nomeposto=".urlencode($linha->nome)."' class='btn btn-danger'>Excluir</a>";
            $html .= "</td>";

            $html .= "<td data-label='Tipo Combustível'>";
            switch ($linha->tipo){
                case 1:
                    $html .= 'Diesel';
                    break;
                case 2:
                    $html .= 'Etanol';
                    break;
                case 3:
                    $html .= 'Gasolina';
                    break;
                case 4:
                    $html .= 'Gasolina Aditivada';
                    break;
                case 5:
                    $html .= 'Diesel S10';
                    break;
            }
            $html .= "</td>";
            $html .= "<td data-label='Valor do Combustível'>" .$linha->preco."</td>";

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
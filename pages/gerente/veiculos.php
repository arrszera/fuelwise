<?php 
    include('autenticacaoGerente.php');
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
<h3 style="overflow-y: hidden">Veículos</h3>
<div class="table-container">
    <div style="display: flex; justify-content: space-between; margin: 0 10px 10px 10px;">
        <form method="POST" action="veiculos_busca.php">
            <input type="text" name="placa" placeholder="Placa do veículo">
            <input type="text" name="modelo" placeholder="Modelo">
            <input type="number" name="eixos" placeholder="Eixos">
            <button type="submit" name="buscarIntegrante" class="btn btn-primary">Buscar</button>
        </form>
        <form method="POST" action="cadastrar_veiculo_php.php?idtransportadora=<?php echo $_SESSION['idtransportadora'] ?>">
            <input type="text" name="placa" placeholder="Placa" required>
            <input type="text" name="modelo" placeholder="Modelo" required>
            <br>
            <input type="text" name="eixos" placeholder="Eixos" required>
            <input type="text" name="observacao" placeholder="Observacao" required>
            <br>
            <center><button type="submit" name="adicionarPosto" class="btn btn-primary">Adicionar Veiculo</button></center>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Eixos</th>
                <th>Observação</th>
            </tr>   
        </thead>
        <tbody>
        <?php
            include('../../elements/connection.php');
            $query = "SELECT * FROM veiculo 
            JOIN transportadora ON veiculo.idtransportadora  = transportadora.idtransportadora";

            $resultado = $conn->query($query);
            while($linha = $resultado->fetch_object()){
                $html = "<tr>";

                $html .= "<td data-label='#'>";
                $html .= "<a href='deletar_veiculo_php.php?idveiculo=".$linha->idveiculo."&idtransportadora=".$_SESSION['idtransportadora']."' class='btn btn-danger'>Remover</a> ";
                $html .= "<a href='alterar_veiculo.php?idtransportadora=".$_GET['idtransportadora']."&veiculo=".$linha->idveiculo."&placa=".urlencode($linha->placa)."&modelo=".$linha->modelo."&eixos=".$linha->eixos."&observacao=".$linha->observacao."' class='btn btn-success'>Alterar</a>";
                $html .= "</td>";

                $html .= "<td data-label='ID'>" .$linha->idveiculo."</td>";
                $html .= "<td data-label='Placa'>" .$linha->placa."</td>";
                $html .= "<td data-label='Modelo'>" .$linha->modelo."</td>";
                $html .= "<td data-label='Eixos'>" .$linha->eixos."</td>";
                $html .= "<td data-label='Observação'>" .$linha->observacao."</td>";

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
<?php
session_start(); 
include_once('../../config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Postos</title>
  <?php include('../../elements/head.php'); ?>
  <link rel="stylesheet" href="../../css/solicitacoes.css">
  <link rel="stylesheet" href="../../css/header.css">
  <link rel="stylesheet" href="../../css/index.css">
</head>
<body>  
<?php include('../../elements/header.php'); ?>
<h3>Postos</h3>
<div class="table-container">
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Posto</th>
            <th>Endereco Posto</th>
            <th>Combustíveis</th>
        </tr>   
    </thead>
    <tbody>
    <?php
        include('../../elements/connection.php');
        $query = "SELECT * FROM posto ORDER BY idposto DESC";
        $resultado = $conn->query($query);

        while ($linha = $resultado->fetch_object()) {
            $html = "<tr>";
        
            $html .= "<td data-label='ID'>" .$linha->idposto."</td>";
            $html .= "<td data-label='Nome Posto'>" .$linha->nome."</td>";
            $html .= "<td data-label='Endereco Posto'>" .$linha->endereco."</td>";
            
            $query2 = "SELECT * FROM combustivel WHERE idposto = " . (int)$linha->idposto . " ORDER BY idcombustivel DESC";
            $resultado2 = $conn->query($query2);

            $html .= "<td data-label='Combustíveis'>";
            if ($resultado2->num_rows > 0) {
                $html .= "<table class='table table-sm'>";

                $html .= "<thead><tr><th>Tipo do Combustível</th><th>Preço</th></tr></thead><tbody>";

                while ($linha2 = $resultado2->fetch_object()) {
                    $html .= "<tr><td>";

                    switch ($linha2->tipo) {
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
                        default:
                            $html .= 'Tipo Desconhecido';
                            break;
                    }

                    $html .= "</td><td>" . $linha2->preco . "</td></tr>";
                }
                $html .= "</table>";
            } else {
                $html .= "Nenhum combustível cadastrado";
            }
            $html .= "</td>";

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

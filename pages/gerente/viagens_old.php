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
<h3 style="overflow-y: hidden">Viagens Atuais</h3>
<div class="table-container">
    <div style="display: flex; justify-content: space-between; margin: 0 10px 10px 10px;">

        <div>
            <button type="button" name="cadastrarViagem" class="btn btn-primary" onclick="window.location.href='cadastrar_viagem.php?idtransportadora=<?php echo $_SESSION['idtransportadora'] ?>';">Cadastrar Viagem</button>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Motorista</th>
                <th>Caminhão</th>
                <th>Carga</th>
                <th>Peso</th>
                <th>Observação</th>
                <th>Data Ínicio</th>
                <th>Data Término</th>
            </tr>   
        </thead>
        <tbody>
        <?php
            include('../../elements/connection.php');
            $query = "SELECT * FROM viagem 
            JOIN usuario ON viagem.idusuario = usuario.idusuario
            JOIN veiculo ON viagem.idveiculo = veiculo.idveiculo
            JOIN transportadora_usuario ON usuario.idusuario = transportadora_usuario.idusuario
            WHERE transportadora_usuario.idtransportadora = " . (int)$_GET['idtransportadora'] . "  ";  
  

            $resultado = $conn->query($query);
            while($linha = $resultado->fetch_object()){
                $html = "<tr>"; 

                $html .= "<td data-label='#'>";
                $html .= "<a href='deletar_veiculo_php.php?idveiculo=".$linha->idveiculo."&idtransportadora=".$_SESSION['idtransportadora']."' class='btn btn-danger'>Remover</a> ";
                $html .= "<a href='alterar_veiculo.php?idveiculo=".$linha->idveiculo."&idtransportadora=".$_GET['idtransportadora']."&veiculo=".$linha->idveiculo."&placa=".urlencode($linha->placa)."&modelo=".$linha->modelo."&eixos=".$linha->eixos."&observacao=".$linha->observacao."' class='btn btn-success'>Alterar</a>";
                $html .= "</td>";

                $html .= "<td data-label='ID'>" .$linha->idviagem."</td>";
                $html .= "<td data-label='Placa'>" .$linha->nome."</td>";
                $html .= "<td data-label='Modelo'>" .$linha->placa."</td>";
                $html .= "<td data-label='Capacidade de tanque'>" .$linha->carga."</td>";
                $html .= "<td data-label='Capacidade de tanque'>" .$linha->peso."</td>";
                $html .= "<td data-label='Observação'>" .$linha->obs."</td>";
                $html .= "<td data-label='Eixos'>" .$linha->data_inicio."</td>";
                $html .= "<td data-label='Eixos'>" .$linha->data_termino."</td>";

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
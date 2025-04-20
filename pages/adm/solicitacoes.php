<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Solicitações</title>
  <?php include('../../elements/head.php'); ?>
  <link rel="stylesheet" href="../../css/solicitacoes.css">
  <link rel='stylesheet' href='../../css/header.css'>
    <link rel='stylesheet' href='../../css/index.css'>
</head>
<body>  
<?php include('../../elements/header.php'); ?>
<h3>Solicitações</h3>
<div class="table-container">
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Nome Transportadora</th>
            <th>ENDERECO Transportadora</th>
            <th>Telefone</th>
            <th>Nome Usuário</th>
            <th>Email Usuário</th>
            <th>CPF</th>
            <th>CNPJ</th>
        </tr>   
    </thead>
    <tbody>
    <?php
        include('../../elements/connection.php');
        $query = "SELECT * FROM solicitacao";
        $resultado = $conn->query($query);
        while($linha = $resultado->fetch_object()){
            $html = "<tr>";

            $html .= "<td data-label='#'>";
            $html .= "<a href='solicitacoes_deletar.php?id=".$linha->idsolicitacao."' class='btn btn-danger'>Excluir</a>";
            $html .= "<a href='solicitacoes_aprovar.php?id=".$linha->idsolicitacao."&nome=".urlencode($linha->nomeTransportadora)."' class='btn btn-success'>Aprovar</a>";
            $html .= "</td>";

            $html .= "<td data-label='ID'>" .$linha->idsolicitacao."</td>";
            $html .= "<td data-label='Nome Transportadora'>" .$linha->nomeTransportadora."</td>";
            $html .= "<td data-label='ENDERECO Transportadora'>" .$linha->endereco."</td>";
            $html .= "<td data-label='Telefone'>" .$linha->telefone."</td>";
            $html .= "<td data-label='Nome Usuário'>" .$linha->nomeUsuario."</td>";
            $html .= "<td data-label='Email Usuário'>" .$linha->emailUsuario."</td>";
            $html .= "<td data-label='CPF'>" .$linha->cpf."</td>";
            $html .= "<td data-label='CNPJ'>" .$linha->cnpj."</td>";

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
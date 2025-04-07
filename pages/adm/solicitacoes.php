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
</head>
<body>  
<?php include('../../elements/header.php'); ?>
<h3>Solicitações</h3>
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
            $html .= "<td>";
            $html .="<a href='solicitacoes_deletar.php
            &id=" .$linha->idsolicitacao."'
            class='btn btn-danger'>Excluir </a>";
            
            
            $html .= "<a href='solicitacoes_aprovar.php
            &id=" . $linha->idsolicitacao ." 
            &nome=" . urlencode($linha->nomeTransportadora) . "' 
            class='btn btn-success'>Aprovar</a>";
                    
            $html .= "</td>";
            $html .= "<td>" .$linha->idsolicitacao."</td>";
            $html .= "<td>" .$linha->nomeTransportadora."</td>";
            $html .= "<td>" .$linha->endereco."</td>";
            $html .= "<td>" .$linha->telefone."</td>";
            $html .= "<td>" .$linha->nomeUsuario."</td>";
            $html .= "<td>" .$linha->emailUsuario."</td>";
            $html .= "<td>" .$linha->cpf."</td>";
            $html .= "<td>" .$linha->cnpj."</td>";
            
            $html .= "</tr>";
            echo $html;
        }
    
    ?>
    </tbody>
</table>

</body>
</html>
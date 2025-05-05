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
<h3 style="overflow-y: hidden">Integrantes</h3>
<div class="table-container">
    <div style="display: flex; justify-content: space-between; margin: 0 10px 10px 10px;">
        <form method="POST" action="integrantes_busca.php">
            <div>
                <input type="text" name="nome" placeholder="Nome do Funcionário">
                <input type="text" name="cpf" placeholder="CPF">
                <select name="perfil">
                    <option value="" selected disabled></option>
                    <option value="motorista">Motorista</option>
                    <option value="gerente">Gerente</option>
                </select>
                <button type="submit" name="buscarIntegrante" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <div>
            <button type="button" name="adicionarIntegrante" class="btn btn-primary" onclick="window.location.href='cadastrar_integrante.php?idtransportadora=<?php echo $_SESSION['idtransportadora'] ?>';">Adicionar +</button>
        </div>
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
            $query = "SELECT usuario.idusuario AS idusuario, email, usuario.nome AS nome_usuario, telefone, cpf, gerente 
            FROM transportadora_usuario AS tu
            JOIN usuario ON tu.idusuario = usuario.idusuario 
            JOIN transportadora ON tu.idtransportadora = transportadora.idtransportadora
            WHERE transportadora.idtransportadora = " . (int)$_GET['idtransportadora'] . "  ";  
;

            $resultado = $conn->query($query);
            while($linha = $resultado->fetch_object()){
                $html = "<tr>";

                $html .= "<td data-label='#'>";
                if (!($linha->idusuario == $_SESSION['id'])){
                    $html .= "<a href='deletar_integrante_php.php?idusuario=".$linha->idusuario."&idtransportadora=".$_SESSION['idtransportadora']."' class='btn btn-danger'>Remover</a> ";
                }
                $html .= "<a href='alterar_integrante.php?idtransportadora=".$_GET['idtransportadora']."&idusuario=".$linha->idusuario."&nome=".urlencode($linha->nome_usuario)."&cpf=".$linha->cpf."&telefone=".$linha->telefone."&email=".$linha->email."' class='btn btn-success'>Alterar</a>";
                $html .= "</td>";

                $html .= "<td data-label='ID'>" .$linha->idusuario."</td>";
                $html .= "<td data-label='Nome'>" .$linha->nome_usuario."</td>";
                $html .= "<td data-label='CPF'>" .$linha->cpf."</td>";
                $html .= "<td data-label='Email'>" .$linha->email."</td>";
                $html .= "<td data-label='Senha'>
                            <button type='button' class='btn btn-primary' onclick=\"window.location.href='redefinir_senha.php?id=" . $linha->idusuario . "'\">Redefinir Senha</button>
                        </td>";
                $html .= "<td data-label='Telefone'>" .$linha->telefone."</td>";
                $html .= "<td data-label='Perfil'";

                if ($linha->gerente == 1) {
                    $html .= " style='padding: 10px; background-color: #f0f0f0;'"; // exemplo de padding e background para o gerente
                    $html .= ">Gerente</td>";
                } else {
                    $html .= ">Motorista</td>";
                }

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
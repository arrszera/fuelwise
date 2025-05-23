<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php 
        include('autenticacaoGerente.php');
        include('../../elements/head.php');
    ?>
    <link rel='stylesheet' href='../../css/login.css'>
    <link rel='stylesheet' href='../../css/header.css'>
    <title>Cadastro Viagem</title>
</head>
<body>
    <?php include('../../elements/header.php') ?>

    <div class="form-div" id="form-div">
        <form method="POST" action="cadastrar_viagem_php.php?idtransportadora=<?php echo $_SESSION['idtransportadora'] ?>" class="form">
            <h3>Cadastro de Viagens</h3>
            <small></small><br>

            <div class="form-group">
                <label for="nome">Motorista*</label>
                <?php 
                    $sql3 = "SELECT idusuario, nome FROM usuario";
                    $motoristas = $conn->query($sql3);
                    if ($motoristas->num_rows > 0) {
                        echo '<select name="idusuario" id="idusuario">';
                        while ($row = $motoristas->fetch_assoc()) {
                            echo '<option value="' . $row['idusuario'] . '">' . $row['nome'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "Nenhum motorista encontrado";
                    }
                ?>
            </div>

            <div class="form-group">
                <label for="veiculo">Veículo*</label>
                <?php 
                    $sql4 = "SELECT idveiculo, placa, modelo FROM veiculo";
                    $veiculos = $conn->query($sql4);
                    if ($veiculos->num_rows > 0) {
                        echo '<select name="idveiculo" id="idveiculo">';
                        while ($row = $veiculos->fetch_assoc()) {
                            echo '<option value="' . $row['idveiculo'] . '">' . $row['placa'] . ' - ' . $row['modelo'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "Nenhum veículo encontrado";
                    }
                ?>
            </div>

            <div class="form-group">
                <label for="data_inicio">Data Início*</label>
                <input id="data_inicio" name="data_inicio" type="datetime-local" class="form-control">
            </div>

            <div class="form-group">
                <label for="carga">Carga*</label>
                <input id="carga" name="carga" type="text" class="form-control" placeholder="Insira a carga da viagem">
            </div>

            <div class="form-group">
                <label for="peso">Peso*</label>
                <input id="peso" name="peso" type="number" step="0.01" class="form-control" placeholder="Insira o peso da viagem">
            </div>

            <div class="form-group">
                <label for="obs">Observação*</label>
                <input id="obs" name="obs" type="text" class="form-control" placeholder="Insira uma observação da viagem">
            </div>

            <button type="submit" class="btn btn-primary">Cadastro</button>
        </form>
    </div>

    <script>
        function getDateInSaoPaulo() {
            const date = new Date();
            const saoPauloOffset = -6 * 60;  
            const currentOffset = date.getTimezoneOffset();  

            const adjustedDate = new Date(date.getTime() + (currentOffset + saoPauloOffset) * 60000);

            const formattedDate = adjustedDate.toISOString().slice(0, 16);

            document.getElementById('data_inicio').value = formattedDate;
        }

        window.onload = getDateInSaoPaulo;
    </script>

    <script src="../../js/index.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>

<?php
include_once('conecta_db.php'); 
$obj = conecta_db();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM tb_caminhao WHERE id_caminhao = '$id'";
        $result = $obj->query($query);

        if ($result && $result->num_rows > 0) {
            $dados = $result->fetch_assoc();
        } else {
            echo "<span class='alert alert-danger'>transportadora não encontrado!</span>";
            exit;
        }
    }

	if(isset($_GET['id'])){
		$obj = conecta_db();
        $query = "INSERT INTO tb_transportadora(nome_transp, endereco, cnpj) 
			      VALUES ('"$dados['nome_transportadora']"','"$dados['endereco']"','"$dados['cnpj']"')";

        
		$resultado = $obj->query($query);
		header("location:index.php");
	}else{
		echo "Algo deu errado.";
	}
#	codigo para excluir uma transportadora
?>	
<?php echo $dados['placa']; ?>

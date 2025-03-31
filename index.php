<?php
	include_once 'biblioteca.php';
	include_once 'header.php';
	include_once 'conecta_db.php';
	
	if(isset($_GET['page'])){
		if($_GET['page'] ==1){
			include 'conteudo1.php';
			
		}else if($_GET['page'] ==2) {
			include 'conteudo2.php';
		}else if($_GET['page'] ==3) {
			include 'conteudo3.php';
		}else{
			header('location: index.php');
		}
	}else{
		include 'main.php';
	}	

?>
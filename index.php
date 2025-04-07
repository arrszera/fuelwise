<?php
	include_once 'biblioteca.php';
	include_once 'header.php';
	include_once 'conecta_db.php';
	
	if(isset($_GET['page'])){
		if($_GET['page'] ==1){
			include 'addtransp.php';
		}else if($_GET['page'] ==2) {
			include 'rmvtransp.php';
		}else if($_GET['page'] ==3) {
			include 'alttransp.php';
		}else if($_GET['page'] ==4) {
			include 'addposto.php';
		}else if($_GET['page'] ==5) {
			include 'rmvposto.php';
		}else if($_GET['page'] ==6) {
			include 'altposto.php';
		}
		else if($_GET['page'] ==7) {
			include 'addcaminhao.php';
		}
		else if($_GET['page'] ==8) {
			include 'rmvcaminhao.php';
		}
		else if($_GET['page'] ==9) {
			include 'altcaminhao.php';
		}else{
			header('location: index.php');
		}
	}else{
		include 'main.php';
	}	

?>
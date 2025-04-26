<?php 
    include_once('../config.php');
    session_start();
    if(session_status() != PHP_SESSION_NONE){
        session_unset();
        session_destroy();
        header('Location: index.php');
    }
?>
<?php 
    session_start();
    $_SESSION['role'] = 2;
    header('Location: ../index.php');
?>
<?php 
    session_start();
    $_SESSION['role'] = 3;
    header('Location: ../index.php');
?>
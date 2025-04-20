<?php
    session_start(); 
    if (!($_SESSION['role'] == 3)){
        header('Location: ../index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../../head.php')?>
    <link rel='stylesheet' href='../../css/header.css'>
    <link rel='stylesheet' href='../../css/index.css'>
    <title>Document</title>
</head>
<body>
    
</body>
</html>
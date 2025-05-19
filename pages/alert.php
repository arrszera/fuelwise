<?php 
    session_start();
    $_SESSION['alert'] = [
            'title' => 'Sucesso!',
            'text' => 'Cadastro enviado com sucesso!',
            'icon' => 'success'
        ];
    echo var_dump($_SESSION);
?>
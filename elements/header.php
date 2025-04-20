<?php 
    if ( session_status() !== PHP_SESSION_ACTIVE ){
       session_start();
    }
?>
<header class="header">
    <div>
        <!-- <a href="index.html"><div class="logo" id="div-logo"><img src="../assets/logo.png" ></div></a> -->
        <a href="/FuelWise/pages/index.php"><div>LOGO</div></a>
    </div>
    <div id="menu">
        <ul>
            <li><a href="/FuelWise/pages/index.php">Início</a></li>
        </ul>
    </div>

    <!-- Responsividade -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="menu-icon" id="menu-icon" onclick="onMenuToggle()">
            <div class="block"></div>
            <div class="block"></div>
            <div class="block"></div>
        </div> 
    </div>
    <!--  -->
</header>
<ul class="mobile-menu-list" id="mobile-menu-list">
    <?php if (!isset($_SESSION['role'])) { ?> <!-- DESLOGADO -->
        <li class="mobile-menu-item"><a href="/FuelWise/pages/login.php">Fazer login</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/cadastro_transportadora.php?page=1" onclick="scrollIntoView()">Cadastrar como Transportadora</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/cadastro_funcionario.php" onclick="scrollIntoView()">Cadastrar como Funcionário</a></li>
        <li class="mobile-menu-item"><a href="#" onclick="scrollIntoView()">Suporte &nbsp;<box-icon color="#ECEBE9" name="support"></box-icon></a></li>
    <?php } else { 
        switch ($_SESSION['role']) {
                case 0: ?> <!-- Funcionario -->

    <?php break; case 1: ?> <!-- Gerente -->

    <?php break; case 2: ?> <!-- Postos -->
        
    <?php break; case 3: ?> <!-- ADM/SUPORTE -->
        <li class="mobile-menu-item"><a href="/FuelWise/pages/adm/solicitacoes.php">Aprovar Cadastros</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/adm/cadastrar_posto.php">Cadastrar postos</a></li>
        <li class="mobile-menu-item"><a href="#">Verificar Denuncias</a></li>
        <li class="mobile-menu-item"><a href="#">Visualiazar Solicitações</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/logout.php">Logout</a></li>
    <?php break; }} ?>
</ul>
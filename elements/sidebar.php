<div class="logoSidebar">
    <div>
        <svg
            width="35" height="35" 
            class="w-8 h-8" 
            viewBox="0 0 24 24" 
            fill="currentColor" 
            xmlns="http://www.w3.org/2000/svg"
            >
            <path 
                d="M19.77 7.23L19.78 7.22L16.06 3.5L15 4.56L17.11 6.67C16.17 7.03 15.5 7.93 15.5 9C15.5 10.38 16.62 11.5 18 11.5C18.36 11.5 18.69 11.42 19 11.29V18.5C19 19.05 18.55 19.5 18 19.5C17.45 19.5 17 19.05 17 18.5V14C17 12.9 16.1 12 15 12H14V5C14 3.9 13.1 3 12 3H6C4.9 3 4 3.9 4 5V21H14V13.5H15.5V18.5C15.5 19.88 16.62 21 18 21C19.38 21 20.5 19.88 20.5 18.5V9C20.5 8.31 20.22 7.68 19.77 7.23ZM12 13.5V19H6V12H12V13.5ZM12 10H6V5H12V10ZM18 10C17.45 10 17 9.55 17 9C17 8.45 17.45 8 18 8C18.55 8 19 8.45 19 9C19 9.55 18.55 10 18 10Z" 
            />
        </svg>
    </div>
    <div style="font-weight: 400; font-size: 1.1rem">FuelWise</div>
</div>

<?php

// Verificando o tipo de usuário e gerando o menu de acordo
if (isset($_SESSION['gerente']) && isset($_SESSION['adm']) && $_SESSION['gerente'] == '0' && $_SESSION['adm'] == '0') {
    // Menu para Motorista
    echo '
    <ul>
        <li class="mobile-menu-item"><a href="index.php">Início</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/motorista/postos.php">Checar Postos</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/suporte.php" onclick="scrollIntoView()">Suporte &nbsp;<box-icon color="#ECEBE9" name="support"></box-icon></a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/logout.php">Logout</a></li>
    </ul>';
} elseif (isset($_SESSION['gerente']) && $_SESSION['gerente'] == '1') {
    // Menu para Gerente
    echo '
    <ul>
        <li class="mobile-menu-item"><a href="index.php">Início</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/gerente/integrantes.php?idtransportadora=' . $_SESSION['idtransportadora'] . '">Gerenciar integrantes</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/gerente/veiculos.php?idtransportadora=' . $_SESSION['idtransportadora'] . '">Gerenciar caminhões</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/gerente/viagens.php?idtransportadora=' . $_SESSION['idtransportadora'] . '">Viagens</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/suporte.php">Suporte &nbsp;<box-icon color="black" name="support"></box-icon></a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/logout.php">Logout</a></li>
    </ul>';
} elseif ($_SESSION['adm'] == '1' || $_SESSION['role'] == 3) {
    // Menu para Administrador/Suporte
    echo '
    <ul>
        <li class="mobile-menu-item"><a href="index.php">Início</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/adm/solicitacoes.php">Aprovar cadastros</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/adm/postos.php">Gerenciar postos</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/adm/denuncias.php">Verificar chamados</a></li>
        <li class="mobile-menu-item"><a href="/FuelWise/pages/logout.php">Logout</a></li>
    </ul>';
}
?>

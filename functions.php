<?php

require_once 'class.php';
require_once 'menu.php';
require_once 'battle.php';

function startGame() {
    $players = menu();
    battle($players);
}

// Só executa se o arquivo for chamado diretamente
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    startGame();
}
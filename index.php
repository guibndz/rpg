<?php

echo "====== | Bem vindo ao RPG Bndz | ====== \n\n";

echo "Digite o número correspondente à opção desejada:\n";
echo "1 - Acessar Menu\n";
echo "0 - Sair\n";

$option = readline("Opção: ");

switch ($option) {
    case '1':
        require_once 'functions.php';
        system('clear');
        startGame();
        break;
    case '0':
        echo "Saindo...\n";
        exit;
    default:
        echo "Opção inválida. Saindo...\n";
        exit;
}




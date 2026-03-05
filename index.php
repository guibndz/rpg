<?php

echo "====== | Bem vindo ao RPG Bndz | ====== \n";

echo "Digite o número correspondente à opção desejada:\n
1 - Acessar Menu\n
0 - Sair\n";

$option = readline("Opção: ");

switch ($option) {
    case 1:
        require('functions.php');
        system('clear');
        break;
    case 0:
        echo "Saindo...\n";
        exit;
    default:
        echo "Opção inválida. Saindo...\n";
        exit;
}




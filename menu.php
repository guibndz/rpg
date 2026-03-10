<?php

function menu (){
    echo "====== | RPG Bndz | ======\n\n";

    require_once 'functions.php';

    $players = [];

    for ($i = 1; $i <= 2; $i++) {
        echo "\n--- Player $i ---\n";
        $ready = false;

        while (!$ready) {
            system('clear');
            echo "\nEscolha o que deseja fazer:\n";
            echo "0. Sair\n";
            echo "1. Criar personagem\n";
            echo "2. Ver Classes\n";

            switch (readline("Digite o número da sua escolha: ")) {
                case '1':
                    system('clear');
                    $players[$i] = Character::createCharacter("Player $i");
                    echo "\n✓ Player $i está pronto com {$players[$i]->class}!\n";
                    readline("Pressione ENTER para continuar...");
                    $ready = true;
                    break;
                case '2':
                    system('clear');
                    echo "\n====== Classes disponíveis ======\n\n";
                    echo "WARRIOR (Guerreiro)\n";
                    echo "  - HP: 175 | MP: 100\n";
                    echo "  - Dano: 20 | Defesa: 15\n";
                    echo "  - Especial: Golpe Poderoso (36 dano, 30 MP + Sangramento 8 por 3 turnos)\n";
                    echo "  - Estilo: Tanque equilibrado com boa defesa\n\n";
                    
                    echo "MAGE (Mago)\n";
                    echo "  - HP: 100 | MP: 150\n";
                    echo "  - Dano: 35 | Defesa: 5\n";
                    echo "  - Especial: Bola de Fogo (70 dano, 40 MP + Queimadura 10 por 3 turnos)\n";
                    echo "  - Estilo: Alto dano mas frágil\n\n";

                    echo "PALLY (Paladino)\n";
                    echo "  - HP: 150 | MP: 120\n";
                    echo "  - Dano: 25 | Defesa: 10\n";
                    echo "  - Especial: Golpe Sagrado (38 dano, 35 MP + Ferida Sagrada 6 por 2 turnos)\n";
                    echo "  - Estilo: Versátil com bom equilíbrio entre ataque e defesa\n\n";
                    readline("Pressione ENTER para voltar ao menu...");
                    break;
                case '0':
                    system('clear');
                    echo "Saindo...\n";
                    exit;
                default:
                    system('clear');
                    echo "Escolha inválida. Tente novamente.\n";
            }
        }
    }

    return $players;
}
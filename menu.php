<?php

function menu (){
    echo "====== | RPG Bndz | ======\n\n";

    require_once 'functions.php';

    $players = [];

    for ($i = 1; $i <= 2; $i++) {
        echo "\n--- Player $i ---\n";
        $ready = false;

        while (!$ready) {
            echo "\nEscolha o que deseja fazer:\n";
            echo "0. Sair\n";
            echo "1. Criar personagem\n";
            echo "2. Ver Classes\n";

            switch (readline("Digite o número da sua escolha: ")) {
                case '1':
                    $players[$i] = Character::createCharacter("Player $i");
                    echo "\n✓ Player $i está pronto com {$players[$i]->class}!\n";
                    readline("Pressione ENTER para continuar...");
                    $ready = true;
                    break;
                case '2':
                    echo "\n====== Classes disponíveis ======\n\n";
                    echo "WARRIOR (Guerreiro)\n";
                    echo "  - HP: 175 | MP: 100\n";
                    echo "  - Dano: 20 | Defesa: 15\n";
                    echo "  - Especial: Golpe Poderoso (36 dano, 30 MP)\n";
                    echo "  - Estilo: Tanque equilibrado com boa defesa\n\n";
                    
                    echo "MAGE (Mago)\n";
                    echo "  - HP: 100 | MP: 150\n";
                    echo "  - Dano: 35 | Defesa: 5\n";
                    echo "  - Especial: Bola de Fogo (70 dano, 40 MP)\n";
                    echo "  - Estilo: Alto dano mas frágil\n\n";
                    break;
                case '0':
                    echo "Saindo...\n";
                    exit;
                default:
                    echo "Escolha inválida. Tente novamente.\n";
            }
        }
    }

    return $players;
}
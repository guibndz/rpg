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
                    echo "Player $i escolheu: {$players[$i]->class}\n";
                    $ready = true;
                    break;
                case '2':
                    echo "Classes disponíveis:\n";
                    echo "- Warrior: Alta vida e defesa, dano moderado.\n";
                    echo "- Mage: Alta mana e dano, baixa vida e defesa.\n";
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
<?php

function displayPlayerStatus($player, $playerNum) {
    $class = $player->class;
    $hp = max(0, $player->life);
    $mana = $player->mana;
    echo "Player $playerNum ($class): $hp HP | $mana MP\n";
}

function getPlayerAction($playerNum, $player) {
    echo "\nPlayer $playerNum, escolha sua ação:\n";
    echo "1. Atacar (Dano: {$player->damage})\n";
    echo "2. Defender (Reduz próximo dano)\n";
    echo "3. Ataque Especial (Custo: {$player->specialCost} MP)";
    
    if (!$player->canUseSpecial()) {
        echo " [MANA INSUFICIENTE]";
    }
    echo "\n";
    
    $action = readline("Opção: ");
    return trim($action);
}

function battle($players) {
    system('clear');
    $turn = 1;
    echo "\n====== | Batalha Iniciada | ======\n";
    echo "Player 1 ({$players[1]->class}) vs Player 2 ({$players[2]->class})\n";
    echo "HP: {$players[1]->life} vs {$players[2]->life}\n";
    echo "MP: {$players[1]->mana} vs {$players[2]->mana}\n\n";

    while ($players[1]->life > 0 && $players[2]->life > 0) {
        echo "--- Turno $turn ---\n";
        displayPlayerStatus($players[1], 1);
        displayPlayerStatus($players[2], 2);
        echo "\n";

        // ====== Player 1 ======
        $action1 = getPlayerAction(1, $players[1]);
        switch ($action1) {
            case '1':
                system('clear');
                $damageDealt = $players[1]->attack();
                $damageTaken = $players[2]->takeDamage($damageDealt);
                echo "Player 1 atacou! Dano causado: $damageTaken\n\n";
                break;
            case '2':
                system('clear');
                $players[1]->defend();
                echo "Player 1 está defendendo! Vai reduzir o próximo dano recebido.\n\n";
                break;
            case '3':
                $specialDamage = $players[1]->useSpecial();
                if ($specialDamage === false) {
                    echo "Mana insuficiente! Player 1 perdeu o turno.\n\n";
                } else {
                    system('clear');
                    $damageTaken = $players[2]->takeDamage($specialDamage);
                    echo "Player 1 usou ataque especial! Dano causado: $damageTaken (MP restante: {$players[1]->mana})\n\n";
                }
                break;
            default:
                echo "Ação inválida! Player 1 perdeu o turno.\n\n";
        }


        if ($players[2]->life <= 0) break;

        // ====== Player 2 ======
        $action2 = getPlayerAction(2, $players[2]);
        switch ($action2) {
            case '1':
                system('clear');
                $damageDealt = $players[2]->attack();
                $damageTaken = $players[1]->takeDamage($damageDealt);
                echo "Player 2 atacou! Dano causado: $damageTaken\n\n";
                break;
            case '2':
                system('clear');
                $players[2]->defend();
                echo "Player 2 está defendendo! Vai reduzir o próximo dano recebido.\n\n";
                break;
            case '3':
                $specialDamage = $players[2]->useSpecial();
                if ($specialDamage === false) {
                    system('clear');
                    echo "Mana insuficiente! Player 2 perdeu o turno.\n\n";
                } else {
                    system('clear');
                    $damageTaken = $players[1]->takeDamage($specialDamage);
                    echo "Player 2 usou ataque especial! Dano causado: $damageTaken (MP restante: {$players[2]->mana})\n\n";
                }
                break;
            default:
                echo "Ação inválida! Player 2 perdeu o turno.\n\n";
        }

        $turn++;
    }

    echo "\n====== | Resultado | ======\n";
    if ($players[1]->life <= 0 && $players[2]->life <= 0) {
        echo "Empate! Ambos os jogadores caíram.\n";
    } elseif ($players[1]->life <= 0) {
        echo "*** Player 2 ({$players[2]->class}) venceu em $turn turnos com {$players[2]->life} HP e {$players[2]->mana} MP restantes! ***\n";
    } else {
        echo "*** Player 1 ({$players[1]->class}) venceu em $turn turnos com {$players[1]->life} HP e {$players[1]->mana} MP restantes! ***\n";
    }
}
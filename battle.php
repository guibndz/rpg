<?php

function battle($players) {
    $turn = 1;

    echo "\n====== | Batalha Iniciada | ======\n";
    echo "Player 1 ({$players[1]->class}) vs Player 2 ({$players[2]->class})\n";
    echo "HP: {$players[1]->life} vs {$players[2]->life}\n\n";

    while ($players[1]->life > 0 && $players[2]->life > 0) {
        echo "--- Turno $turn ---\n";
        echo "Player 1 ({$players[1]->class}): {$players[1]->life} HP | Player 2 ({$players[2]->class}): {$players[2]->life} HP\n\n";

        echo "Player 1, escolha sua ação:\n";
        echo "1. Atacar\n";
        echo "2. Defender\n";
        echo "3. Ataque Especial\n";

        $action1 = readline("Opção: ");
        switch ($action1) {
            case '1':
                $damageDealt = $players[1]->attack();
                $damageTaken = $players[2]->takeDamage($damageDealt);
                echo "Player 1 atacou! Dano causado: $damageTaken\n\n";
                break;
            case '2':
                $players[1]->defend();
                echo "Player 1 está defendendo! Vai reduzir o próximo dano recebido.\n\n";
                break;
            case '3':
                $specialDamage = $players[1]->specialAttack();
                $damageTaken = $players[2]->takeDamage($specialDamage);
                echo "Player 1 usou ataque especial! Dano causado: $damageTaken\n\n";
                break;
            default:
                echo "Ação inválida! Player 1 perdeu o turno.\n\n";
        }

        // Verifica se Player 2 já morreu antes de dar o turno dele
        if ($players[2]->life <= 0) break;

        // === Player 2 ===
        echo "Player 2, escolha sua ação:\n";
        echo "1. Atacar\n";
        echo "2. Defender\n";
        echo "3. Ataque Especial\n";

        $action2 = readline("Opção: ");
        switch ($action2) {
            case '1':
                $damageDealt = $players[2]->attack();
                $damageTaken = $players[1]->takeDamage($damageDealt);
                echo "Player 2 atacou! Dano causado: $damageTaken\n\n";
                break;
            case '2':
                $players[2]->defend();
                echo "Player 2 está defendendo! Vai reduzir o próximo dano recebido.\n\n";
                break;
            case '3':
                $specialDamage = $players[2]->specialAttack();
                $damageTaken = $players[1]->takeDamage($specialDamage);
                echo "Player 2 usou ataque especial! Dano causado: $damageTaken\n\n";
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
        echo "🏆 Player 2 ({$players[2]->class}) venceu após $turn turnos com {$players[2]->life} HP restantes!\n";
    } else {
        echo "🏆 Player 1 ({$players[1]->class}) venceu após $turn turnos com {$players[1]->life} HP restantes!\n";
    }
}
<?php

abstract class Character {
    
    public $class;
    public $life;
    public $damage;
    public $defense;
    public $mana;
    public $effects = [];

    public function __construct($class) {
        $this->class = $class;
        $this->setAttributes();
    }

    public $specialCost;

    abstract protected function setAttributes();
    abstract public function specialAttack();

    public function attack() {
        return $this->damage;
    }

    public function canUseSpecial() {
        return $this->mana >= $this->specialCost;
    }

    public function useSpecial() {
        if (!$this->canUseSpecial()) {
            return false;
        }
        $this->mana -= $this->specialCost;
        return $this->specialAttack();
    }

    public function addEffect($name, $damagePerTurn, $duration) {
        foreach ($this->effects as &$effect) {
            if ($effect['name'] === $name) {
                $effect['damage'] = $damagePerTurn;
                $effect['turns'] = $duration;
                return;
            }
        }

        $this->effects[] = [
            'name' => $name,
            'damage' => $damagePerTurn,
            'turns' => $duration
        ];
    }

    public function applyTurnEffects() {
        $messages = [];

        foreach ($this->effects as $index => &$effect) {
            $damage = max(1, $effect['damage']);
            $this->life -= $damage;
            $effect['turns'] -= 1;

            $messages[] = "{$this->class} sofreu {$damage} de dano por {$effect['name']}!";

            if ($effect['turns'] <= 0) {
                $messages[] = "{$effect['name']} terminou em {$this->class}.";
                unset($this->effects[$index]);
            }
        }

        $this->effects = array_values($this->effects);

        return $messages;
    }

    public $isDefending = false;

    public function defend() {
        $this->isDefending = true;
    }

    public function takeDamage($damage) {
        if ($this->isDefending) {
            $reduction = $this->defense / ($this->defense + 50);
            $finalDamage = max(1, round($damage * (1 - $reduction)));
            $this->isDefending = false;
            echo "(Defendendo! Dano reduzido) ";
        } else {
            $finalDamage = max(1, $damage - floor($this->defense / 2));
        }
        $this->life -= $finalDamage;
        return $finalDamage;
    }

    public static function createCharacter($name) {
        echo "\n$name, escolha sua classe:\n";
        echo "1. Warrior (Guerreiro)\n";
        echo "2. Mage (Mago)\n";
        echo "3. Pally (Paladino)\n";
        $choice = trim(readline("Digite o número da sua escolha: "));

        switch ($choice) {
            case '1':
                system('clear');
                echo "Você escolheu: Warrior!\n";
                return new Warrior("Warrior");
            case '2':
                system('clear');
                echo "Você escolheu: Mage!\n";
                return new Mage("Mage");
            case '3':
                system('clear');
                echo "Você escolheu: Pally!\n";
                return new Pally("Pally");
            default:
                echo "Escolha inválida. Selecionando Warrior como padrão.\n";
                return new Warrior("Warrior");
        }
    }
}

class Warrior extends Character {
    protected function setAttributes() {
        $this->life        = 175;
        $this->damage      = 20;
        $this->defense     = 15;
        $this->mana        = 100;
        $this->specialCost = 30;
    }

    public function specialAttack() {
        return [
            'damage' => round($this->damage * 1.8),
            'effect' => [
                'name' => 'Sangramento',
                'damage' => 8,
                'duration' => 3
            ]
        ];
    }
}

class Mage extends Character {
    protected function setAttributes() {
        $this->life        = 100;
        $this->damage      = 35;
        $this->defense     = 5;
        $this->mana        = 150;
        $this->specialCost = 40;
    }

    public function specialAttack() {
        return [
            'damage' => round($this->damage * 2),
            'effect' => [
                'name' => 'Queimadura',
                'damage' => 10,
                'duration' => 3
            ]
        ];
    }
}

class Pally extends Character {
    protected function setAttributes() {
        $this->life        = 150;
        $this->damage      = 25;
        $this->defense     = 10;
        $this->mana        = 120;
        $this->specialCost = 35;
    }

    public function specialAttack() {
        return [
            'damage' => round($this->damage * 1.5),
            'effect' => [
                'name' => 'Ferida Sagrada',
                'damage' => 6,
                'duration' => 2
            ]
        ];
    }
}
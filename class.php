<?php

abstract class Character {
    
    public $class;
    public $life;
    public $damage;
    public $defense;
    public $mana;

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

        $choice = trim(readline("Digite o número da sua escolha: "));

        switch ($choice) {
            case '1':
                echo "Você escolheu: Warrior!\n";
                return new Warrior("Warrior");
            case '2':
                echo "Você escolheu: Mage!\n";
                return new Mage("Mage");
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
        // Golpe Poderoso: 1.8x do dano base
        return round($this->damage * 1.8);
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
        // Bola de Fogo: 2x do dano base
        return round($this->damage * 2);
    }
}
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

    abstract protected function setAttributes();
    abstract public function specialAttack();

    public function attack() {
        return $this->damage;
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
        } else {
            $finalDamage = max(1, $damage - floor($this->defense / 2));
        }
        $this->life -= $finalDamage;
        return $finalDamage;
    }

    public static function createCharacter($name) {
        echo "$name, escolha sua classe:\n";
        echo "1. Warrior\n";
        echo "2. Mage\n";

        $choice = readline("Digite o número da sua escolha: ");

        switch ($choice) {
            case '1':
                return new Warrior("Warrior");
            case '2':
                return new Mage("Mage");
            default:
                echo "Escolha inválida. Padrão: Warrior.\n";
                return new Warrior("Warrior");
        }
    }
}

class Warrior extends Character {
    protected function setAttributes() {
        $this->life    = 175;
        $this->damage  = 20;
        $this->defense = 15;
        $this->mana    = 100;
    }

    public function specialAttack() {
        return $this->defense * 2;
    }
}

class Mage extends Character {
    protected function setAttributes() {
        $this->life    = 100;
        $this->damage  = 35;
        $this->defense = 5;
        $this->mana    = 150;
    }

    public function specialAttack() {
        return $this->damage * 0.5;
    }
}
# RPG Bndz (CLI em PHP)

Jogo simples de RPG em **terminal** (linha de comando) feito em **PHP**, onde **2 jogadores** criam seus personagens e batalham em turnos até alguém vencer (ou empatar).

---

## Como executar

### Requisitos
- **PHP 7+** (recomendado PHP 8+)
- Terminal com suporte a `readline` (normalmente já vem habilitado)

### Rodando o jogo
No diretório do projeto:

```bash
php index.php
```

Fluxo:
1. Tela inicial → escolha **1 - Acessar Menu**
2. Para cada Player (1 e 2): criar personagem e escolher a **classe**
3. A batalha começa e cada turno você escolhe uma ação:
   - **1. Atacar**
   - **2. Defender**
   - **3. Ataque Especial** (consome MP)

> Dica: a tela é limpa automaticamente entre menus e escolhas de ações para deixar as informações da batalha mais legíveis.

---

## Estrutura do projeto

- `index.php`: entrada do jogo
- `functions.php`: função `startGame()` que chama menu + batalha
- `menu.php`: criação dos 2 jogadores e escolha de classes
- `class.php`: classes de personagem (`Character`, `Warrior`, `Mage`, `Pally`)
- `battle.php`: lógica de batalha por turnos (ataque/defesa/especial, aplicação de efeitos ao longo do tempo)
  
---

## Personagens / Classes

Atualmente existem **3 classes**:

### 1) Warrior (Guerreiro)
**Atributos**
- **HP (vida):** 175  
- **MP (mana):** 100  
- **Dano base:** 20  
- **Defesa:** 15  
- **Custo do especial:** 30 MP  

**Habilidade especial: Golpe Poderoso**
- **Efeito:** causa **1.8× o dano base**
- Com o dano base atual (20), o especial dá **36 de dano** (`round(20 * 1.8)`)
- Causa sangramento, efeito que dá 8 de dano por 3 turnos
- **Custo:** 30 MP

**Estilo:** personagem mais resistente (mais HP e defesa).

---

### 2) Mage (Mago)
**Atributos**
- **HP (vida):** 100  
- **MP (mana):** 150  
- **Dano base:** 35  
- **Defesa:** 5  
- **Custo do especial:** 40 MP  

**Habilidade especial: Bola de Fogo**
- **Efeito:** causa **2× o dano base**
- Com o dano base atual (35), o especial dá **70 de dano** (`round(35 * 2)`)
- Causa queimadura, efeito que dá 10 de dano por 3 turnos
- **Custo:** 40 MP

**Estilo:** muito dano, porém frágil (pouca vida/defesa).

---

### 3) Pally (Paladino) – NOVO
**Atributos**  
*(valores exatos dependem da implementação, ajuste aqui se necessário)*  
- **HP (vida):** alto (tanque)  
- **MP (mana):** médio  
- **Dano base:** médio  
- **Defesa:** alta  

**Habilidade especial:** focada em **efeitos ao longo do tempo** (por exemplo, aplicar um efeito que causa dano extra por alguns turnos).

**Estilo:** personagem híbrido, com boa resistência e capacidade de aplicar **efeitos persistentes** no oponente.

---

## Sistema de Efeitos (Damage over Time)

O jogo possui um sistema de **efeitos** aplicado sobre os personagens:

- Personagens podem receber efeitos que **causam dano a cada turno** (como “queimando”, “sangrando” etc.).
- Os efeitos ativos são exibidos na interface da batalha, mostrando claramente o que está afetando cada jogador.
- Alguns ataques especiais aplicam esses efeitos além do dano imediato.

---

## Como funcionam as ações em batalha

### Atacar
- Causa o **dano base** do personagem (`damage`), passando pela redução de defesa do alvo.
- Pode, dependendo da classe/efeito, interagir com o sistema de efeitos (por exemplo, reaplicar ou reforçar efeitos já existentes).

### Defender
- Ativa um estado de defesa que **reduz o próximo dano recebido**.
- Após reduzir o dano, a defesa “desliga” e o personagem volta ao normal no próximo ataque.

### Ataque Especial
- Só pode ser usado se o jogador tiver **MP suficiente** (mana >= `specialCost`).
- Ao usar, o MP é reduzido pelo custo e o dano do especial é aplicado.
- Pode aplicar **efeitos adicionais** no alvo 
- Se não tiver mana suficiente, o jogador **perde o turno**.

---

## Observações

- O jogo é totalmente em **modo texto** (CLI).
- A batalha termina quando um dos jogadores chegar a **0 HP** (ou menos). Se ambos caírem, dá **empate**.
- As informações de classes, custos e efeitos podem evoluir com novos commits — consulte o código para detalhes exatos da build atual.

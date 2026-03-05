<?php

require_once 'class.php';
require_once 'menu.php';
require_once 'battle.php';

$players = menu();
battle($players);
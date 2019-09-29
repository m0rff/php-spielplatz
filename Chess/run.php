<?php
declare(strict_types=1);

require __DIR__ . '\..\..\vendor\autoload.php';

use Chess\Game;

$game = new Game();
$game->play();
$game->getBoard()->print();
$game->move('a2', 'a4');
$game->getBoard()->print();
$game->move('a1', 'a2');
$game->getBoard()->print();

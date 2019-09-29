<?php
declare(strict_types=1);

require __DIR__ . '\..\vendor\autoload.php';

use Chess\Game;

$game = new Game();
$game->play();
$game->getBoard()->print();
$game->move('b2', 'b3');
$game->getBoard()->print();

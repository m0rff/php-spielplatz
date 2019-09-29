<?php
declare(strict_types=1);

require __DIR__ . '\..\..\vendor\autoload.php';

use Chess\Game;

$game = new Game();
$game->play();
$game->getBoard()->print();
$game->move('b2', 'b4');
$game->getBoard()->print();
$game->move('b4', 'b5');
$game->getBoard()->print();
$game->move('b5', 'b6');
$game->getBoard()->print();
$game->move('b6', 'b7');
$game->getBoard()->print();
$game->move('b7', 'b8');
$game->getBoard()->print();

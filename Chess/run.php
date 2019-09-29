<?php
declare(strict_types=1);

require __DIR__ . '\..\..\vendor\autoload.php';

use Chess\Game;

$game = new Game();
$game->play();
$game->getBoard()->print();
$game->move('a2', 'a4');
$game->getBoard()->print();
$game->move('a1', 'a3');
$game->getBoard()->print();
$game->move('a4', 'a5');
$game->move('a5', 'a6');
$game->getBoard()->print();
$game->move('a6', 'b7');
$game->getBoard()->print();


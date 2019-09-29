<?php
declare(strict_types=1);

namespace App\Lib\Chess;
require __DIR__ . '/../../../vendor/autoload.php';

$game = new Game();
$game->move('a2', 'a4');
$game->move('a1', 'a3');
$game->move('a4', 'a5');
$game->move('a5', 'a6');
$game->move('a6', 'b7');

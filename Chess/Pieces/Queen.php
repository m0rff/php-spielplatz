<?php
declare(strict_types=1);

namespace App\Lib\Chess\Pieces;

use App\Lib\Chess\Board;

/**
 * Class Queen
 */
class Queen extends Piece
{

    /** @inheritDoc */
    public function getSpecialMovement(): array
    {
        return [];
    }

    /** @inheritDoc */
    public function getAllowedMovements(Board $board): array
    {
        return [];
    }
}

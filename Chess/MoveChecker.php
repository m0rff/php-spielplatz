<?php
declare(strict_types=1);

namespace Chess;

use Chess\Pieces\Piece;

/**
 * Class MoveChecker
 */
class MoveChecker
{
    /**
     * @param Board    $board
     * @param Piece    $piece
     * @param Position $target
     *
     * @return bool
     */
    public static function isValidMoveForPiece(Board $board, Piece $piece, Position $target): bool
    {
        $movements = $piece->getAllowedMovements($board);
        if (Position::in_array($target, $movements)) {
            return true;
        }

        return false;
    }
}

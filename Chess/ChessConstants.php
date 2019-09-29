<?php
declare(strict_types=1);

namespace App\Lib\Chess;

use App\Lib\Chess\Pieces\Piece;

/**
 * Class ChessConstants
 */
class ChessConstants
{
    /**
     * Default chess row
     *
     * @var string[]
     */
    public const DEFAULT_ROW =
        [
            Piece::TYPE_ROOK,
            Piece::TYPE_KNIGHT,
            Piece::TYPE_BISHOP,
            Piece::TYPE_QUEEN,
            Piece::TYPE_KING,
            Piece::TYPE_BISHOP,
            Piece::TYPE_KNIGHT,
            Piece::TYPE_ROOK,
        ];
}

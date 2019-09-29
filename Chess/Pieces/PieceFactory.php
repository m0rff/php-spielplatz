<?php
declare(strict_types=1);

namespace App\Lib\Chess\Pieces;

use App\Lib\Chess\Player;
use App\Lib\Chess\Position;

/**
 * Class PieceFactory
 */
class PieceFactory
{

    /**
     * Piece type class mapping
     */
    protected const MAP = [
        Piece::TYPE_ROOK   => Rook::class,
        Piece::TYPE_KNIGHT => Knight::class,
        Piece::TYPE_BISHOP => Bishop::class,
        Piece::TYPE_KING   => King::class,
        Piece::TYPE_QUEEN  => Queen::class,
        Piece::TYPE_PAWN   => Pawn::class,
    ];

    /**
     * Piece Factory
     *
     * @param string                  $type
     * @param \App\Lib\Chess\Position $pos
     *
     * @param \App\Lib\Chess\Player   $player
     *
     * @return Piece
     */
    public static function factory(string $type, Position $pos, Player $player): Piece
    {
        $class = self::MAP[ $type ];

        return new $class($pos, $player);
    }
}

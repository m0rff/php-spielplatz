<?php
declare(strict_types=1);

namespace App\Lib\Chess\Pieces;

use App\Lib\Chess\Board;
use App\Lib\Chess\Player;
use App\Lib\Chess\Position;

/**
 * Interface PieceInterface
 */
interface PieceInterface
{
    /**
     * @param \App\Lib\Chess\Position $target
     *
     * @return void
     */
    public function move(Position $target): void;

    /**
     * @return \App\Lib\Chess\Position
     */
    public function getPosition(): Position;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return array
     */
    public function getSpecialMovement(): array;

    /**
     * @param \App\Lib\Chess\Board $board
     *
     * @return Position[]
     */
    public function getAllowedMovements(Board $board): array;

    /**
     * @param \App\Lib\Chess\Position $position
     *
     * @return Piece
     */
    public function setPosition(Position $position): Piece;

    /**
     * @return \App\Lib\Chess\Player
     */
    public function getPlayer(): Player;

    /**
     * @return bool
     */
    public function onStartPosition(): bool;

    /**
     * @param \App\Lib\Chess\Player $player
     *
     * @return bool
     */
    public function isEnemey(Player $player): bool;
}

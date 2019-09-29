<?php
declare(strict_types=1);

namespace Chess\Pieces;

use Chess\Board;
use Chess\Player;
use Chess\Position;

/**
 * Interface PieceInterface
 */
interface PieceInterface
{
    /**
     * @param Position $target
     *
     * @return void
     */
    public function move(Position $target): void;

    /**
     * @return Position
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
     * @param \Chess\Board $board
     *
     * @return Position[]
     */
    public function getAllowedMovements(Board $board): array;

    /**
     * @param Position $position
     *
     * @return Piece
     */
    public function setPosition(Position $position): Piece;

    /**
     * @return Player
     */
    public function getPlayer(): Player;

    /**
     * @return bool
     */
    public function onStartPosition(): bool;

    /**
     * @param \Chess\Player $player
     *
     * @return bool
     */
    public function isEnemey(Player $player): bool;
}

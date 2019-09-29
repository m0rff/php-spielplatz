<?php
declare(strict_types=1);

namespace App\Lib\Chess\Pieces;

use App\Lib\Chess\Board;
use App\Lib\Chess\Player;
use App\Lib\Chess\Position;
use JsonSerializable;

/**
 * Class Piece
 */
abstract class Piece implements PieceInterface, JsonSerializable
{
    public const TYPE_PAWN = 'pawn';
    public const TYPE_KING = 'king';
    public const TYPE_QUEEN = 'queen';
    public const TYPE_KNIGHT = 'knight';
    public const TYPE_BISHOP = 'bishop';
    public const TYPE_ROOK = 'rook';

    /**
     * @var \App\Lib\Chess\Position $_position
     */
    protected $_position;

    /**
     * @var string $_type
     */
    protected $_type;

    /**
     * @var array $_history
     */
    protected $_history;

    /**
     * @var \App\Lib\Chess\Player $_player
     */
    protected $_player;

    /**
     * Piece constructor.
     *
     * @param Position $pos
     * @param Player   $player
     */
    public function __construct(Position $pos, Player $player)
    {
        $this->_history = [];
        $this->_position = $pos;
        $this->_player = $player;
        $class = get_class($this);
        $names = explode('\\', $class);
        $name = end($names);
        $this->_type = strtolower($name);
    }

    /** @inheritDoc */
    public function move(Position $target): void
    {
        $this->_history[] = $this->getPosition();
        $this->_position = $target;
    }

    /** @inheritDoc */
    public function getPosition(): Position
    {
        return $this->_position;
    }

    /** @inheritDoc */
    public function setPosition(Position $position): Piece
    {
        $this->_position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortType(): string
    {
        return substr($this->_type, 0, 2);
    }

    /** @inheritDoc */
    abstract public function getSpecialMovement(): array;

    /** @inheritDoc */
    abstract public function getAllowedMovements(Board $board): array;

    /** @inheritDoc */
    public function onStartPosition(): bool
    {
        return empty($this->_history);
    }

    /** @inheritDoc */
    public function isEnemey(Player $player): bool
    {
        return $this->getPlayer()->getColor() !== $player->getColor();
    }

    /** @inheritDoc */
    public function getPlayer(): Player
    {
        return $this->_player;
    }

    public function jsonSerialize()
    {
        return [
            'player'   => $this->getPlayer()->getColor(),
            'position' => $this->getPosition(),
            'type'     => $this->getType(),
        ];
    }

    /** @inheritDoc */
    public function getType(): string
    {
        return $this->_type;
    }
}

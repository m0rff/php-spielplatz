<?php
declare(strict_types=1);

namespace Chess\Pieces;

use Chess\Board;
use Chess\Player;
use Chess\Position;

/**
 * Class Piece
 */
abstract class Piece implements PieceInterface
{
    public const TYPE_PAWN = 'pawn';
    public const TYPE_KING = 'king';
    public const TYPE_QUEEN = 'queen';
    public const TYPE_KNIGHT = 'knight';
    public const TYPE_BISHOP = 'bishop';
    public const TYPE_ROOK = 'rook';

    /**
     * @var Position $_position
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
     * @var Player $_player
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
        $this->_type = $names[2];
    }

    /**
     * @inheritDoc
     */
    public function move(Position $target): void
    {
        $this->_history[] = $this->getPosition();
        $this->_position = $target;
    }

    /**
     * @inheritDoc
     */
    public function getPosition(): Position
    {
        return $this->_position;
    }

    /**
     * @inheritDoc
     */
    public function setPosition(Position $position): Piece
    {
        $this->_position = $position;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getShortType(): string
    {
        return substr($this->_type, 0, 2);
    }

    /**
     * @inheritDoc
     */
    abstract public function getSpecialMovement(): array;

    /**
     * @inheritDoc
     */
    abstract public function getAllowedMovements(Board $board): array;

    /**
     * @inheritDoc
     */
    public function getPlayer(): Player
    {
        return $this->_player;
    }
}

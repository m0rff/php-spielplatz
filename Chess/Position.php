<?php
declare(strict_types=1);

namespace App\Lib\Chess;

use InvalidArgumentException;
use JsonSerializable;

/**
 * Class Position
 */
class Position extends PositionFactory implements JsonSerializable
{
    public const LEFT = 'left';
    public const RIGHT = 'right';
    public const FORWARD = 'forward';
    public const BACK = 'back';
    public const FORWARD_LEFT = 'forwardleft';
    public const FORWARD_RIGHT = 'forwardleft';
    public const BACK_LEFT = 'backleft';
    public const BACK_RIGHT = 'backright';
    public const FORWARD_2 = 'forwardtwo';

    /**
     * @var int $_x
     */
    protected $_x;

    /**
     * @var int $_y
     */
    protected $_y;


    /**
     * @var int $_chessXInt
     */
    protected $_chessXInt;

    /**
     * @var string $_chessYChar
     */
    protected $_chessYChar;

    /**
     * @param \App\Lib\Chess\Position   $target
     * @param \App\Lib\Chess\Position[] $movements
     *
     * @return bool
     */
    public static function in_array(Position $target, array $movements): bool
    {
        foreach ($movements as $movement) {
            if ($movement->equals($target)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \App\Lib\Chess\Position $pos
     *
     * @return bool
     */
    public function equals(Position $pos): bool
    {
        return $pos->getX() === $this->_x && $pos->getY() === $this->_y;
    }

    /**
     * Return x
     *
     * @return int
     */
    public function getX(): int
    {
        return $this->_x;
    }

    /**
     * Return y
     *
     * @return int
     */
    public function getY(): int
    {
        return $this->_y;
    }

    /**
     * Create from integer array
     *
     * @param int[] $pos
     *
     * @return Position
     */
    public function fromIntArray(array $pos): Position
    {
        $this->_x = $pos['x'];
        $this->_y = $pos['y'];

        return $this->_setChessCoords();
    }

    /**
     * Set chess coords
     *
     * @return Position
     */
    protected function _setChessCoords(): Position
    {
        $this->_chessXInt = Board::SIZE - $this->_x;
        $this->_chessYChar = self::_getChessCharForY($this->_y);

        return $this;
    }

    /**
     * Get the letter for given y pos
     *
     * @param int $y
     *
     * @return string
     */
    protected static function _getChessCharForY(int $y): string
    {
        return range('a', 'h')[ $y ];
    }

    /**
     * Create from integer string
     *
     * @param string $pos
     *
     * @return Position
     */
    public function fromIntString(string $pos): Position
    {
        [$x, $y] = self::_parseFromtIntString($pos);

        return $this->fromInt($x, $y);
    }

    /**
     * arse position string like (2,1)
     *
     * @param string $pos
     *
     * @return array
     */
    protected static function _parseFromtIntString(string $pos): array
    {
        if (strlen($pos) !== 5) {
            throw new InvalidArgumentException($pos . ' is not a valid coord string.');
        }

        return [
            $pos[1],
            $pos[3],
        ];
    }

    /**
     * Create from 2 ints
     *
     * @param int $x
     * @param int $y
     *
     * @return Position
     */
    public function fromInt(int $x, int $y): Position
    {
        $this->_x = $x;
        $this->_y = $y;

        return $this->_setChessCoords();
    }

    /**
     * Create from chess string
     *
     * @param string $pos
     *
     * @return Position
     */
    public function fromChessString(string $pos): Position
    {
        [$x, $y] = self::_parseFromChessString($pos);

        return $this->fromInt($x, $y);
    }

    /**
     * Parse position string like e5
     *
     * @param string $pos
     *
     * @return array
     */
    protected static function _parseFromChessString(string $pos): array
    {
        if (strlen($pos) !== 2) {
            throw new InvalidArgumentException($pos . ' is not a valid chess coord string.');
        }

        $letter = $pos[0];
        $y = self::_getYCoordFromChessChar($letter);
        $x = Board::SIZE - (int) $pos[1];


        return [$x, $y];
    }

    /**
     * Get the y coord pos for given letter
     *
     * @param string $letter
     *
     * @return int
     */
    protected static function _getYCoordFromChessChar(string $letter): int
    {
        return ord(strtoupper($letter)) - ord('A');
    }

    /**
     * @param int $n
     *
     * @return \Chess\Position|null
     */
    public function left(int $n = 1): ?Position
    {
        $y = $this->_y - $n;

        if ($y < 0) {
            return null;
        }

        return PositionFactory::factory($this->_x, $y);
    }

    /**
     * @param int $n
     *
     * @return \Chess\Position|null
     */
    public function right(int $n = 1): ?Position
    {
        $y = $this->_y + $n;

        if ($y > Board::SIZE - 1) {
            return null;
        }

        return PositionFactory::factory($this->_x, $y);
    }

    /**
     * @param int $n
     *
     * @return \Chess\Position|null
     */
    public function back(int $n = 1): ?Position
    {
        $x = $this->_x + $n;

        if ($x > Board::SIZE - 1) {
            return null;
        }

        return PositionFactory::factory($x, $this->_y);
    }

    /**
     *
     * @return \Chess\Position|null
     */
    public function forwardtwo(): ?Position
    {
        return $this->forward(2);
    }

    /**
     * @param int $n
     *
     * @return \Chess\Position|null
     */
    public function forward(int $n = 1): ?Position
    {
        $x = $this->_x - $n;

        if ($x < 0) {
            return null;
        }

        return PositionFactory::factory($x, $this->_y);
    }

    /**
     * @return \App\Lib\Chess\Position|null
     */
    public function forwardleft(): ?Position
    {
        $x = $this->_x - 1;
        $y = $this->_y + 1;

        if ($y < 0 || $x < 0) {
            return null;
        }

        return PositionFactory::factory($x, $y);
    }

    /**
     * @return \App\Lib\Chess\Position|null
     */
    public function forwardright(): ?Position
    {
        $x = $this->_x - 1;
        $y = $this->_y - 1;

        if ($y > Board::SIZE - 1 || $x < 0) {
            return null;
        }

        return PositionFactory::factory($x, $y);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'x' => $this->getX(),
            'y' => $this->gety(),
            's' => $this->getChessString(),
        ];
    }

    /**
     * Return chess coords
     *
     * @return string
     */
    public function getChessString(): string
    {
        return $this->_chessYChar . $this->_chessXInt;
    }
}

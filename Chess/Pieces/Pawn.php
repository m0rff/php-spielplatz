<?php
declare(strict_types=1);

namespace App\Lib\Chess\Pieces;

use App\Lib\Chess\Board;
use App\Lib\Chess\Position;

/**
 * Class Pawn
 */
class Pawn extends Piece
{

    /**
     * @param \App\Lib\Chess\Pieces\Piece|null $piece
     *
     * @return bool
     */
    protected static function _checkForward(?Piece $piece): bool
    {
        return $piece === null;
    }

    /** @inheritDoc */
    public function getSpecialMovement(): array
    {
        return [];
    }

    /** @inheritDoc */
    public function getAllowedMovements(Board $board): array
    {
        $movements = [];

        $posForward = $this->_checkPawn($board, Position::FORWARD);
        if ($posForward) {
            $movements[] = $posForward;

            if ($this->onStartPosition()) {
                $pos2Forward = $this->_checkPawn($board, Position::FORWARD_2);
                if ($pos2Forward) {
                    $movements[] = $pos2Forward;
                }
            }
        }

        $posForwardRight = $this->_checkPawn($board, Position::FORWARD_RIGHT);
        if ($posForwardRight) {
            $movements[] = $posForwardRight;
        }

        $posForwardLeft = $this->_checkPawn($board, Position::FORWARD_LEFT);
        if ($posForwardLeft) {
            $movements[] = $posForwardLeft;
        }

        return $movements;
    }

    /**
     * @param \App\Lib\Chess\Board $board
     * @param string               $direction
     *
     * @return \App\Lib\Chess\Position|null
     */
    protected function _checkPawn(Board $board, string $direction): ?Position
    {
        $posDirection = $this->getPosition()->{$direction}();
        if ($posDirection) {
            $cb = $this->_getCbForDirection($direction);

            $check = $board->queryPos($posDirection);
            if ($cb($check)) {
                return $posDirection;
            }
        }

        return null;
    }

    /**
     * @param string $direction
     *
     * @return callable
     */
    protected function _getCbForDirection(string $direction): callable
    {
        switch ($direction) {


            case Position::FORWARD:
                return [self::class, '_checkForward'];
            case Position::FORWARD_2:
                return [$this, '_checkForwardTwo'];
            case Position::FORWARD_LEFT:
            case Position::FORWARD_RIGHT:
                return [$this, '_checkForwardLR'];
            case Position::BACK:
            case Position::BACK_LEFT:
            case Position::BACK_RIGHT:
            case Position::RIGHT:
            case Position::LEFT:
            default:
                return static function () {
                    return false;
                };
        }

    }

    /**
     * @param \App\Lib\Chess\Pieces\Piece|null $piece
     *
     * @return bool
     */
    protected function _checkForwardLR(?Piece $piece): bool
    {
        return $piece !== null && $piece->isEnemey($this->getPlayer());
    }

    /**
     * @param \App\Lib\Chess\Pieces\Piece|null $piece
     *
     * @return bool
     */
    protected function _checkForwardTwo(?Piece $piece): bool
    {
        return $piece === null;
    }
}

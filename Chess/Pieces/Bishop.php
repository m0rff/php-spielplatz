<?php
declare(strict_types=1);

namespace App\Lib\Chess\Pieces;

use App\Lib\Chess\Board;
use App\Lib\Chess\Position;

/**
 * Class Bishop
 */
class Bishop extends Piece
{

    /** @inheritDoc */
    public function getSpecialMovement(): array
    {
        return [];
    }

    /** @inheritDoc */
    public function getAllowedMovements(Board $board): array
    {
        $movements = [];

        $forwardLeftLine = $this->_check($board, Position::FORWARD_LEFT);
        $forwardLeft = $this->_checkLine($forwardLeftLine);
        if ($forwardLeft) {
            $movements[] = $forwardLeft;
        }

        return $movements;
    }

    /**
     * @param \App\Lib\Chess\Board $board
     * @param string               $direction
     *
     * @return array
     */
    protected function _check(Board $board, string $direction): array
    {
        $line = [];
        $pos = $this->getPosition()->{$direction}();
        if ($pos) {
            $check = $board->queryPos($pos);
            if ($check === null) {
                $line[] = $pos;
                $line = array_merge($pos, $this->_check($board, $direction));
            } elseif ($check !== null && $check->isEnemey($this->getPlayer())) {
                $line[] = $pos;
            }
        }

        return $line;
    }

    protected function _checkLine(array $line): array
    {

    }
}

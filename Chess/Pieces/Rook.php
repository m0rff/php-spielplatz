<?php
declare(strict_types=1);

namespace Chess\Pieces;

use Chess\Board;
use Chess\MoveChecker;
use Chess\Position;
use Chess\PositionFactory;

/**
 * Class Rook
 */
class Rook extends Piece
{

    /** @inheritDoc */
    public function getSpecialMovement(): array
    {
        return [];
    }

    /** @inheritDoc */
    public function getAllowedMovements(Board $board): array
    {
        $left = MoveChecker::checkLine($this->getPosition(), $board, MoveChecker::LEFT);
        $right = MoveChecker::checkLine($this->getPosition(), $board, MoveChecker::RIGHT);
        $forward = MoveChecker::checkLine($this->getPosition(), $board, MoveChecker::FORWARD);
        $back = MoveChecker::checkLine($this->getPosition(), $board, MoveChecker::BACK);


        $positions[] = $this->_check($this->getPosition(), $left, $board, MoveChecker::LEFT);
        $positions[] = $this->_check($this->getPosition(), $right, $board, MoveChecker::RIGHT);
        $positions[] = $this->_check($this->getPosition(), $forward, $board, MoveChecker::FORWARD);
        $positions[] = $this->_check($this->getPosition(), $back, $board, MoveChecker::BACK);

        $positions = array_merge($positions);

        return $positions;
    }

    /**
     * @param \Chess\Position      $pos
     * @param \Chess\Position|null $target
     * @param \Chess\Board         $board
     * @param string               $direction
     *
     * @return \Chess\Position|null
     */
    protected function _check(Position $pos, ?Position $target, Board $board, string $direction): ?Position
    {
        if ($pos !== null) {
            $check = $board->queryPos($pos);
            if ($check && $check->isEnemey($this->getPlayer())) {
                return $pos;
            } elseif ($check) {
                return $pos[ $direction ]();
            } else {
                return PositionFactory::lineFromTo($pos, $target);
            }
        }
    }
}

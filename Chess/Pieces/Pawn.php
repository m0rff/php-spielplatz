<?php
declare(strict_types=1);

namespace Chess\Pieces;

use Chess\Board;

/**
 * Class Pawn
 */
class Pawn extends Piece
{

    /**
     * @inheritDoc
     */
    public function getSpecialMovement(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAllowedMovements(Board $board): array
    {
        $movements = [];

        $posLeft = $this->getPosition()->left();
        if ($posLeft) {
            $checkLeft = $board->queryPos($posLeft);
            if ($checkLeft && $checkLeft->getPlayer()->getColor() !== $this->getPlayer()->getColor()) {
                $movements[] = $posLeft;
            }
        }

        $posRight = $this->getPosition()->right();
        if ($posRight) {
            $checkRight = $board->queryPos($posRight);
            if ($checkRight && $checkRight->getPlayer()->getColor() !== $this->getPlayer()->getColor()) {
                $movements[] = $posRight;
            }
        }

        $posForward = $this->getPosition()->forward();
        if ($posForward) {
            $checkForward = $board->queryPos($posForward);
            if (
                $checkForward === null
                || ($checkForward && $checkForward->getPlayer()->getColor() !== $this->getPlayer()->getColor())
            ) {
                $movements[] = $posForward;
            }
        }

        $posForwardLeft = $posForward->left();
        if ($posForwardLeft) {
            $checkForwardLeft = $board->queryPos($posForwardLeft);
            if ($checkForwardLeft && $checkForwardLeft->getPlayer()->getColor() !== $this->getPlayer()->getColor()) {
                $movements[] = $posForwardLeft;
            }
        }

        $posForwardRight = $posForward->right();
        if ($posForwardRight) {
            $checkForwardRight = $board->queryPos($posForwardRight);
            if ($checkForwardRight && $checkForwardRight->getPlayer()->getColor() !== $this->getPlayer()->getColor()) {
                $movements[] = $posForwardRight;
            }
        }

        return $movements;
    }
}

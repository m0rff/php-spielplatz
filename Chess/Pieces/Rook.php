<?php
declare(strict_types=1);

namespace Chess\Pieces;

use Chess\Board;
use Chess\Position;

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
        $positions = [];

        if ($leftLine = $board->checkLine($this->getPosition(), Position::LEFT)) {
            $positions[] = $this->_checkRookLine($leftLine, $board, Position::LEFT);
        }

        if ($rightLine = $board->checkLine($this->getPosition(), Position::RIGHT)) {
            $positions[] = $this->_checkRookLine($rightLine, $board, Position::RIGHT);
        }

        if ($forwardLine = $board->checkLine($this->getPosition(), Position::FORWARD)) {
            $positions[] = $this->_checkRookLine($forwardLine, $board, Position::FORWARD);
        }

        if ($backLine = $board->checkLine($this->getPosition(), Position::BACK)) {
            $positions[] = $this->_checkRookLine($backLine, $board, Position::BACK);
        }

        $positions = array_filter(array_merge(...$positions));

        return $positions;
    }

    /**
     * @param array        $line
     * @param \Chess\Board $board
     * @param string       $direction
     *
     * @return \Chess\Position[]
     */
    protected function _checkRookLine(array $line, Board $board, string $direction): array
    {
        foreach ($line as $i => $position) {
            if ($position) {
                $piece = $board->queryPos($position);
                if ($piece) {
                    $l = $i - 1;
                    if ($piece->isEnemey($this->getPlayer())) {
                        $l = $i;
                    }

                    return array_slice($line, 0, $l);
                }
            }
        }

        return [];
    }
}

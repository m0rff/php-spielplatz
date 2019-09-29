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
            $positions[] = $this->_checkRookLine($leftLine, $board);
        }

        if ($rightLine = $board->checkLine($this->getPosition(), Position::RIGHT)) {
            $positions[] = $this->_checkRookLine($rightLine, $board);
        }

        if ($forwardLine = $board->checkLine($this->getPosition(), Position::FORWARD)) {
            $positions[] = $this->_checkRookLine($forwardLine, $board);
        }

        if ($backLine = $board->checkLine($this->getPosition(), Position::BACK)) {
            $positions[] = $this->_checkRookLine($backLine, $board);
        }

        $positions = array_filter(array_merge(...$positions));

        return $positions;
    }

    /**
     * @param array        $line
     * @param \Chess\Board $board
     *
     * @return \Chess\Position[]
     */
    protected function _checkRookLine(array $line, Board $board): array
    {
        foreach ($line as $i => $position) {
            if ($position) {
                $piece = $board->queryPos($position);
                if ($piece) {
                    $l = $i;
                    if ($piece->isEnemey($this->getPlayer())) {
                        $l = $i + 1;
                    }

                    return array_slice($line, 0, $l);
                }
            }
        }

        return [];
    }
}

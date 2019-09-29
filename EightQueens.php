<?php
declare(strict_types=1);

/**
 * Class EightQueens
 */
class EightQueens
{
    /**
     * Board size
     *
     * @var int
     */
    public const BOARD_SIZE = 8;

    /**
     * Queens
     *
     * @var string[] $_queens
     */
    protected $_queens;

    /**
     * 2d chess board array. True means a queen is at that position
     *
     * @var $_board
     */
    protected $_board;

    /**
     * Set Queens and generate board
     *
     * @param string[] $queens Array of Queens
     */
    public function setQueensBoard(array $queens): void
    {
        $this->_queens = $queens;

        $this->_generateBoard();
    }

    /**
     * Find queen who hits another or return true if all miss
     *
     * @return string|true
     */
    public function determineResult()
    {
        foreach ($this->_queens as $i => $queen) {
            if ($this->_checkIfQueenCanHit($queen)) {
                return $queen;
            }
        }

        return true;
    }

    /**
     * Returns whether given queen can hit anything
     *
     * @param string $attackingQueen
     * @return bool
     */
    protected function _checkIfQueenCanHit(string $attackingQueen): bool
    {
        $tempBoard = $this->_board;
        $aPos = self::_parsePosition($attackingQueen);
        self::_unsetQueen($tempBoard, $aPos);

        return $this->_checkXY($tempBoard, $aPos) || $this->_checkD($tempBoard, $aPos);
    }


    /**
     * Horizonal check
     *
     * @param array $tempBoard
     * @param array $pos
     * @return bool
     */
    protected function _checkXY(array $tempBoard, array $pos): bool
    {
        foreach ($tempBoard as $x => $row) {
            if ($x === $pos['x']) {
                foreach ($row as $field) {
                    if ($field === true) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Diagonal check
     *
     * @param $tempBoard
     * @param array $pos
     * @return bool
     */
    protected function _checkD($tempBoard, array $pos): bool
    {

        return false;
    }


    /**
     * Generate chess board array
     */
    protected function _generateBoard(): void
    {
        $this->_board = array_fill(
            0,
            self::BOARD_SIZE - 1,
            array_fill(0, self::BOARD_SIZE - 1, false)
        );

        foreach ($this->_queens as $queen) {
            $pos = self::_parsePosition($queen);
            $this->_board[$pos['x']][$pos['y']] = true;
        }
    }

    /**
     * Convert the queen pos "(2,1)" to x,y coords in an array
     *
     * @param string $pos
     * @return array
     */
    protected static function _parsePosition(string $pos): array
    {
        return [
            'x' => self::BOARD_SIZE - $pos[1],
            'y' => $pos[3] - 1,
        ];
    }

    /**
     * Unsets the queen value at given pos
     *
     * @param array $board
     * @param array $queenPos
     * @return void
     */
    protected static function _unsetQueen(array &$board, array $queenPos): void
    {
        $board[$queenPos['x']][$queenPos['y']] = false;
    }
}
<?php
declare(strict_types=1);

namespace Chess;

use Chess\Pieces\Piece;

/**
 * Class MoveChecker
 */
class MoveChecker
{
    public const LEFT = 'left';
    public const RIGHT = 'right';
    public const FORWARD = 'forward';
    public const BACK = 'back';

    /**
     * @param Board    $board
     * @param Piece    $piece
     * @param Position $target
     *
     * @return bool
     */
    public static function isValidMoveForPiece(Board $board, Piece $piece, Position $target): bool
    {
        $movements = $piece->getAllowedMovements($board);
        if (Position::in_array($target, $movements)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Chess\Position $position
     * @param \Chess\Board    $board
     *
     * @return \Chess\Position|null
     */
    public static function checkForwardLine(Position $position, Board $board): ?Position
    {
        $forwardPos = $position->forward();
        if ($forwardPos) {
            $forwardCheck = $board->queryPos($forwardPos);
            if ($forwardCheck) {
                return $forwardPos;
            }

            return self::checkLeftLine($forwardPos, $board);
        }

        return null;
    }

    /**
     * @param \Chess\Position $position
     * @param \Chess\Board    $board
     *
     * @return \Chess\Position|null
     */
    public static function checkLeftLine(Position $position, Board $board): ?Position
    {
        $leftPos = $position->left();
        if ($leftPos) {
            $leftCheck = $board->queryPos($leftPos);
            if ($leftCheck) {
                return $leftPos;
            }

            return self::checkLeftLine($leftPos, $board);
        }

        return null;
    }

    /**
     * @param \Chess\Position $position
     * @param \Chess\Board    $board
     *
     * @return \Chess\Position|null
     */
    public static function checkBackLine(Position $position, Board $board): ?Position
    {
        $backPos = $position->back();
        if ($backPos) {
            $backCheck = $board->queryPos($backPos);
            if ($backCheck) {
                return $backPos;
            }

            return self::checkLeftLine($backPos, $board);
        }

        return null;
    }

    /**
     * @param \Chess\Position $position
     * @param \Chess\Board    $board
     *
     * @return \Chess\Position|null
     */
    public static function checkRightLine(Position $position, Board $board): ?Position
    {
        $rightPos = $position->right();
        if ($rightPos) {
            $rightCheck = $board->queryPos($rightPos);
            if ($rightCheck) {
                return $rightPos;
            }

            return self::checkRightLine($rightPos, $board);
        }

        return null;
    }

    /**
     * @param \Chess\Position $position
     * @param \Chess\Board    $board
     * @param string          $direction
     *
     * @return \Chess\Position|null
     */
    public static function checkLine(Position $position, Board $board, string $direction): ?Position
    {
        $pos = $position[ $direction ]();
        if ($pos) {
            $check = $board->queryPos($pos);
            if ($check) {
                return $pos;
            }

            return self::checkLine($pos, $board, $direction);
        }

        return $position;
    }
}

<?php
declare(strict_types=1);

namespace Chess;

use Chess\Pieces\Piece;
use Chess\Pieces\PieceFactory;
use League\CLImate\CLImate;

/**
 * Class Board
 *
 * @property  Piece[] $_board
 * @property  Piece[] $_graveyard
 */
class Board
{
    /**
     * Board size
     */
    public const SIZE = 8;

    /**
     * @var array Piece[]
     */
    protected $_board;

    /**
     * @var array Piece[]
     */
    protected $_graveyard;

    /**
     * Board constructor.
     */
    public function __construct()
    {
        $this->_generateBoard();
    }

    /**
     * Generate board
     */
    protected function _generateBoard(): void
    {
        $this->_board = array_fill(0,
            self::SIZE - 1,
            array_fill(0, self::SIZE, null)
        );
    }

    /**
     * Move a piece to targe position
     *
     * @param Piece    $piece
     * @param Position $targetPos
     *
     * @return bool
     */
    public function movePiece(Piece $piece, Position $targetPos): bool
    {
        if (!$this->isValidMoveForPiece($piece, $targetPos)) {
            return false;
        }

        if ($existingPiece = $this->queryPos($targetPos)) {
            $this->moveToGraveyard($existingPiece);
        }

        $oldPos = $piece->getPosition();
        $piece->move($targetPos);
        $this->_move($oldPos, $piece, $targetPos);

        return true;
    }

    /**
     * Return whether target is a valid move for Piece
     *
     * @param \Chess\Pieces\Piece $piece
     * @param \Chess\Position     $target
     *
     * @return bool
     */
    public function isValidMoveForPiece(Piece $piece, Position $target): bool
    {
        if (Position::in_array($target, $piece->getAllowedMovements($this))) {
            return true;
        }

        return false;
    }

    /**
     * Get Piece from Position
     *
     * @param Position $position
     *
     * @return Piece|null
     */
    public function queryPos(Position $position): ?Piece
    {
        return $this->_board[ $position->getX() ][ $position->getY() ];
    }

    /**
     * Move to graveyard
     *
     * @param $existingPiece
     */
    public function moveToGraveyard($existingPiece): void
    {
        $this->_graveyard[] = $existingPiece;
    }

    /**
     * Move piece
     *
     * @param Position $oldPos
     * @param Piece    $piece
     * @param Position $target
     */
    protected function _move(Position $oldPos, Piece $piece, Position $target): void
    {
        $this->_setPieceToPosition(null, $oldPos);
        $this->_setPieceToPosition($piece, $target);
    }

    /**
     * Set Piece to Position on Board
     *
     * @param Piece|null $piece
     * @param Position   $position
     */
    protected function _setPieceToPosition(?Piece $piece, Position $position): void
    {
        $this->_board[ $position->getX() ][ $position->getY() ] = $piece;
    }

    /**
     * Check a straight line
     *
     * @param \Chess\Position $position
     * @param string          $direction
     *
     * @return \Chess\Position[]|array
     */
    public function checkLine(Position $position, string $direction): array
    {
        $line = [];
        $pos = $position->{$direction}();
        if ($pos) {
            $piece = $this->queryPos($pos);
            if ($piece) {
                return [$pos];
            }

            $line[] = $pos;
            $line = array_merge($line, self::checkLine($pos, $direction));
        }

        return $line;
    }

    /**
     * Init the board
     *
     * @param Game $game
     */
    public function initGame(Game $game): void
    {
        $wp = $game->getWhite();
        $bp = $game->getBlack();
        $x = 0;
        foreach (ChessConstants::DEFAULT_ROW as $y => $type) {
            $piece = PieceFactory::factory($type, PositionFactory::factory($x, $y), $bp);
            $this->_setPieceToPosition($piece, $piece->getPosition());
        }

        $x = 1;
        for ($y = 0; $y < self::SIZE; $y++) {
            $piece = PieceFactory::factory(Piece::TYPE_PAWN, PositionFactory::factory($x, $y), $bp);
            $this->_setPieceToPosition($piece, $piece->getPosition());
        }


        $x = self::SIZE - 2;
        for ($y = 0; $y < self::SIZE; $y++) {
            $piece = PieceFactory::factory(Piece::TYPE_PAWN, PositionFactory::factory($x, $y), $wp);
            $this->_setPieceToPosition($piece, $piece->getPosition());
        }

        $x = self::SIZE - 1;
        foreach (ChessConstants::DEFAULT_ROW as $y => $type) {
            $piece = PieceFactory::factory($type, PositionFactory::factory($x, $y), $wp);
            $this->_setPieceToPosition($piece, $piece->getPosition());
        }
    }

    /**
     * Print board
     */
    public function print(): void
    {
        $climate = new CLImate;
        $colors = new Colors();
        $data = [];

        foreach (range('a', 'h') as $y => $letter) {
            $data[0][ $y + 1 ] = $colors->getColoredString($letter, 'black');
        }

        foreach ($this->_board as $x => $row) {
            $str = (string) self::SIZE - $x;
            $data[ $x + 1 ][0] = $colors->getColoredString($str, 'black');
            /**
             * @var Piece $piece
             */
            foreach ($row as $y => $piece) {
                if ($piece !== null) {
                    $str = $piece->getShortType() . '' . $piece->getPlayer()->getShortColor();
                    $color = 'blue';
                    if ($piece->getPlayer()->getColor() === Player::WHITE) {
                        $color = 'yellow';
                    }
                    $str = $colors->getColoredString($str, $color);
                    $data[ $x + 1 ][ $y + 1 ] = $str;
                } else {
                    $str = $colors->getColoredString('[  ]', 'black');
                    $data[ $x + 1 ][ $y + 1 ] = $str;
                }
            }
            $data[ $x + 1 ][ self::SIZE + 1 ] = $colors->getColoredString((string) self::SIZE - $x, 'black');
            ksort($data[ $x ], SORT_ASC + SORT_NUMERIC);
        }

        foreach (range('a', 'h') as $y => $letter) {
            $data[ self::SIZE + 1 ][ $y + 1 ] = $colors->getColoredString($letter, 'black');
        }

        $str = $colors->getColoredString('#', 'black');
        $data[ self::SIZE + 1 ][ self::SIZE + 1 ] = $str;
        $data[ self::SIZE + 1 ][0] = $str;
        $data[0][ self::SIZE + 1 ] = $str;
        $data[0][0] = $str;

        ksort($data[ self::SIZE + 1 ], SORT_ASC + SORT_NUMERIC);

        $climate->table($data);
    }
}

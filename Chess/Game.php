<?php
declare(strict_types=1);

namespace Chess;

use RuntimeException;

/**
 * Class Game
 */
class Game
{
    /**
     * @var Player[]
     */
    protected $_players;

    /**
     * @var Board
     */
    private $_board;

    public function __construct()
    {
        $this->_players = [
            Player::WHITE => new Player(Player::WHITE),
            Player::BLACK => new Player(Player::BLACK),
        ];

        $this->_board = new Board();
        $this->_board->initGame($this);
    }

    public function play(): void
    {
        // do stuff
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->_players;
    }

    /**
     * @return Player
     */
    public function getWhite(): Player
    {
        return $this->_players[ Player::WHITE ];
    }

    /**
     * @return Player
     */
    public function getBlack(): Player
    {
        return $this->_players[ Player::BLACK ];
    }

    /**
     * @param string $piecePos
     * @param string $targetPos
     */
    public function move(string $piecePos, string $targetPos): void
    {
        $pos = PositionFactory::factory($piecePos);
        $target = PositionFactory::factory($targetPos);

        $piece = $this->getBoard()->queryPos($pos);
        if (!$piece) {
            throw new RuntimeException('Invalid move');
        }

        if (!$this->getBoard()->movePiece($piece, $target)) {
            throw new RuntimeException('Invalid move');
        }
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->_board;
    }
}

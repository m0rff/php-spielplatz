<?php
declare(strict_types=1);

namespace App\Lib\Chess;

use RuntimeException;

/**
 * Class Game
 */
class Game
{
    /**
     * @var \App\Lib\Chess\Player[]
     */
    protected $_players;
    /**
     * @var \App\Lib\Chess\Player
     */
    protected $_currentPlayer;
    /**
     * @var string
     */
    protected $_gameId;
    /**
     * @var \App\Lib\Chess\Board
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
        $this->_currentPlayer = $this->_players[ Player::WHITE ];
    }

    /**
     * @return \App\Lib\Chess\Player[]
     */
    public function getPlayers(): array
    {
        return $this->_players;
    }

    /**
     * @return \App\Lib\Chess\Player
     */
    public function getWhite(): Player
    {
        return $this->_players[ Player::WHITE ];
    }

    /**
     * @return \App\Lib\Chess\Player
     */
    public function getBlack(): Player
    {
        return $this->_players[ Player::BLACK ];
    }

    /**
     * @param \App\Lib\Chess\Player $p
     * @param string                $pos
     * @param string                $target
     */
    public function playerMove(Player $p, string $pos, string $target)
    {
        if ($p->getColor() !== $this->_currentPlayer->getColor()) {
            throw new RuntimeException('Not your turn.');
        }

        $this->move($pos, $target);
    }

    /**
     * @param string $piecePos
     * @param string $targetPos
     */
    public function move(string $piecePos, string $targetPos): void
    {
        $pos = PositionFactory::factory($piecePos);
        $target = PositionFactory::factory($targetPos);

        $piece = $this->getBoardInstance()->queryPos($pos);
        if (!$piece) {
            throw new RuntimeException('Invalid piece.');
        }

        if (!$this->getBoardInstance()->movePiece($piece, $target)) {
            throw new RuntimeException('Invalid move.');
        }
    }

    /**
     * @return \App\Lib\Chess\Board
     */
    public function getBoardInstance(): Board
    {
        return $this->_board;
    }
}

<?php
declare(strict_types=1);

namespace App\Lib\Chess;

/**
 * Class Player
 */
class Player
{
    public const WHITE = 'white';
    public const BLACK = 'black';

    /**
     * @var string $_color
     */
    protected $_color;

    /**
     * Player constructor.
     *
     * @param string $color
     */
    public function __construct(string $color)
    {
        $this->_color = $color;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->_color;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getShortColor(): string
    {
        return strtoupper($this->_color[0]);
    }
}

<?php
declare(strict_types=1);

/**
 * Class MaxSquareFinder
 *
 */
class MaxSquareFinder
{
    /**
     * Square array
     *
     * @var string[] $_square
     */
    protected $_square;

    /**
     * Square line length
     *
     * @var int $_lineLength
     */
    protected $_lineLength;

    /**
     * Square row count
     *
     * @var int rowCount
     */
    protected $_rowCount;

    /**
     * Set square array
     *
     * @param array $_square
     */
    public function setSquare(array $_square): void
    {
        $this->_square = $_square;
        $this->_lineLength = strlen($this->_square[0]);
        $this->_rowCount = count($this->_square);
    }

    /**
     * Return size of largest square of '1's found in square array
     *
     * @return int
     */
    public function findLargestSquare(): int
    {
        $searchLength = min($this->_lineLength, $this->_rowCount);

        while ($searchLength >= 1) {
            $currentRow = 0;
            $search = str_repeat('1', $searchLength);

            while ($currentRow < $this->_rowCount) {
                foreach (self::_strpos_all($this->_square[ $currentRow ], $search) as $pos) {
                    if ($this->_checkPosBelow($pos, $currentRow, $searchLength, $search)) {
                        return $searchLength ** 2;
                    }
                }

                $currentRow++;
            }

            $searchLength--;
        }

        return 0;
    }

    /**
     * Find all positions of needle in haystack
     *
     * @param string $haystack Haystack
     * @param string $needle   Needle
     *
     * @return array
     */
    protected static function _strpos_all(string $haystack, string $needle): array
    {
        $offset = 0;
        $allpos = [];
        while (($pos = strpos($haystack, $needle, $offset)) !== false) {
            $offset = $pos + 1;
            $allpos[] = $pos;
        }

        return $allpos;
    }

    /**
     * Checks if square array has size times '1' below given pos/row
     *
     * @param int    $row    Row
     * @param int    $pos    Pos
     * @param int    $size   Size
     * @param string $search Search string
     *
     * @return bool
     */
    protected function _checkPosBelow(int $row, int $pos, int $size, string $search): bool
    {
        $nextRow = $row + 1;
        while ($nextRow < $row + $size) {
            $rowPos = strpos($this->_square[ $nextRow ], $search, $pos);
            if ($rowPos !== 0) {
                return false;
            }
            $nextRow++;
        }

        return true;
    }
}

<?php
declare(strict_types=1);

namespace Chess;

/**
 * Class PositionFactory
 */
class PositionFactory
{
    /**
     * Factory
     *
     * @return Position
     */
    public static function factory(): Position
    {
        $args = func_get_args();
        $pos = new Position();

        if (count($args) === 1) {
            if (is_string($args[0]) && strlen($args[0]) === 5) {
                return $pos->fromIntString(...$args);
            }

            if (is_string($args[0]) && strlen($args[0]) === 2) {
                return $pos->fromChessString(...$args);
            }

            if (is_array($args[0]) && is_int($args[0][0]) && is_int($args[0][1])) {
                return $pos->fromIntArray(...$args);
            }
        }

        if (count($args) === 2
            && is_int($args[0])
            && is_int($args[1])
        ) {
            return $pos->fromInt(...$args);
        }


        return $pos;
    }

    /**
     * @param \Chess\Position $from
     * @param \Chess\Position $to
     *
     * @return array
     */
    public static function lineFromTo(Position $from, Position $to): array
    {
        return [];
    }
}

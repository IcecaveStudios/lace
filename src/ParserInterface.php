<?php
namespace Icecave\Lace;

use InvalidArgumentException;

interface ParserInterface
{
    /**
     * Parse a DSN.
     *
     * The return value may differ based on the type of DSN being parsed.
     *
     * @param string $dsn The DSN to parse.
     *
     * @return mixed The data parsed from the DSN.
     * @throws InvalidArgumentException if the DSN could not be parsed.
     */
    public function parse($dsn);
}

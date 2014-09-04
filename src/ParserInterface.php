<?php
namespace Icecave\Lace;

use Icecave\Lace\Handler\HandlerInterface;
use InvalidArgumentException;

interface ParserInterface
{
    /**
     * Parse a DSN.
     *
     * The return value may differ based on the type of DSN being parsed.
     *
     * @param string                $dsn      The DSN to parse.
     * @param HandlerInterface|null &$handler Assigned the handler that parsed the DSN.
     *
     * @return mixed                    The data parsed from the DSN.
     * @throws InvalidArgumentException if the DSN could not be parsed.
     */
    public function parse($dsn, HandlerInterface &$handler = null);
}

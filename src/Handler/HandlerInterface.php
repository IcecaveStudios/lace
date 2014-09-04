<?php
namespace Icecave\Lace\Handler;

use InvalidArgumentException;

interface HandlerInterface
{
    /**
     * Check if this handler is responisble for parsing the given DSN.
     *
     * @param string $dsn   The DSN to parse.
     * @param mixed  &$data Can be assigned data that is passed to parse().
     *
     * @return boolean True if this handler should parse the given DSN.
     */
    public function supports($dsn, &$data = null);

    /**
     * Parse a DSN.
     *
     * The return value may differ based on the type of DSN being parsed.
     *
     * @param string $dsn  The DSN to parse.
     * @param mixed  $data The data produced by the supports() method, if any.
     *
     * @return mixed                    The data parsed from the DSN.
     * @throws InvalidArgumentException if the DSN could not be parsed.
     */
    public function parse($dsn, $data = null);
}

<?php
namespace Icecave\Lace;

use InvalidArgumentException;
use SplObjectStorage;

trait ParserTrait
{
    /**
     * Add a handler to the parser.
     *
     * @param HandlerInterface $handler The handler to add.
     */
    public function addHandler(HandlerInterface $handler)
    {
        if (null === $this->handlers) {
            $this->handlers = new SplObjectStorage;
        }

        $this->handlers->attach($handler);
    }

    /**
     * Remove a handler from the parser.
     *
     * @param HandlerInterface $handler The handler to remove.
     */
    public function removeHandler(HandlerInterface $handler)
    {
        if ($this->handlers) {
            $this->handlers->detach($handler);
        }
    }

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
    public function parse($dsn, HandlerInterface &$handler = null)
    {
        foreach ($this->handlers as $potentialHandler) {
            $data = null;
            if ($potentialHandler->supports($dsn, $data)) {
                $handler = $potentialHandler;

                return $handler->parse($dsn, $data);
            }
        }

        throw new InvalidArgumentException(
            'No handler could be found to parse DSN "' . $dsn . '".'
        );
    }

    private $handlers;
}

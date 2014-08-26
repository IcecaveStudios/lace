<?php
namespace Icecave\Lace\Handler;

use InvalidArgumentException;

class SqliteHandler implements HandlerInterface
{
    use ConnectionOptionsHandlerTrait;

    /**
     * Get an array of preg patterns that match the valid URI schemes for this
     * handler.
     *
     * @return array<string>
     */
    protected function uriSchemePatterns()
    {
        return ['/^sqlite$/i'];
    }

    /**
     * Get the name of the Doctrine driver to use for DSNs parsed by this
     * handler.
     *
     * @return string
     */
    protected function driverName()
    {
        return 'pdo_sqlite';
    }

    /**
     * Populate the connection options array with data from the DSN.
     *
     * @param array &$connectionOptions The connection options array.
     * @param string $dsn The DSN being parsed.
     * @param mixed $data The data produced by the supports() method, if any.
     */
    protected function populateConnectionOptions(array &$connectionOptions, $dsn, $data)
    {
        if ($data['host'] === 'memory') {
            $connectionOptions['memory'] = true;
        } else {
            $connectionOptions['memory'] = false;
            $connectionOptions['path'] = $data['path'];
        }
    }
}

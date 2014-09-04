<?php
namespace Icecave\Lace\Handler;

class MySqlHandler implements HandlerInterface
{
    const DEFAULT_PORT = 3306;

    use ConnectionOptionsHandlerTrait;

    /**
     * Get an array of preg patterns that match the valid URI schemes for this
     * handler.
     *
     * @return array<string>
     */
    protected function uriSchemePatterns()
    {
        return ['/^mysql$/i'];
    }

    /**
     * Get the name of the Doctrine driver to use for DSNs parsed by this
     * handler.
     *
     * @return string
     */
    protected function driverName()
    {
        return 'pdo_mysql';
    }

    /**
     * Populate the connection options array with data from the DSN.
     *
     * @param array  &$connectionOptions The connection options array.
     * @param string $dsn                The DSN being parsed.
     * @param mixed  $data               The data produced by the supports() method, if any.
     */
    protected function populateConnectionOptions(array &$connectionOptions, $dsn, $data)
    {
        $this->populateCommonConnectionOptions(
            $connectionOptions,
            $data,
            self::DEFAULT_PORT
        );
    }
}

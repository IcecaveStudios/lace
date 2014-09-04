<?php
namespace Icecave\Lace\Handler\Database;

class SqliteHandler implements DatabaseHandlerInterface
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
     * @param array  &$connectionOptions The connection options array.
     * @param string $dsn                The DSN being parsed.
     * @param mixed  $data               The data produced by the supports() method, if any.
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

    /**
     * Visit this node with the given visitor.
     *
     * @param DatabaseVisitorInterface $visitor
     *
     * @return mixed
     */
    public function accept(DatabaseVisitorInterface $visitor)
    {
        $arguments = func_get_args();
        $arguments[0] = $this;

        return call_user_func_array(
            [$visitor, 'visitSqliteHandler'],
            $arguments
        );
    }
}

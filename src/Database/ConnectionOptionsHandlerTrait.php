<?php
namespace Icecave\Lace\Database;

use InvalidArgumentException;

trait ConnectionOptionsHandlerTrait
{
    /**
     * Check if this handler is responisble for parsing the given DSN.
     *
     * @param string $dsn   The DSN to parse.
     * @param mixed  &$data Can be assigned data that is passed to parse().
     *
     * @return boolean True if this handler should parse the given DSN.
     */
    public function supports($dsn, &$data = null)
    {
        $data = parse_url($dsn);

        if (!isset($data['scheme'])) {
            return false;
        }

        foreach ($this->uriSchemePatterns() as $pattern) {
            if (preg_match($pattern, $data['scheme'])) {
                return true;
            }
        }

        return false;
    }

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
    public function parse($dsn, $data = null)
    {
        $connectionOptions = [
            'driver' => $this->driverName(),
        ];

        if (isset($data['user'])) {
            $connectionOptions['user'] = $data['user'];
        }

        if (isset($data['pass'])) {
            $connectionOptions['password'] = $data['pass'];
        }

        $this->populateConnectionOptions($connectionOptions, $dsn, $data);

        return $connectionOptions;
    }

    /**
     * Get an array of preg patterns that match the valid URI schemes for this
     * handler.
     *
     * @return array<string>
     */
    abstract protected function uriSchemePatterns();

    /**
     * Get the name of the Doctrine driver to use for DSNs parsed by this
     * handler.
     *
     * @return string
     */
    abstract protected function driverName();

    /**
     * Populate the connection options array with data from the DSN.
     *
     * @param array  &$connectionOptions The connection options array.
     * @param string $dsn                The DSN being parsed.
     * @param mixed  $data               The data produced by the supports() method, if any.
     */
    abstract protected function populateConnectionOptions(array &$connectionOptions, $dsn, $data);

    /**
     * Populate the connection options array with data from the DSN.
     *
     * @param array   &$connectionOptions The connection options array.
     * @param mixed   $data               The data produced by the supports() method, if any.
     * @param integer $defaultPort        The default port to use.
     * @param string  $defaultHostname    The default hostname to use.
     */
    protected function populateCommonConnectionOptions(
        array &$connectionOptions,
        $data,
        $defaultPort
    ) {
        $connectionOptions['host'] = $data['host'];

        if (isset($data['port'])) {
            $connectionOptions['port'] = intval($data['port']);
        } else {
            $connectionOptions['port'] = $defaultPort;
        }

        if (isset($data['path'])) {
            $connectionOptions['dbname'] = trim($data['path'], '/');
        }
    }
}

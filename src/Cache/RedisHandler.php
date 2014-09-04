<?php
namespace Icecave\Lace\Cache;

use InvalidArgumentException;

class RedisHandler implements CacheHandlerInterface
{
    const DEFAULT_HOSTNAME = 'localhost';
    const DEFAULT_PORT = 6379;

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

        return isset($data['scheme'])
            && strcasecmp($data['scheme'], 'redis') === 0;
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
        $connectionOptions = [];

        $connectionOptions['host'] = $data['host'];

        if (isset($data['port'])) {
            $connectionOptions['port'] = intval($data['port']);
        } else {
            $connectionOptions['port'] = self::DEFAULT_PORT;
        }

        if (isset($data['pass'])) {
            $connectionOptions['password'] = $data['pass'];
        }

        return $connectionOptions;
    }

    /**
     * Visit this node with the given visitor.
     *
     * @param CacheVisitorInterface $visitor
     *
     * @return mixed
     */
    public function accept(CacheVisitorInterface $visitor)
    {
        $arguments = func_get_args();
        $arguments[0] = $this;

        return call_user_func_array(
            [$visitor, 'visitRedisHandler'],
            $arguments
        );
    }
}

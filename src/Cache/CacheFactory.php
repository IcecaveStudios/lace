<?php
namespace Icecave\Lace\Cache;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\RedisCache;
use Icecave\Isolator\IsolatorTrait;
use Redis;

/**
 * Requires doctrine/cache package.
 */
class CacheFactory implements CacheFactoryInterface, CacheVisitorInterface
{
    use IsolatorTrait;

    public function __construct(CacheDsnParser $parser = null)
    {
        if (null === $parser) {
            $parser = new CacheDsnParser();
        }

        $this->parser = $parser;
    }

    /**
     * Create a cache provider.
     *
     * @param string      $dsn       The cache DSN.
     * @param string|null $namespace The cache namespace to use, if supported by the underlying driver.
     *
     * @return Cache
     */
    public function create($dsn, $namespace = null)
    {
        $handler = null;
        $this->connectionOptions = $this->parser->parse($dsn, $handler);
        $this->namespace = $namespace;

        $cache = $handler->accept($this);

        $this->connectionOptions = null;
        $this->namespace = null;

        return $cache;
    }

    /**
     * Visit the given handler.
     *
     * @internal
     *
     * @param RedisHandler $handler
     * @param string|null  $namespace
     * @param array        $connectionOptions
     *
     * @return mixed
     */
    public function visitRedisHandler(RedisHandler $handler)
    {
        $connection = $this
            ->isolator()
            ->new(Redis::class);

        $connection->connect(
            $this->connectionOptions['host'],
            $this->connectionOptions['port']
        );

        if (isset($this->connectionOptions['password'])) {
            $connection->auth(
                $this->connectionOptions['password']
            );
        }

        if ($this->namespace) {
            $connection->setOption(
                Redis::OPT_PREFIX,
                $this->namespace . ':'
            );
        }

        $cache = $this
            ->isolator()
            ->new(RedisCache::class);

        $cache->setRedis($connection);

        return $cache;
    }

    private $parser;
    private $connectionOptions;
    private $namespace;
}

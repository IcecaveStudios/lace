<?php
namespace Icecave\Lace\Cache;

/**
 * Create a cache provider from a DSN.
 */
interface CacheFactoryInterface
{
    /**
     * Create a cache provider.
     *
     * @param string      $dsn       The cache DSN.
     * @param string|null $namespace The cache namespace to use, if supported by the underlying driver.
     *
     * @return Cache
     */
    public function create($dsn, $namespace = null);
}

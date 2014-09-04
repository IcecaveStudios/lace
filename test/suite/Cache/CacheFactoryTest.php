<?php
namespace Icecave\Lace\Cache;

// use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\RedisCache;
use Icecave\Isolator\Isolator;
use Phake;
use PHPUnit_Framework_TestCase;
use Redis;

class CacheFactoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->connection = Phake::mock(Redis::CLASS);
        $this->cache = Phake::mock(RedisCache::CLASS);
        $this->isolator = Phake::mock(Isolator::CLASS);
        $this->factory = new CacheFactory;
        $this->factory->setIsolator($this->isolator);

        Phake::when($this->isolator)
            ->new(Redis::CLASS)
            ->thenReturn($this->connection);

        Phake::when($this->isolator)
            ->new(RedisCache::CLASS)
            ->thenReturn($this->cache);
    }

    /**
     * @requires extension redis
     */
    public function testCreateRedis()
    {
        $dsn = 'redis://hostname';

        $cache = $this->factory->create($dsn);

        Phake::inOrder(
            Phake::verify($this->isolator)->new(Redis::CLASS),
            Phake::verify($this->connection)->connect('hostname', 6379),
            Phake::verify($this->isolator)->new(RedisCache::CLASS),
            Phake::verify($this->cache)->setRedis($this->connection)
        );

        Phake::verify($this->connection, Phake::never())->auth(Phake::anyParameters());
        Phake::verify($this->connection, Phake::never())->setOption(Phake::anyParameters());

        $this->assertSame(
            $this->cache,
            $cache
        );
    }

    /**
     * @requires extension redis
     */
    public function testCreateRedisWithAuth()
    {
        $dsn = 'redis://username:password@hostname:1234';

        $cache = $this->factory->create($dsn);

        Phake::inOrder(
            Phake::verify($this->isolator)->new(Redis::CLASS),
            Phake::verify($this->connection)->connect('hostname', 1234),
            Phake::verify($this->connection)->auth('password'),
            Phake::verify($this->isolator)->new(RedisCache::CLASS),
            Phake::verify($this->cache)->setRedis($this->connection)
        );

        Phake::verify($this->connection, Phake::never())->setOption(Phake::anyParameters());

        $this->assertSame(
            $this->cache,
            $cache
        );
    }

    /**
     * @requires extension redis
     */
    public function testCreateRedisWithNamespace()
    {
        $dsn = 'redis://hostname';

        $cache = $this->factory->create($dsn, 'my-namespace');

        Phake::inOrder(
            Phake::verify($this->isolator)->new(Redis::CLASS),
            Phake::verify($this->connection)->connect('hostname', 6379),
            Phake::verify($this->connection)->setOption(Redis::OPT_PREFIX, 'my-namespace:'),
            Phake::verify($this->isolator)->new(RedisCache::CLASS),
            Phake::verify($this->cache)->setRedis($this->connection)
        );

        Phake::verify($this->connection, Phake::never())->auth(Phake::anyParameters());

        $this->assertSame(
            $this->cache,
            $cache
        );
    }
}

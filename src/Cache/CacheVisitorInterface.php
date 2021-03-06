<?php
namespace Icecave\Lace\Cache;

interface CacheVisitorInterface
{
    /**
     * Visit the given handler.
     *
     * @param RedisHandler $handler
     *
     * @return mixed
     */
    public function visitRedisHandler(RedisHandler $handler);
}

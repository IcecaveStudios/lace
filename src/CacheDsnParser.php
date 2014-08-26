<?php
namespace Icecave\Lace;

/**
 * Parse a DSN into a connection options array describing a connection to a
 * cache driver.
 */
class CacheDsnParser implements ParserInterface
{
    use ParserTrait;

    public function __construct()
    {
        $this->addHandler(new Handler\RedisHandler);
    }
}

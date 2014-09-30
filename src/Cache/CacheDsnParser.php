<?php
namespace Icecave\Lace\Cache;

use Icecave\Lace\ParserInterface;
use Icecave\Lace\ParserTrait;

/**
 * Parse a DSN into a connection options array describing a connection to a
 * cache driver.
 */
class CacheDsnParser implements ParserInterface
{
    use ParserTrait;

    public function __construct()
    {
        $this->addHandler(new RedisHandler());
    }
}

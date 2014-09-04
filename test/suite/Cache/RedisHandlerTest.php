<?php
namespace Icecave\Lace\Cache;

use Phake;
use PHPUnit_Framework_TestCase;

class RedisHandlerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->visitor = Phake::mock(CacheVisitorInterface::CLASS);
        $this->handler = new RedisHandler;
    }

    public function testAccept()
    {
        Phake::when($this->visitor)
            ->visitRedisHandler(Phake::anyParameters())
            ->thenReturn('<result>');

        $result = $this->handler->accept($this->visitor, 1, 2, 3);

        Phake::verify($this->visitor)->visitRedisHandler($this->handler, 1, 2, 3);

        $this->assertSame(
            '<result>',
            $result
        );
    }
}

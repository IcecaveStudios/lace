<?php
namespace Icecave\Lace\Cache;

use PHPUnit_Framework_TestCase;

/**
 * @covers Icecave\Lace\ParserTrait
 * @covers Icecave\Lace\Cache\CacheDsnParser
 * @covers Icecave\Lace\Cache\RedisHandler
 */
class CacheDsnParserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parser = new CacheDsnParser;
    }

    /**
     * @dataProvider parseTestVectors
     */
    public function testParse($dsn, $connectionOptions)
    {
        $this->assertEquals(
            $connectionOptions,
            $this->parser->parse($dsn)
        );
    }

    public function testParseFailure()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'No handler could be found to parse DSN "<invalid>".'
        );

        $this->parser->parse('<invalid>');
    }

    public function parseTestVectors()
    {
        return [
            [
                'redis://hostname',
                [
                    'host' => 'hostname',
                    'port' => 6379,
                ],
            ],
            [
                'redis://username:password@hostname:1234',
                [
                    'host' => 'hostname',
                    'port' => 1234,
                    'password' => 'password',
                ],
            ],
        ];
    }
}

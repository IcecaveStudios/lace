<?php
namespace Icecave\Lace\Database;

use PHPUnit_Framework_TestCase;

/**
 * @covers Icecave\Lace\ParserTrait
 * @covers Icecave\Lace\Database\DatabaseDsnParser
 * @covers Icecave\Lace\Database\ConnectionOptionsHandlerTrait
 * @covers Icecave\Lace\Database\MySqlHandler
 * @covers Icecave\Lace\Database\PostgresHandler
 * @covers Icecave\Lace\Database\SqliteHandler
 */
class DatabaseDsnParserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parser = new DatabaseDsnParser();
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
                'postgres://hostname',
                [
                    'driver' => 'pdo_pgsql',
                    'host' => 'hostname',
                    'port' => 5432,
                ],
            ],
            [
                'postgres://username:password@hostname:1234/database',
                [
                    'driver' => 'pdo_pgsql',
                    'user' => 'username',
                    'password' => 'password',
                    'host' => 'hostname',
                    'port' => 1234,
                    'dbname' => 'database',
                ],
            ],
            [
                'postgresql://username:password@hostname:1234/database',
                [
                    'driver' => 'pdo_pgsql',
                    'user' => 'username',
                    'password' => 'password',
                    'host' => 'hostname',
                    'port' => 1234,
                    'dbname' => 'database',
                ],
            ],
            [
                'mysql://hostname',
                [
                    'driver' => 'pdo_mysql',
                    'host' => 'hostname',
                    'port' => 3306,
                ],
            ],
            [
                'mysql://username:password@hostname:1234/database',
                [
                    'driver' => 'pdo_mysql',
                    'user' => 'username',
                    'password' => 'password',
                    'host' => 'hostname',
                    'port' => 1234,
                    'dbname' => 'database',
                ],
            ],
            [
                'sqlite://memory',
                [
                    'driver' => 'pdo_sqlite',
                    'memory' => true,
                ],
            ],
            [
                'sqlite://username:password@memory',
                [
                    'driver' => 'pdo_sqlite',
                    'memory' => true,
                    'user' => 'username',
                    'password' => 'password',
                ],
            ],
            [
                'sqlite://username:password@file/path/to/file.sq3',
                [
                    'driver' => 'pdo_sqlite',
                    'memory' => false,
                    'user' => 'username',
                    'password' => 'password',
                    'path' => '/path/to/file.sq3',
                ],
            ],
        ];
    }
}

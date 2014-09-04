<?php
namespace Icecave\Lace\Handler\Database;

use Phake;
use PHPUnit_Framework_TestCase;

class PostgresHandlerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->visitor = Phake::mock(DatabaseVisitorInterface::CLASS);
        $this->handler = new PostgresHandler;
    }

    public function testAccept()
    {
        Phake::when($this->visitor)
            ->visitPostgresHandler(Phake::anyParameters())
            ->thenReturn('<result>');

        $result = $this->handler->accept($this->visitor, 1, 2, 3);

        Phake::verify($this->visitor)->visitPostgresHandler($this->handler, 1, 2, 3);

        $this->assertSame(
            '<result>',
            $result
        );
    }
}

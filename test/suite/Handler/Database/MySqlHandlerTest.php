<?php
namespace Icecave\Lace\Handler\Database;

use Phake;
use PHPUnit_Framework_TestCase;

class MySqlHandlerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->visitor = Phake::mock(DatabaseVisitorInterface::CLASS);
        $this->handler = new MySqlHandler;
    }

    public function testAccept()
    {
        Phake::when($this->visitor)
            ->visitMySqlHandler(Phake::anyParameters())
            ->thenReturn('<result>');

        $result = $this->handler->accept($this->visitor, 1, 2, 3);

        Phake::verify($this->visitor)->visitMySqlHandler($this->handler, 1, 2, 3);

        $this->assertSame(
            '<result>',
            $result
        );
    }
}

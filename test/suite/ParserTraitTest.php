<?php
namespace Icecave\Lace;

use Phake;
use PHPUnit_Framework_TestCase;

/**
 * @covers Icecave\Lace\ParserTrait
 */
class ParserTraitTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->handler1 = Phake::mock(HandlerInterface::CLASS);
        $this->handler2 = Phake::mock(HandlerInterface::CLASS);

        Phake::when($this->handler2)
            ->supports('<dsn>', Phake::setReference('<data>'))
            ->thenReturn(true);

        Phake::when($this->handler2)
            ->parse(Phake::anyParameters())
            ->thenReturn('<result>');

        $this->parser = $this->getObjectForTrait(ParserTrait::CLASS);
    }

    public function testParse()
    {
        $this->parser->addHandler($this->handler1);
        $this->parser->addHandler($this->handler2);

        $this->assertSame(
            '<result>',
            $this->parser->parse('<dsn>')
        );

        Phake::inOrder(
            Phake::verify($this->handler1)->supports('<dsn>', null),
            Phake::verify($this->handler2)->supports('<dsn>', null),
            Phake::verify($this->handler2)->parse('<dsn>', '<data>')
        );

        Phake::verify($this->handler1, Phake::never())->parse(Phake::anyParameters());
    }

    public function testParseWithHandlerArgument()
    {
        $handler = null;

        $this->parser->addHandler($this->handler1);
        $this->parser->addHandler($this->handler2);

        $this->assertSame(
            '<result>',
            $this->parser->parse('<dsn>', $handler)
        );

        Phake::inOrder(
            Phake::verify($this->handler1)->supports('<dsn>', null),
            Phake::verify($this->handler2)->supports('<dsn>', null),
            Phake::verify($this->handler2)->parse('<dsn>', '<data>')
        );

        $this->assertSame(
            $this->handler2,
            $handler
        );

        Phake::verify($this->handler1, Phake::never())->parse(Phake::anyParameters());
    }

    public function testAddAndRemoveHandlers()
    {
        $this->parser->addHandler($this->handler1);
        $this->parser->addHandler($this->handler2);
        $this->parser->removeHandler($this->handler1);

        $this->assertSame(
            '<result>',
            $this->parser->parse('<dsn>')
        );

        Phake::verifyNoInteraction($this->handler1);
    }
}

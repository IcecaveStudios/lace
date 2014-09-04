<?php
namespace Icecave\Lace\Handler\Database;

use Icecave\Lace\Handler\HandlerInterface;

interface DatabaseHandlerInterface extends HandlerInterface
{
    /**
     * Visit this node with the given visitor.
     *
     * @param DatabaseVisitorInterface $visitor
     *
     * @return mixed
     */
    public function accept(DatabaseVisitorInterface $visitor);
}

<?php
namespace Icecave\Lace\Database;

use Icecave\Lace\HandlerInterface;

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

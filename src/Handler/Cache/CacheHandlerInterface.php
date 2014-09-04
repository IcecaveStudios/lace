<?php
namespace Icecave\Lace\Handler\Cache;

use Icecave\Lace\Handler\HandlerInterface;

interface CacheHandlerInterface extends HandlerInterface
{
    /**
     * Visit this node with the given visitor.
     *
     * @param CacheVisitorInterface $visitor
     *
     * @return mixed
     */
    public function accept(CacheVisitorInterface $visitor);
}

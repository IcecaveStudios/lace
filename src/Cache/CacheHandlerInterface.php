<?php
namespace Icecave\Lace\Cache;

use Icecave\Lace\HandlerInterface;

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

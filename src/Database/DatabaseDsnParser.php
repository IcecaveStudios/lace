<?php
namespace Icecave\Lace\Database;

use Icecave\Lace\ParserInterface;
use Icecave\Lace\ParserTrait;

/**
 * Parse a DSN into a Doctrine connection options array describing a connection
 * to a database.
 */
class DatabaseDsnParser implements ParserInterface
{
    use ParserTrait;

    public function __construct()
    {
        $this->addHandler(new MySqlHandler());
        $this->addHandler(new PostgresHandler());
        $this->addHandler(new SqliteHandler());
    }
}

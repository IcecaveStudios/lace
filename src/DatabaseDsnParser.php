<?php
namespace Icecave\Lace;

/**
 * Parse a DSN into a Doctrine connection options array describing a connection
 * to a database.
 */
class DatabaseDsnParser implements ParserInterface
{
    use ParserTrait;

    public function __construct()
    {
        $this->addHandler(new Handler\Database\MySqlHandler);
        $this->addHandler(new Handler\Database\PostgresHandler);
        $this->addHandler(new Handler\Database\SqliteHandler);
    }
}

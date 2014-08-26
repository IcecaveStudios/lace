# Lace

[![Build Status]](https://travis-ci.org/IcecaveStudios/lace)
[![Test Coverage]](https://coveralls.io/r/IcecaveStudios/lace?branch=develop)
[![SemVer]](http://semver.org)

**Lace** is a DSN parser for Doctrine database and cache connections.

* Install via [Composer](http://getcomposer.org) package [icecave/lace](https://packagist.org/packages/icecave/lace)
* Read the [API documentation](http://icecavestudios.github.io/lace/artifacts/documentation/api/)

**Lace** was initially created to parse DSN URIs stored in environment variables
on the Heroku platform.

## Examples

### Database DSN

The `DatabaseDsnParser` class is responsible for parsing database DSNs into arrays compatible with
[Doctrine DBAL's driver manager](http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html).

The following drivers are currently supported:
 * PostgreSQL
 * MySQL
 * SQLite

```php
use Icecave\Lace\DatabaseDsnParser;

$parser = new DatabaseDsnParser;
$options = $parser->parse('postgres://username:password@hostname:1234/database');

print_r($options);
```

```
Array
(
    [driver] => pdo_pgsql
    [user] => username
    [password] => password
    [host] => hostname
    [port] => 1234
    [dbname] => database
)
```

### Cache DSN

The `CacheDsnParser` class is responsible for parsing DSNs into arrays with the necessary information.

The following drivers are currently supported:
 * Redis

```php
use Icecave\Lace\CacheDsnParser;

$parser = new CacheDsnParser;
$options = $parser->parse('redis://username:password@hostname:1234');

print_r($options);
```

```
Array
(
    [host] => hostname
    [port] => 1234
    [password] => password
)
```

<!-- references -->
[Build Status]: http://img.shields.io/travis/IcecaveStudios/lace/develop.svg
[Test Coverage]: http://img.shields.io/coveralls/IcecaveStudios/lace/develop.svg
[SemVer]: http://img.shields.io/:semver-0.0.0-red.svg

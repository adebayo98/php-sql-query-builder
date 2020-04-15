# Documentation

#### Create a sql query builder

To start create and configure if necessary a query builder.

```php
<?php

require_once 'vendor/autoload.php';
use Adebayo\QueryBuilder\QueryBuilder;

$qb = new QueryBuilder();

```

#### INSERT INTO

```php
<?php
// ...

// First way
$qb->insert('user')
   ->value('uuid', '110e8400-e29b-11d4-a716-446655440000')
   ->value('first_name', 'Adebayo')
   ->value('age', 21)
;
// Second way
$qb->insert('user')
   ->values([
       'uuid' => '110e8400-e29b-11d4-a716-446655440000',
       'last_name' => 'HOUNTONDJI',
       'age' => 21
   ])
;

$sql = $qb->__toString();

// The value of $sql is "INSERT INTO user (uuid, last_name, age) VALUES ('110e8400-e29b-11d4-a716-446655440000', 'HOUNTONDJI', '21')"

```


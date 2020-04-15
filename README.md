# Documentation

### Summary
+ [Installation](#install)
+ [Get started](#get-started)
+ [Insert](#insert-into)

<a name="install"></a>
#### Installation

```bash
composer require adebayo/php-query-builder
```

<a name="get-started"></a>
#### Create a sql query builder

To start, create an instance of QueryBuilder. This class contains all the methods necessary to 
build sql requests for a lot of operations such as "INSERT INTO", "UPDATE", "SELECT" and others. 
You can also **add options** to it in constructor to define for example the database driver on which the 
queries will be executed etc ... 
(All options are defined in the php doc of the contructor of **Adebayo\QueryBuilder\Common** class).

```php
<?php

require_once 'vendor/autoload.php';
use Adebayo\QueryBuilder\QueryBuilder;

$qb = new QueryBuilder();

```

<a name="insert-into"></a>
#### Create a sql query to insert data into a database


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

echo $qb->__toString();
// INSERT INTO user (uuid, last_name, age) VALUES ('110e8400-e29b-11d4-a716-446655440000', 'HOUNTONDJI', '21')

```


#### UPDATE

#### DELETE

#### SELECT



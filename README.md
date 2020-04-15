# Documentation

This library is under development

## Summary
+ [Installation](#install)
+ [Get started](#get-started)
+ [Insert](#insert-into)
+ [Select](#select)
+ [Update](#update)
+ [Delete](#delete)

<a name="install"></a>
### Installation

```bash
composer require adebayo/php-query-builder
```

<a name="get-started"></a>
### Build a sql query builder

To start, create an instance of QueryBuilder. This class contains all the methods necessary to 
build sql query for a lot of operations such as "INSERT INTO", "UPDATE", "SELECT" and others. 
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
### Build a sql query to insert data into a database

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
       'first_name' => 'Adebayo',
       'age' => 21
   ])
;

echo $qb->__toString();
// INSERT INTO user (uuid, first_name, age) VALUES ('110e8400-e29b-11d4-a716-446655440000', 'Adebayo', '21')

```

<a name="prepare-query"></a>
If you want to create a query for a prepared request with named parameters you can proceed as below. 
The protocol is the same for all operations.

```php
<?php
// ...

$qb->insert('user')
   ->value('uuid', '110e8400-e29b-11d4-a716-446655440000')
   ->value('first_name', 'Adebayo')
   ->value('age', 21)
   // Call method bind on qb instance. This method is available on all operations (delete, select ...)
   ->bind()
;

echo $qb->__toString();
// INSERT INTO user (uuid, first_name, age) VALUES (:v1, :v2, :v3)

print_r($qb->getValuesBind());

/*
Array
(
    [:v1] => 110e8400-e29b-11d4-a716-446655440000
    [:v2] => Adebayo
    [:v3] => 21
)

NB: getValuesBind() must be call after __toString() and when bind() is call on qb.
*/
```


<a name="select"></a>
#### SELECT
(loading ...)


<a name="update"></a>
### Build a sql query to update data into a database
```php
<?php
// ...

$qb->update('user')
   ->value('updated_at', '2020-04-15')
   ->where('last_name', '=', 'BEN')
   ->where('age', '<', 40)
   ->orWhere('last_name', '=', 'SIMMON')
;

echo $qb->__toString();
// UPDATE user SET updated_at = '2020-04-15' WHERE last_name = 'BEN', AND age < '40', OR last_name = 'SIMMON'

```

<a name="delete"></a>
#### DELETE
(loading ...)




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
### Build a sql query to insert data into database

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
   // Add method bind on qb. This method is available on all operations (delete, select ...)
   ->bind()
;

echo $qb->__toString();
// INSERT INTO user (uuid, first_name, age) VALUES (:user_uuid, :user_first_name, :user_age)

print_r($qb->getValuesBind());

/*
Array
(
    [:user_uuid] => 110e8400-e29b-11d4-a716-446655440000
    [:user_first_name] => Adebayo
    [:user_age] => 21
)
*/

```

<a name="select"></a>
#### SELECT

<a name="update"></a>
#### UPDATE

<a name="delete"></a>
#### DELETE



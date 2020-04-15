<?php

use Adebayo\QueryBuilder\QueryBuilder;

require_once '../vendor/autoload.php';

ini_set('display_errors', 1);

echo "<pre>";

$connection = new PDO("mysql:dbname=tasks;host=62.210.16.27;port=6069", "user", "adminpass1!");

$qb = (new QueryBuilder())
    ->insert('user')
    ->value('uuid', '110e8400-e29b-11d4-a716-446655440000')
    ->value('first_name', 'Adebayo')
    ->value('age', 21)
    // Call method bind on qb instance. This method is available on all operations (delete, select ...)
    ->bind()
;

echo $qb->__toString() . "\n";
print_r($qb->getValuesBind());
die;

$sth = $connection->prepare($qb->__toString());

foreach ($qb->getValuesBind() as $param => $value){
    $sth->bindValue($param, $value);
}
$sth->execute();



<?php

use Adebayo\QueryBuilder\QueryBuilder;

require_once '../vendor/autoload.php';

ini_set('display_errors', 1);

echo "<pre>";

$connection = new PDO("mysql:dbname=tasks;host=62.210.16.27;port=6069", "user", "adminpass1!");

$qb = (new QueryBuilder())
    ->insert('user')
    ->values([
        'uuid' => '110e8400-e29b-11d4-a716-446655440000',
        'last_name' => 'HOUNTONDJI',
        'age' => 21
    ])
    ->bind()
;

print_r($qb->__toString());
print_r($qb->getValuesBind());
die;

$sth = $connection->prepare($qb->__toString());
foreach ($qb->getValuesBind() as $item => $value){
    $sth->bindValue($item, $value);
}
$sth->execute();



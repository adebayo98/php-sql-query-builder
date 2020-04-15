<?php

use Adebayo\QueryBuilder\QueryBuilder;

require_once '../vendor/autoload.php';

ini_set('display_errors', 1);

echo "<pre>";

$connection = new PDO("mysql:dbname=tasks;host=62.210.16.27;port=6069", "user", "adminpass1!");

$qb = (new QueryBuilder())
    ->update('user')
    ->value('updated_at', '2020-04-15')
    ->where('last_name', '=', 'BEN')
    ->where('age', '<', 40)
    ->orWhere('last_name', '=', 'SIMMON')
;

echo $qb->__toString() . "\n";
print_r($qb->getValuesBind());
die;

$sth = $connection->prepare($qb->__toString());

foreach ($qb->getValuesBind() as $param => $value){
    $sth->bindValue($param, $value);
}
$sth->execute();



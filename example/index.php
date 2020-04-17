<?php

use Adebayo\QueryBuilder\QueryBuilder;
use Adebayo\QueryBuilder\Model\SubWhere;

require_once '../vendor/autoload.php';

ini_set('display_errors', 1);

echo "<pre>";
$connection = new PDO("mysql:dbname=tasks;host=62.210.16.27;port=6069", "user", "adminpass1!");

$qb = (new QueryBuilder())
    ->update('user')
    ->set('updated_at', date('Y-m-d'))
    ->where('age', '<', 40)
    ->orSubWhere(function (SubWhere $subWhere){
        $subWhere->where('is_admin', '=', true)
            ->orWhere('last_name', '=', 'SIMMON')
        ;
    })
    ->bind()
;

echo $qb->__toString() . "\n";
print_r($qb->getValuesBind());

$sth = $connection->prepare($qb->__toString());

foreach ($qb->getValuesBind() as $param => $value){
    $sth->bindValue($param, $value);
}

$sth->execute();



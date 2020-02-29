<?php

use Adebayo\QueryBuilder\QueryBuilder;
use Adebayo\QueryBuilder\Model\RelationColumn;
use Adebayo\QueryBuilder\Model\WhereGroup;

require_once '../vendor/autoload.php';

echo "<pre>";

$qb = QueryBuilder::select('article')
    ->addColumns('title')
    ->addColumnCollection('comment', 'article_id', 'id', function (RelationColumn $collectionColumn){
        return $collectionColumn->addColumns('id', 'content')
            ->setAlias('comments')
        ;
    });
;

print_r($qb->__toString());

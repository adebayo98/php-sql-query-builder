<?php

use Adebayo\QueryBuilder\QueryBuilder;

require_once '../vendor/autoload.php';

ini_set('display_errors', 1);

echo "<pre>";

$qb = QueryBuilder::select('article')
    ->whereInSubQuery('user_id', 'user', function (\Adebayo\QueryBuilder\Operation\Select $query){
        return $query->addColumns('id')
            ->where('is_active = 1')
            ;
    });

die($qb->__toString());


$dsn = 'mysql:dbname=php-sql-query-builder;host=62.210.16.27;port=6069';
$user = 'read-only';
$password = 'read-only-user';

try {
    $conn = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

$qb = QueryBuilder::select('article')
    ->addColumns('id', 'title', 'content')
    ->addColumnObject('user', 'id', 'user_id', function ($objectColumn){
        return $objectColumn->setAlias('author')
            ->addColumns('last_name', 'first_name')
            ->addColumnObject('address', 'user_id', 'id', function ($objectColumn){
                return $objectColumn->addColumns('country', 'city', 'street')
                    ->addColumnSubQuery('total_article_write', 'article', function ($query){
                        return $query->addColumns('COUNT(*)')->where('article.user_id = user.id');
                    });
            });
    })
    ->addColumnSubQuery('total_comment_count', 'comment', function ($query){
        return $query->addColumns('COUNT(*)')->where('comment.article_id = article.id');
    })
;

$smtp = $conn->prepare($qb->__toString());
$smtp->execute();

foreach ($smtp->fetchAll(PDO::FETCH_ASSOC) as $key => $value){
    $value['author'] = json_decode($value['author'], true);
    print_r($value);
}

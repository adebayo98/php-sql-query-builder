<?php

use PHPUnit\Framework\TestCase;

use Adebayo\QueryBuilder\QueryBuilder;
use Adebayo\QueryBuilder\Model\RelationColumn;


class SelectTest extends TestCase
{

    public function testSelectAllFieldsAndLimitRows()
    {
        $sql = $this->prettify("SELECT * FROM article LIMIT 10");

        $qb = QueryBuilder::select('article')
            ->limit(10)
        ;
        $this->assertEquals($sql, $qb->__toString());
    }

    public function testSelectDistinct()
    {
        $sql = "SELECT DISTINCT last_name FROM user";

        $qb = QueryBuilder::select('user')
            ->addColumns('last_name')
            ->distinct()
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSelectCustomColumns()
    {
        $sql = "SELECT id, content, created_at, updated_at FROM article";

        $qb = QueryBuilder::select('article')
            ->addColumns('id', 'content', 'created_at', 'updated_at')
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSelectColumnsWithAlias()
    {
        $sql = "SELECT content AS main_content, created_at AS creation_date FROM article";

        $qb = QueryBuilder::select('article')
            ->addColumns('content AS main_content', ['created_at' => 'creation_date'])
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSelectWithWhereClause()
    {
        $sql = "SELECT * FROM article WHERE id > 1 OR (id > 4 AND id < 8)";

        $qb = QueryBuilder::select('article')
            ->where('id > 1')
            ->orWhereGroup(function ($groupWhere){
                return $groupWhere->where('id > 4')
                    ->Where('id < 8')
                    ;
            });
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }


    public function testSelectRelationColumn()
    {
        $addressSql = "(SELECT json_object('country', country, 'city', city, 'street', street) FROM address WHERE address.user_id = user.id LIMIT 1)";

        $sql = "
            SELECT 
            id, 
            title, 
            content,
            (SELECT json_object('last_name', last_name, 'first_name', first_name, 'address', {$addressSql}) FROM user WHERE user.id = article.user_id LIMIT 1) AS author
            FROM
            article
        ";

        $qb = QueryBuilder::select('article')
            ->addColumns('id', 'title', 'content')
            ->addColumnObject('user', 'id', 'user_id', function (RelationColumn $objectColumn){
                return $objectColumn->setAlias('author')
                    ->addColumns('last_name', 'first_name')
                    ->addColumnObject('address', 'user_id', 'id', function (RelationColumn $objectColumn){
                        return $objectColumn->addColumns('country', 'city', 'street');
                    });
            });

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    private function prettify(string $sql)
    {
        $sql = str_replace("\n", " ", $sql);
        $sql = preg_replace("# +#", " ", $sql);
        return trim($sql);
    }

}

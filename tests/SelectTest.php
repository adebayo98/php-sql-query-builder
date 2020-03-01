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

    public function testSelectWithSqCache()
    {
        $sql = $this->prettify("SELECT SQL_CACHE * FROM article");

        $qb = QueryBuilder::select('article')
            ->sqlCache()
        ;
        $this->assertEquals($sql, $qb->__toString());
    }

    public function testSelectWithSqlNoCache()
    {
        $sql = $this->prettify("SELECT SQL_NO_CACHE * FROM article");

        $qb = QueryBuilder::select('article')
            ->sqlNoCache()
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
        $sql = "SELECT * FROM article WHERE tag_id IS NOT NULL OR (id > 4 AND id < 8) AND user_id IN (1, 2)";

        $qb = QueryBuilder::select('article')
            ->where('tag_id IS NOT NULL')
            ->orWhereGroup(function ($groupWhere){
                return $groupWhere->where('id > 4')
                    ->Where('id < 8')
                ;
            })
            ->whereIn('user_id', [1, 2])
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testWhereInSubQuery()
    {
        $sql = "SELECT * FROM article WHERE user_id IN (SELECT id FROM user WHERE is_active = 1)";

        $qb = QueryBuilder::select('article')
            ->whereInSubQuery('user_id', 'user', function ($query){
                return $query->addColumns('id')
                    ->where('is_active = 1')
                ;
            });
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSubQueryColumn()
    {
        $sql = "SELECT CONCAT(last_name, ' ', first_name) AS full_name, (SELECT COUNT(*) FROM comment WHERE comment.user_id = user.id) AS comment_count FROM user";

        $qb = QueryBuilder::select('user')
            ->addColumns("CONCAT(last_name, ' ', first_name) AS full_name")
            ->addColumnSubQuery('comment_count', 'comment', function ($query){
                return $query
                    ->addColumns('COUNT(*)')
                    ->where('comment.user_id = user.id')
                ;
            });

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testGroupBy()
    {
        $sql = "SELECT user_id, COUNT(*) AS total_comment FROM comment GROUP BY user_id WITH ROLLUP";

        $qb = QueryBuilder::select('comment')
            ->addColumns('user_id', 'COUNT(*) AS total_comment')
            ->groupBy('user_id', true)
        ;
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

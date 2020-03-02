<?php

use PHPUnit\Framework\TestCase;

use Adebayo\QueryBuilder\QueryBuilder;
use Adebayo\QueryBuilder\Model\RelationColumn;


class SelectTest extends TestCase
{

    public function testSelectAllFieldsAndLimitRowsAnfOffset()
    {
        $sql = $this->prettify("SELECT * FROM article LIMIT 10 OFFSET 3");

        $qb = (new QueryBuilder())
            ->select('article')
            ->limit(10)
            ->offset(3)
        ;
        $this->assertEquals($sql, $qb->__toString());
    }

    public function testSelectWithSqCache()
    {
        $sql = $this->prettify("SELECT SQL_CACHE * FROM article");

        $qb = (new QueryBuilder())
            ->select('article')
            ->sqlCache()
        ;
        $this->assertEquals($sql, $qb->__toString());
    }

    public function testSelectWithSqlNoCache()
    {
        $sql = $this->prettify("SELECT SQL_NO_CACHE * FROM article");

        $qb = (new QueryBuilder())
            ->select('article')
            ->sqlNoCache()
        ;
        $this->assertEquals($sql, $qb->__toString());
    }

    public function testSelectDistinct()
    {
        $sql = "SELECT DISTINCT last_name FROM user";

        $qb = (new QueryBuilder())
            ->select('user')
            ->addColumn('last_name')
            ->distinct()
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSelectCustomColumns()
    {
        $sql = "SELECT id, content, created_at, updated_at FROM article";

        $qb = (new QueryBuilder())
            ->select('article')
            ->addColumn('id', 'content', 'created_at', 'updated_at')
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSelectColumnsWithAlias()
    {
        $sql = "SELECT content AS main_content, created_at AS creation_date FROM article";

        $qb = (new QueryBuilder())
            ->select('article')
            ->addColumn('content AS main_content', ['created_at' => 'creation_date'])
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testCaseClause()
    {
        $sql = "
            SELECT id, last_name,
            CASE
                WHEN age > 18 THEN 'major'
                WHEN age > 21 THEN 'adult'
                ELSE 'minor'
            END AS status
            FROM user
        ";

        $qb = (new QueryBuilder())
            ->select('user')
            ->addColumn('id', 'last_name')
            ->addColumnCase('status', function ($case){
                return $case->addWhen('age > 18', 'major')
                    ->addWhen('age > 21', 'adult')
                    ->else('minor')
                ;
            });

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSelectWithWhereClause()
    {
        $sql = "SELECT * FROM article WHERE tag_id IS NOT NULL OR (id > 4 AND id < 8) AND user_id IN (1, 2)";

        $qb = (new QueryBuilder())
            ->select('article')
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

    public function testHavingClause()
    {

        $sql = " SELECT client, SUM(tarif) FROM achat GROUP BY client HAVING SUM(tarif) > 40";

        $qb = (new QueryBuilder())
            ->select('achat')
            ->addColumn('client', 'SUM(tarif)')
            ->groupBy('client')
            ->having('SUM(tarif) > 40')
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testWhereInSubQuery()
    {
        $sql = "SELECT * FROM article WHERE user_id IN (SELECT id FROM user WHERE is_active = 1)";

        $qb = (new QueryBuilder())
            ->select('article')
            ->whereInSubQuery('user_id', 'user', function ($query){
                return $query->addColumn('id')
                    ->where('is_active = 1')
                ;
            });
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSubQueryColumn()
    {
        $sql = "SELECT CONCAT(last_name, ' ', first_name) AS full_name, (SELECT COUNT(*) FROM comment WHERE comment.user_id = user.id) AS comment_count FROM user";

        $qb = (new QueryBuilder())
            ->select('user')
            ->addColumn("CONCAT(last_name, ' ', first_name) AS full_name")
            ->addColumnSubQuery('comment_count', 'comment', function ($query){
                return $query
                    ->addColumn('COUNT(*)')
                    ->where('comment.user_id = user.id')
                ;
            });

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testUnion()
    {
        $sql = "SELECT * FROM article_fr UNION SELECT * FROM article_en";

        $qb = (new QueryBuilder())
            ->select('article_fr')
            ->addUnion('article_en');

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testUnionAll()
    {
        $sql = "SELECT * FROM article_fr UNION ALL SELECT * FROM article_en";

        $qb = (new QueryBuilder())
            ->select('article_fr')
            ->addUnionAll('article_en');

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testGroupBy()
    {
        $sql = "SELECT user_id, COUNT(*) AS total_comment FROM comment GROUP BY user_id WITH ROLLUP";

        $qb = (new QueryBuilder())
            ->select('comment')
            ->addColumn('user_id', 'COUNT(*) AS total_comment')
            ->groupBy('user_id', true)
        ;
        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testOrderBy()
    {
        $sql = "SELECT * FROM user ORDER BY last_name DESC, first_name ASC";

        $qb = (new QueryBuilder())
            ->select('user')
            ->addOrderBy('last_name', 'DESC')
            ->addOrderBy('first_name', 'ASC')
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

        $qb = (new QueryBuilder())
            ->select('article')
            ->addColumn('id', 'title', 'content')
            ->addColumnObject('user', 'id', 'user_id', function (RelationColumn $objectColumn){
                return $objectColumn->setAlias('author')
                    ->addColumn('last_name', 'first_name')
                    ->addColumnObject('address', 'user_id', 'id', function (RelationColumn $objectColumn){
                        return $objectColumn->addColumn('country', 'city', 'street');
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

<?php

use PHPUnit\Framework\TestCase;

use Adebayo\QueryBuilder\QueryBuilder;
use Adebayo\QueryBuilder\Operation\Select;
use Adebayo\QueryBuilder\Model\RelationColumn;


class SelectTest extends TestCase
{
    /**
     * @dataProvider sqlSelectAllFieldsAndLimitRows
     * @dataProvider sqlSelectCustomColumns
     * @dataProvider sqlSelectColumnsWithAlias
     * @dataProvider sqlSelectWithWhereClause
     * @dataProvider sqlSelectRelationColumn
     *
     * @param string $sqlQuery
     * @param Select $qb
     */
    public function testSelectQuery(string $sqlQuery, Select $qb)
    {
        $this->assertEquals($sqlQuery, $qb->__toString());
    }

    public function sqlSelectRelationColumn()
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
            ->addColumnObject('user', 'id', 'user_id', function ($objectColumn){
                return $objectColumn->setAlias('author')
                    ->addColumns('last_name', 'first_name')
                    ->addColumnObject('address', 'user_id', 'id', function ($objectColumn){
                        return $objectColumn->addColumns('country', 'city', 'street');
                    })
                ;
            })
        ;

        return [
            [$this->prettify($sql), $qb]
        ];
    }

    public function sqlSelectWithWhereClause()
    {
        $sql = "SELECT * FROM article WHERE id > 1 OR (id > 4 AND id < 8)";

        $qb = QueryBuilder::select('article')
            ->where('id > 1')
            ->orWhereGroup(function ($groupWhere){
                return $groupWhere->where('id > 4')
                    ->Where('id < 8')
                ;
            });

        return [
            [$this->prettify($sql), $qb]
        ];
    }

    public function sqlSelectColumnsWithAlias()
    {
        $sql = "SELECT content AS main_content, created_at AS creation_date FROM article";

        $qb = QueryBuilder::select('article')
            ->addColumns('content AS main_content', ['created_at' => 'creation_date'])
        ;

        return [
            [$this->prettify($sql), $qb]
        ];
    }

    public function sqlSelectCustomColumns()
    {
        $sql = "SELECT id, content, created_at, updated_at FROM article";

        $qb = QueryBuilder::select('article')
            ->addColumns('id', 'content', 'created_at', 'updated_at')
        ;

        return [
            [$this->prettify($sql), $qb]
        ];
    }

    public function sqlSelectAllFieldsAndLimitRows()
    {
        $sql = "SELECT * FROM article LIMIT 10";

        $qb = QueryBuilder::select('article')
            ->limit(10)
        ;

        return [
            [$this->prettify($sql), $qb]
        ];
    }

    private function prettify(string $sql)
    {
        $sql = str_replace("\n", " ", $sql);
        $sql = preg_replace("# +#", " ", $sql);
        return trim($sql);
    }

}

<?php

use PHPUnit\Framework\TestCase;

use Adebayo\QueryBuilder\QueryBuilder;
use Adebayo\QueryBuilder\Operation\Select;


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
        $sql = "
            SELECT 
            id, 
            title, 
            content,
            (SELECT json_object('last_name', last_name, 'first_name', first_name) FROM user WHERE user.id = article.user_id) AS author
            FROM
            article
        ";

        $qb = QueryBuilder::select('article')
            ->addColumns('id', 'title', 'content')
            ->addColumnObject('user', 'user_id', 'id', function ($objectColumn){
                return $objectColumn->addColumns('last_name', 'first_name')
                    ->setAlias('author')
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

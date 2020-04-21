<?php

use PHPUnit\Framework\TestCase;

use Adebayo\QueryBuilder\QueryBuilder;
use Adebayo\QueryBuilder\Model\Driver;


class SelectTest extends TestCase
{

    public function testSelectAll()
    {
        $sql = "SELECT * FROM user";

        $qb = (new QueryBuilder)
            ->select('user')
        ;

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    public function testSelectSpecificColumns()
    {
        $sql = "SELECT user.first_name, user.last_name FROM user";

        $qb = (new QueryBuilder)
            ->select('user')
            ->columns('first_name', 'last_name')
        ;

        $qb2 = (new QueryBuilder)
            ->select('user')
            ->columns('first_name')
            ->columns('last_name')
        ;

        $this->assertEquals($this->prettify($sql), $qb->__toString());
        $this->assertEquals($this->prettify($sql), $qb2->__toString());
    }

    public function testSelectColumnAlias()
    {
        $sql = "SELECT user.first_name AS pre, user.last_name AS nm FROM user";

        $qb = (new QueryBuilder)
            ->select('user')
            ->columns('first_name AS pre', ' last_name AS nm')
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

    public function testSelectWhere()
    {
        $sql = "SELECT user.first_name, user.last_name FROM user WHERE user.id = '1'";

        $qb = (new QueryBuilder())
            ->select('user')
            ->columns('first_name', 'last_name')
            ->where('id', '=', 1)
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

    public function testLimit()
    {
        // Postgre Sql
        $pgsqlSql = "SELECT * FROM user LIMIT 10 OFFSET 5";
        $pgsqlQb = (new QueryBuilder())
            ->select('user')
            ->limit(10)
            ->offset(5)
            ->setDriver(Driver::POSTGRSQL)
        ;

        $this->assertEquals($pgsqlSql, $pgsqlQb->__toString());

        // Mysql
        $mysql = "SELECT * FROM user LIMIT 5, 0";
        $mysqlQb = (new QueryBuilder())
            ->select('user')
            ->limit(5)
        ;

        $this->assertEquals($mysql, $mysqlQb->__toString());

        // Oracle
        /*$oracleSql = "SELECT * FROM user WHERE ROWNUM <= 10";
        $oracleQb = (new QueryBuilder())
            ->select('user')
            ->limit(10)
            ->setDriver(Driver::ORACLE)
        ;

        $this->assertEquals($oracleSql, $oracleQb->__toString());

        $oracleSql2 = "SELECT * FROM user WHERE user.id > '30' AND ROWNUM <= 10";
        $oracleQb2 = (new QueryBuilder())
            ->select('user')
            ->limit(10)
            ->where('id', '>', 30)
            ->setDriver(Driver::ORACLE)
        ;

        $this->assertEquals($oracleSql2, $oracleQb2->__toString());*/

        // Server sql
        /*$serverSql = "SELECT TOP 10 * FROM user";
        $serverSqlQb = (new QueryBuilder())
            ->select('user')
            ->limit(10)
            ->setDriver(Driver::SQLSERVER)
        ;

        $this->assertEquals($serverSql, $serverSqlQb->__toString());*/

    }

    private function prettify(string $sql)
    {
        $sql = str_replace("\n", " ", $sql);
        $sql = preg_replace("# +#", " ", $sql);
        return trim($sql);
    }

}

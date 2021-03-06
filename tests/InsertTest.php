<?php

use \PHPUnit\Framework\TestCase;
use Adebayo\QueryBuilder\QueryBuilder;



class InsertTest extends TestCase
{

    public function testInsert()
    {
        $sql = "INSERT INTO user (uuid, last_name, first_name, age, created_at) VALUES ('110e8400-e29b-11d4-a716-446655440000', 'HOUNTONDJI', 'Adebayo', '21', '2020-04-15')";

        $qb = (new QueryBuilder())
            ->insert('user')
            ->value('uuid', '110e8400-e29b-11d4-a716-446655440000')
            ->value('last_name', 'HOUNTONDJI')
            ->value('first_name', 'Adebayo')
            ->value('age', 21)
            ->value('created_at', '2020-04-15')
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

    public function testInsertWithBindMethod()
    {
        $sql = "INSERT INTO user (uuid, last_name, first_name, age, created_at) VALUES (:v1, :v2, :v3, :v4, :v5)";

        $uuid = '110e8400-e29b-11d4-a716-446655440000';
        $lastName = 'HOUNTONDJI';

        $qb = (new QueryBuilder())
            ->insert('user')
            ->value('uuid', $uuid)
            ->value('last_name', $lastName)
            ->value('first_name', 'Adebayo')
            ->value('age', 21)
            ->value('created_at', '2020-04-15')
            ->bind()
        ;

        $this->assertEquals($sql, $qb->__toString());
        $this->assertEquals($qb->getValuesBind()[':v1'], $uuid);
        $this->assertEquals($qb->getValuesBind()[':v2'], $lastName);
    }

    public function testInsertWithParamsInValue()
    {
        $sql = "INSERT INTO user (uuid, last_name, first_name, age) VALUES (:uuid, :last_name, :first_name, ?)";

        $qb = (new QueryBuilder())
            ->insert('user')
            ->value('uuid', ':uuid')
            ->value('last_name', ':last_name')
            ->value('first_name', ':first_name')
            ->value('age', '?')
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

}

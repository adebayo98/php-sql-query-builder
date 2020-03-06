<?php

use \PHPUnit\Framework\TestCase;
use Adebayo\QueryBuilder\QueryBuilder;



class InsertTest extends TestCase
{

    public function testInsert()
    {
        $sql = "INSERT INTO user (last_name, first_name, email, password, age) VALUES ('HOUNTONDJI', 'Adebayo', 'hountondjigodwill@gmail.com', 'password', 21)";

        $qb = (new QueryBuilder())
            ->insert('user')
            ->addValue('last_name', 'HOUNTONDJI')
            ->addValue('first_name', 'Adebayo')
            ->addValue('email', 'hountondjigodwill@gmail.com')
            ->addValue('password', 'password')
            ->addValue('age', 21)
        ;

        $this->assertEquals($sql, $qb->__toString());

    }

}

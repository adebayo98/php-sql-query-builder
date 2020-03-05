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
            ->addData('last_name', 'HOUNTONDJI')
            ->addData('first_name', 'Adebayo')
            ->addData('email', 'hountondjigodwill@gmail.com')
            ->addData('password', 'password')
            ->addData('age', 21)
        ;

        $this->assertEquals($sql, $qb->__toString());

    }

}

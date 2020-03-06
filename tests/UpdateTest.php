<?php

use PHPUnit\Framework\TestCase;
use Adebayo\QueryBuilder\QueryBuilder;


class UpdateTest extends TestCase
{

    public function testUpdate()
    {
        $sql = "UPDATE user SET first_name = 'Godwill' WHERE user.id = 1";

        $qb = (new QueryBuilder())
            ->update('user')
            ->changeValue('first_name', 'Godwill')
            ->where('user.id = 1')
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

}

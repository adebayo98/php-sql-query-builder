<?php

use PHPUnit\Framework\TestCase;
use Adebayo\QueryBuilder\QueryBuilder;


class UpdateTest extends TestCase
{

    public function testUpdate()
    {
        $sql = 'UPDATE user SET first_name = "Godwill" WHERE user.uuid = "110e8400-e29b-11d4-a716-446655440000"';

        $qb = (new QueryBuilder())
            ->update('user')
            ->value('first_name', 'Godwill')
            ->where('user.id = 110e8400-e29b-11d4-a716-446655440000')
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

}

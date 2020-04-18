<?php

use PHPUnit\Framework\TestCase;
use Adebayo\QueryBuilder\QueryBuilder;


class UpdateTest extends TestCase
{

    public function testUpdate()
    {
        $sql = "UPDATE user SET first_name = 'Godwill' WHERE user.uuid = '110e8400-e29b-11d4-a716-446655440000'";

        $qb = (new QueryBuilder())
            ->update('user')
            ->set('first_name', 'Godwill')
            ->where('uuid', '=', '110e8400-e29b-11d4-a716-446655440000')
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

    public function testUpdateWithParam()
    {
        $sql = "UPDATE user SET updated_at = :v1 WHERE user.last_name = :v2 AND user.age < :v3 OR user.last_name = :v4";

        $qb = (new QueryBuilder())
            ->update('user')
            ->set('updated_at', '2020-04-15')
            ->where('last_name', '=', 'BEN')
            ->where('age', '<', 40)
            ->orWhere('last_name', '=', 'SIMMON')
            ->bind()
        ;

        $this->assertEquals($sql, $qb->__toString());
        $this->assertEquals($qb->getValuesBind()[':v1'], '2020-04-15');
        $this->assertEquals($qb->getValuesBind()[':v2'], 'BEN');
        $this->assertEquals($qb->getValuesBind()[':v3'], 40);
        $this->assertEquals($qb->getValuesBind()[':v4'], 'SIMMON');
    }

}

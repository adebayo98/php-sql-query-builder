<?php

use Adebayo\QueryBuilder\QueryBuilder;
use PHPUnit\Framework\TestCase;


class DeleteTest extends TestCase
{

    public function testDelete()
    {
        $sql = "DELETE FROM user WHERE user.id = '9fb3ea4a-84fc-11ea-a8f6-38f9d311b092'";

        $qb = (new QueryBuilder())
            ->delete('user')
            ->where('id', '=', '9fb3ea4a-84fc-11ea-a8f6-38f9d311b092')
        ;

        $this->assertEquals($sql, (string)$qb);
    }

}
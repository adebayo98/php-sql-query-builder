<?php

use PHPUnit\Framework\TestCase;

use Adebayo\QueryBuilder\QueryBuilder;


class SelectTest extends TestCase
{

    public function testSelectAll()
    {
        $sql = "SELECT * FROM client";

        $qb = (new QueryBuilder)
            ->select('client')
        ;

        $this->assertEquals($this->prettify($sql), $qb->__toString());
    }

    private function prettify(string $sql)
    {
        $sql = str_replace("\n", " ", $sql);
        $sql = preg_replace("# +#", " ", $sql);
        return trim($sql);
    }

}

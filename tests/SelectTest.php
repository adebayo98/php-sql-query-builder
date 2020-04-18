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

    public function testSelectSpecificColumns()
    {
        $sql = "SELECT client.prenom, client.nom FROM client";

        $qb = (new QueryBuilder)
            ->select('client')
            ->columns('prenom', 'nom')
        ;

        $qb2 = (new QueryBuilder)
            ->select('client')
            ->columns('prenom')
            ->columns('nom')
        ;

        $this->assertEquals($this->prettify($sql), $qb->__toString());
        $this->assertEquals($this->prettify($sql), $qb2->__toString());
    }


    private function prettify(string $sql)
    {
        $sql = str_replace("\n", " ", $sql);
        $sql = preg_replace("# +#", " ", $sql);
        return trim($sql);
    }

}

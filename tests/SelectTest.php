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

    public function testSelectColumnAlias()
    {
        $sql = "SELECT client.prenom AS pre, client.nom AS nm FROM client";

        $qb = (new QueryBuilder)
            ->select('client')
            ->columns('prenom AS pre', ' nom AS nm')
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

    public function testSelectWhere()
    {
        $sql = "SELECT client.prenom, client.nom FROM client WHERE client.id = '1'";

        $qb = (new QueryBuilder())
            ->select('client')
            ->columns('prenom', 'nom')
            ->where('id', '=', 1)
        ;

        $this->assertEquals($sql, $qb->__toString());
    }

    private function prettify(string $sql)
    {
        $sql = str_replace("\n", " ", $sql);
        $sql = preg_replace("# +#", " ", $sql);
        return trim($sql);
    }

}

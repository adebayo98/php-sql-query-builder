<?php

use PHPUnit\Framework\TestCase;
use Adebayo\QueryBuilder\Model\CaseClause;


class CaseClauseTest extends TestCase
{

    public function testCauseClause()
    {
        $caseClause = (new CaseClause())
            ->addWhen('marge_pourcentage=1', 'Prix ordinaire')
            ->addWhen('marge_pourcentage>1', 'Prix supérieur à la normale')
            ->else('Prix inférieur à la normale')
        ;

        $query = "CASE WHEN marge_pourcentage=1 THEN 'Prix ordinaire' WHEN marge_pourcentage>1 THEN 'Prix supérieur à la normale' ELSE 'Prix inférieur à la normale' END";

        $this->assertEquals($query, $caseClause->__toString());

    }

}
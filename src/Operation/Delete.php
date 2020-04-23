<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Common;
use Adebayo\QueryBuilder\Component\Clause\Where;


class Delete extends Common
{

    use Where;

    public function __toString()
    {
        parent::__toString();

        $sql = "DELETE FROM {$this->tableName}";

        // Were
        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        return $sql;
    }

}

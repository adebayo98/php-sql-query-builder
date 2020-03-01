<?php


namespace Adebayo\QueryBuilder\Operation;


use Adebayo\QueryBuilder\Clause\Columns;
use Adebayo\QueryBuilder\Clause\Distinct;
use Adebayo\QueryBuilder\Clause\Join;
use Adebayo\QueryBuilder\Clause\Limit;
use Adebayo\QueryBuilder\Clause\Where;

abstract class AbstractSelect extends Common
{
    use Distinct;
    use Columns;
    use Join;
    use Where;
    use Limit;

    public function __toString()
    {
        $sql = "SELECT " . $this->isDistinct() ? ' DISTINCT ' : '' . $this->parseColumns() . " FROM {$this->tableName}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        if ($this->limit !== null){
            $sql.= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    private function parseColumns()
    {
        // Overloaded this method in the child class.
    }

}

<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Common;
use mysql_xdevapi\Exception;


class Create extends Common
{

    private array $columns = [];


    public function __toString()
    {
        if (empty($this->columns)){
            throw new Exception("{$this->tableName} must have at least one column");
        }

        return "CREATE TABLE {$this->tableName} (" . implode(',', $this->columns) . ")";
    }

    public function addColumn(string $column, string $properties)
    {
        $this->columns[] = "`$column` " . $properties;
    }

    private function getColumns(): array
    {
        return $this->columns;
    }

}

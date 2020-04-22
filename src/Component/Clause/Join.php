<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait Join
{

    private $join = [];


    public function innerJoin(string $refTable, string $selfColumn, string $refColumn, array $columns = []): self
    {
        $this->join[] = "INNER JOIN {$refTable} ON {$this->tableName()}.{$selfColumn} = {$refTable}.{$refColumn}";
        foreach ($columns as $column){
            $this->columns[] = "{$refTable}." . trim($column);
        }
        return $this;
    }

}

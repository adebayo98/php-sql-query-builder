<?php


namespace Adebayo\QueryBuilder\Component\Clause;

use Adebayo\QueryBuilder\Model\CaseClause;
use Adebayo\QueryBuilder\Model\RelationColumn;
use Adebayo\QueryBuilder\QueryBuilder;


trait Column
{

    private $columns = [];


    public function columns(...$columns): self
    {
        foreach ($columns as $column){
            $this->columns[] = "{$this->tableName()}." . trim($column);
        }
        return $this;
    }

    public function parseColumnsData(): string
    {
        if (empty($this->columns)){
            return "*";
        }
        return implode(', ', array_unique($this->columns));
    }

}

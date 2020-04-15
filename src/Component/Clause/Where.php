<?php

namespace Adebayo\QueryBuilder\Component\Clause;

use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Model\WhereGroup;
use Adebayo\QueryBuilder\Operation\Select;
use Adebayo\QueryBuilder\QueryBuilder;


trait Where
{

    private array $where = [];


    public function where(string $column, string $compare, string $value): self
    {
        $this->where[] =  [
            (empty($this->where) ? '' : 'AND'), $column, $compare, $value
        ];
        return $this;
    }

    public function orWhere(string $column, string $compare, string $value): self
    {
        $this->where[] =  [
            (empty($this->where) ? '' : 'OR'), $column, $compare, $value
        ];
        return $this;
    }

    public function parseWhere(): string
    {
        if (isset($this->bind) ? $this->bind : false){
            return $this->parseWhereBind();
        }else{
            return $this->parseWhereNotBind();
        }
    }

    private function parseWhereNotBind(): string
    {
        $conditions = [];
        foreach ($this->where as $condition){
            $conditions[] = "{$condition[0]} {$condition[1]} {$condition[2]} " . ColumnParser::value($condition[3]);
        }
        return trim(implode(' ', $conditions));
    }

    private function parseWhereBind(): string
    {
        $conditions = [];
        foreach ($this->where as $condition){
            $param = $this->getParamCounter();
            $this->valuesBind[$param] = $condition[3];
            $conditions[] = "{$condition[0]} {$this->tableName}.{$condition[1]} {$condition[2]} {$param}";
        }

        return trim(implode(' ', $conditions));
    }

}

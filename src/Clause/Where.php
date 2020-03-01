<?php

namespace Adebayo\QueryBuilder\Clause;

use Adebayo\QueryBuilder\Model\WhereGroup;


trait Where
{

    private array $where = [];


    public function where(string $condition): self
    {
        $this->where[] =  (empty($this->where) ? '' : 'AND ') . $condition;
        return $this;
    }

    public function orWhere(string $condition): self
    {
        $this->where[] =  "OR {$condition}";
        return $this;
    }

    public function whereIn(string $column, array $values): self
    {
        $this->where($this->parseWhereIn($column, $values));
        return $this;
    }

    public function orWhereIn(string $column, array $values): self
    {
        $this->orWhere($this->parseWhereIn($column, $values));
        return $this;
    }

    private function parseWhereIn(string $column, array $values): string
    {
        return "{$column} IN (" . implode(', ', $values) . ")";
    }

    public function whereGroup(callable $callable): self
    {
        $this->where("(" . call_user_func_array($callable, [new WhereGroup()])->parseWhere() . ")");
        return $this;
    }

    public function orWhereGroup(callable $callable): self
    {
        $this->orWhere("(" . call_user_func_array($callable, [new WhereGroup()])->parseWhere() . ")");
        return $this;
    }

    public function parseWhere(): string
    {
        return implode(' ', $this->where);
    }

}

<?php

namespace Adebayo\QueryBuilder\Clause;

use Adebayo\QueryBuilder\Model\WhereGroup;
use Adebayo\QueryBuilder\Operation\Select;
use Adebayo\QueryBuilder\QueryBuilder;

// @todo manage where NOT cases.

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
        $this->where[] = (empty($this->where) ? '' : 'OR ')  . $condition;
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

    public function whereInSubQuery(string $column, string $subQueryTableName, callable $callable): self
    {
        $queryInstance = QueryBuilder::select($subQueryTableName);
        $queryInstance = call_user_func_array($callable, [$queryInstance]);
        $this->where($this->parseWhereIn($column, $queryInstance));
        return $this;
    }

    public function orWhereInSubQuery(string $column, string $subQueryTableName, callable $callable): self
    {
        $queryInstance = QueryBuilder::select($subQueryTableName);
        $queryInstance = call_user_func_array($callable, [$queryInstance]);
        $this->orWhere($this->parseWhereIn($column, $queryInstance));
        return $this;
    }

    private function parseWhereIn(string $column, $value): string
    {
        return "{$column} IN (" . ($value instanceof Select ? $value->__toString() : implode(', ', $value)) . ")";
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

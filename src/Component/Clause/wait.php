<?php


use Adebayo\QueryBuilder\Model\SubWhere;
use Adebayo\QueryBuilder\Operation\Select;
use Adebayo\QueryBuilder\QueryBuilder;


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

    public function whereIn(string $column, array $values, bool $isNotIn = false): self
    {
        $this->where($this->parseWhereIn($column, $values, $isNotIn));
        return $this;
    }

    public function orWhereIn(string $column, array $values, bool $isNotIn = false): self
    {
        $this->orWhere($this->parseWhereIn($column, $values, $isNotIn));
        return $this;
    }

    public function whereInSubQuery(string $column, string $subQueryTableName, callable $callable, bool $isNotIn = false): self
    {
        // @todo Add options in qb constructor
        $queryInstance = (new QueryBuilder())->select($subQueryTableName);
        $queryInstance = call_user_func_array($callable, [$queryInstance]);
        $this->where($this->parseWhereIn($column, $queryInstance, $isNotIn));
        return $this;
    }

    public function orWhereInSubQuery(string $column, string $subQueryTableName, callable $callable, bool $isNotIn = false): self
    {
        $queryInstance = (new QueryBuilder())->select($subQueryTableName);
        $queryInstance = call_user_func_array($callable, [$queryInstance]);
        $this->orWhere($this->parseWhereIn($column, $queryInstance, $isNotIn));
        return $this;
    }

    private function parseWhereIn(string $column, $value, bool $isNotIn = false): string
    {
        return "{$column} " . ($isNotIn === false ? '' : 'NOT ') . "IN (" . ($value instanceof Select ? $value->__toString() : implode(', ', $value)) . ")";
    }

    public function whereExist(string $subQueryTableName, callable $callable)
    {
        $queryInstance = (new QueryBuilder())->select($subQueryTableName);
        $queryInstance = call_user_func_array($callable, [$queryInstance]);
        // @todo finished this
    }

    private function parseWhereExist()
    {
        // @todo implement this method
    }

    public function whereGroup(callable $callable): self
    {
        $this->where("(" . call_user_func_array($callable, [new SubWhere()])->parseWhere() . ")");
        return $this;
    }

    public function orWhereGroup(callable $callable): self
    {
        $this->orWhere("(" . call_user_func_array($callable, [new SubWhere()])->parseWhere() . ")");
        return $this;
    }

    public function parseWhere(): string
    {
        return implode(' ', $this->where);
    }

}

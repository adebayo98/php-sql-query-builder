<?php


namespace Adebayo\QueryBuilder\Piece;


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

    public function whereGroup(callable $callable): self
    {
        // @todo verify if $callback return instance of WhereGroup
        $this->where("(" . call_user_func_array($callable, [new WhereGroup()])->parseWhere() . ")");
        return $this;
    }

    public function orWhereGroup(callable $callable): self
    {
        // @todo verify if $callback return instance of WhereGroup
        $this->orWhere("(" . call_user_func_array($callable, [new WhereGroup()])->parseWhere() . ")");
        return $this;
    }

    public function parseWhere(): string
    {
        return implode(' ', $this->where);
    }

}

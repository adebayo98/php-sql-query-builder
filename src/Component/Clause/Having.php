<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait Having
{

    private array $having = [];


    public function having(string $condition): self
    {
        $this->having[] =  (empty($this->having) ? '' : 'AND ') . $condition;
        return $this;
    }

    public function orHaving(string $condition): self
    {
        $this->having[] =  (empty($this->having) ? '' : 'OR ') . $condition;
        return $this;
    }

    public function getHaving(): array
    {
        return $this->having;
    }

    public function parseHaving(): string
    {
        return implode(' ', $this->having);
    }

}

<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait OrderBy
{

    private array $orderBy = [];


    public function addOrderBy(string $column, string $sort): self
    {
        $this->orderBy[] = "{$column} {$sort}";

        return $this;
    }

    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    public function parseOrderBy()
    {
        return implode(', ', $this->orderBy);
    }

}

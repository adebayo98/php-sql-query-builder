<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait Limit
{

    private ?int $limit = null;

    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

}
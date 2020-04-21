<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait Limit
{

    private $limit;


    public function limit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

}

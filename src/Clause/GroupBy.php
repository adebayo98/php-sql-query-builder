<?php


namespace Adebayo\QueryBuilder\Clause;


trait GroupBy
{

    private ?string $groupBy = null;


    public function groupBy(?string $column): self
    {
        $this->groupBy = $column;
        return $this;
    }

    public function getGroupBy(): ?string
    {
        return $this->groupBy;
    }

}
<?php


namespace Adebayo\QueryBuilder\Clause;


trait Distinct
{

    private bool $distinct = false;


    public function distinct(bool $isDistinct = true): self
    {
        $this->distinct = $isDistinct;
        return $this;
    }

    public function getDistinct(): bool
    {
        return $this->distinct;
    }

}

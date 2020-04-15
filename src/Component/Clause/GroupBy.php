<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait GroupBy
{

    private ?string $groupBy = null;

    private ?bool $withRollUp = null;


    public function groupBy(?string $column, ?bool $withRollUp = null): self
    {
        $this->groupBy = $column;
        $this->withRollUp = $withRollUp;
        return $this;
    }

    public function getGroupBy(): ?string
    {
        return $this->groupBy;
    }

    public function getWithRollUp(): ?bool
    {
        return $this->withRollUp;
    }

}

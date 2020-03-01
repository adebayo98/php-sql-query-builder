<?php


namespace Adebayo\QueryBuilder\Clause;

// @todo Finished this clause

trait Having
{

    private array $having = [];


    public function having(string $condition): self
    {
        $this->having[] =  (empty($this->having) ? '' : 'AND ') . $condition;
        return $this;
    }

    public function getHaving(): array
    {
        return $this->having;
    }

}
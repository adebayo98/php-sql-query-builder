<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait Offset
{

    private $offset = 0;


    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}

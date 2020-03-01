<?php


namespace Adebayo\QueryBuilder\Clause;


trait Offset
{

    private ?int $offset = null;


    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

}
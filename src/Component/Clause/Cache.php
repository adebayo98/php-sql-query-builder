<?php


namespace Adebayo\QueryBuilder\Component\Clause;


trait Cache
{

    private ?bool $sqlCache = null;


    public function sqlCache(): self
    {
        $this->sqlCache = true;
        return $this;
    }

    public function sqlNoCache(): ?self
    {
        $this->sqlCache = false;
        return $this;
    }

    public function getSqlCache(): ?bool
    {
        return $this->sqlCache;
    }

    private function parseSqlCache(): string
    {
        if ($this->sqlCache === null){
            return '';
        }

        return $this->sqlCache === true ? ' SQL_CACHE' : ' SQL_NO_CACHE';
    }

}

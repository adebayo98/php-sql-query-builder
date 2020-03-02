<?php


namespace Adebayo\QueryBuilder\Model;


class CaseClause
{

    private array $when = [];

    private ?string $else = null;


    public function __toString()
    {
        return "CASE {$this->parseWhen()}" . ($this->else === null ? '' : " ELSE '{$this->else}'") . " END" ;
    }

    public function addWhen(string $condition, string $value): self
    {
        $this->when[] = "WHEN {$condition} THEN '{$value}'";
        return $this;
    }

    public function getWhen(): array
    {
        return $this->when;
    }

    public function else(string $condition)
    {
        $this->else = $condition;
        return $this;
    }

    public function getElse(): ?string
    {
        return $this->else;
    }

    private function parseWhen()
    {
        return implode(' ', $this->when);
    }

}
<?php


namespace Adebayo\QueryBuilder\Model;


/**
 * Class CaseClause
 * @package Adebayo\QueryBuilder\Model
 *
 * @see https://sql.sh/cours/case
 * @version 1.0
 * @since 1.0
 */
class CaseClause
{

    private array $when = [];

    private ?string $else = null;


    public function __toString()
    {
        return "CASE {$this->parseWhen()}" . ($this->else === null ? '' : " ELSE '{$this->else}'") . " END" ;
    }

    public function addWhen(string $condition, string $value, bool $valueIsColumn = false): self
    {
        $this->when[] = "WHEN {$condition} THEN " . ($valueIsColumn ? "{$value}" : "'{$value}'");
        return $this;
    }

    public function getWhen(): array
    {
        return $this->when;
    }

    public function else(string $defaultValue)
    {
        $this->else = $defaultValue;
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

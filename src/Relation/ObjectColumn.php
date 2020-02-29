<?php


namespace Adebayo\QueryBuilder\Relation;

use Adebayo\QueryBuilder\Piece\Where;
use Adebayo\QueryBuilder\Crud\Common;
use Adebayo\QueryBuilder\Piece\Columns;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Contract\ContextInterface;


class ObjectColumn extends Common implements ContextInterface
{
    use Columns;
    use Where;

    private ?string $alias;


    public function __toString()
    {
        $sql = "SELECT {$this->parseColumns()} FROM {$this->tableName()}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        return $sql;
    }

    private function parseColumns()
    {
        return "json_object(" . ColumnParser::objectRow($this->columns) . ")";
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function tableName(): string
    {
        return parent::getTableName();
    }

    public function isQueryBase(): bool
    {
        return false;
    }
}

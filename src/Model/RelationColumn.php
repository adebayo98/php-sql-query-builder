<?php


namespace Adebayo\QueryBuilder\Model;

use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\AbstractSelect;


class RelationColumn extends AbstractSelect
{

    private ?string $alias = null;

    private string $relationType;


    public function __construct(string $tableName, string $relationType, $options = [])
    {
        parent::__construct($tableName, false, $options);
        $this->relationType = $relationType;
    }

    public function parseColumns()
    {
        return $this->relationType === 'object' ? $this->parseColumnsObject() : $this->parseColumnsCollection();
    }

    private function parseColumnsObject()
    {
        return "json_object(" . ColumnParser::objectRow($this->columns) . ")";
    }

    private function parseColumnsCollection()
    {
        return "json_arrayagg({$this->parseColumnsObject()})";
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
}

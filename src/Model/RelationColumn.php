<?php


namespace Adebayo\QueryBuilder\Model;

use Adebayo\QueryBuilder\Clause\Limit;
use Adebayo\QueryBuilder\Clause\Where;
use Adebayo\QueryBuilder\Operation\Common;
use Adebayo\QueryBuilder\Clause\Columns;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Contract\ContextInterface;


class RelationColumn extends Common implements ContextInterface
{
    use Columns;
    use Where;
    use Limit;

    private ?string $alias = null;

    private string $relationType;


    public function __construct(string $tableName, string $relationType, $options = [])
    {
        parent::__construct($tableName, $options);
        $this->relationType = $relationType;
    }

    public function __toString()
    {
        $sql = "SELECT {$this->parseColumns()} FROM {$this->tableName()}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        if ($this->limit !== null){
            $sql.= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    private function parseColumns()
    {
        return $this->relationType === 'object' ? $this->parseColumnsObject() : $this->parseColumnsCollection();
    }

    private function parseColumnsObject()
    {
        return "json_object(" . ColumnParser::objectRow($this->columns) . ")";
    }

    private function parseColumnsCollection()
    {
        return "json_array({$this->parseColumnsObject()})";
    }

    public function tableName(): string
    {
        return parent::getTableName();
    }

    public function isQueryBase(): bool
    {
        return false;
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

<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Clause\Limit;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Clause\Join;
use Adebayo\QueryBuilder\Clause\Where;
use Adebayo\QueryBuilder\Clause\Columns;
use Adebayo\QueryBuilder\Contract\ContextInterface;


class Select extends Common implements ContextInterface
{
    use Columns;
    use Join;
    use Where;
    use Limit;

    public function __toString()
    {
        $sql = "SELECT " . ColumnParser::stringRow($this->columns) . " FROM {$this->tableName()}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        if ($this->limit !== null){
            $sql.= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    public function tableName(): string
    {
        return parent::getTableName();
    }

    public function isQueryBase(): bool
    {
       return true;
    }
}

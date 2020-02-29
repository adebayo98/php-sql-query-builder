<?php


namespace Adebayo\QueryBuilder\Crud;

use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Piece\Join;
use Adebayo\QueryBuilder\Piece\Where;
use Adebayo\QueryBuilder\Piece\Columns;
use Adebayo\QueryBuilder\Contract\ContextInterface;


class Select extends Common implements ContextInterface
{
    use Columns;
    use Join;
    use Where;

    public function __toString()
    {
        $sql = "SELECT " . ColumnParser::stringRow($this->columns) . " FROM {$this->tableName()}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
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

<?php


namespace Adebayo\QueryBuilder\Operation;


use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Contract\ContextInterface;


class Select extends AbstractSelect implements ContextInterface
{

    private function parseColumns(): string
    {
        return ColumnParser::stringRow($this->columns);
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

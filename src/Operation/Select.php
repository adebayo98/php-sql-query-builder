<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\AbstractSelect;
use Adebayo\QueryBuilder\Helper\ColumnParser;


class Select extends AbstractSelect
{
    public function __construct(string $tableName, $options = [])
    {
        parent::__construct($tableName, true, $options);
    }

    public function parseColumns()
    {
        return ColumnParser::stringRow($this->columns);
    }
}

<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\AbstractSelect;


class Select extends AbstractSelect
{
    public function __construct(string $tableName, $options = [])
    {
        parent::__construct($tableName, true, $options);
    }
}

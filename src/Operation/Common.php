<?php


namespace Adebayo\QueryBuilder\Operation;


abstract class Common
{

    protected string $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function __toString()
    {
        return '';
    }
}

<?php


namespace Adebayo\QueryBuilder\Operation;


abstract class Common
{
    protected string $tableName;

    protected string $dbProvider;

    public function __construct(string $tableName, string $dbProvider = 'mysql')
    {
        $this->tableName = $tableName;
        $this->dbProvider = $dbProvider;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function __toString()
    {
        // Overloaded this method in the child class.
    }
}

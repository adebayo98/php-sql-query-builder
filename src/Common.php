<?php


namespace Adebayo\QueryBuilder;


abstract class Common
{
    protected string $tableName;

    protected array $options;


    public function __construct(string $tableName, $options = [])
    {
        $this->tableName = $tableName;
        $this->options = $options;
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

<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Model\DriverType;


abstract class Common
{

    protected string $tableName;

    protected string $driver;


    public function __construct(string $tableName, $options = [])
    {
        $this->tableName = $tableName;
        $this->driver = isset($options['driver']) ? $options['driver'] : DriverType::MYSQL;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }
}

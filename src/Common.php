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

    /**
     * @todo Throw new exception if this method is not overloaded in child class ?
     * @return string
     */
    public function __toString()
    {
        return "Overloaded this method in the " . self::class;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }
}

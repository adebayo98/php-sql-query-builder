<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Component\Bind;
use Adebayo\QueryBuilder\Model\DriverType;


abstract class Common
{

    use Bind;

    protected string $tableName;

    protected string $driver;

    private int $counter = 0;


    public function __toString()
    {
        $this->valuesBind = [];
    }

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

    protected function getParamCounter()
    {
        $this->counter++;
        return (string) ":v" .$this->counter;
    }
}

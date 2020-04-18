<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Model\Driver;


abstract class Common
{

    /**
     * The name of table in which the query will be executed.
     *
     * @var string
     */
    protected string $tableName;

    /**
     * Database driver type
     * @see \Adebayo\QueryBuilder\Model\Driver
     *
     * @var mixed|string
     */
    protected string $driver;

    /**
     * Counter for data to bind
     *
     * @var int
     */
    private int $counter = 0;

    /**
     * Defines if the query must use named parameters for each value of the query.
     *
     * @var bool
     */
    protected bool $bind = false;

    /**
     * Associative array of named parameters and their respective values.
     *
     * @var array
     */
    protected array $valuesBind = [];


    public function __construct(string $tableName, $options = [])
    {
        $this->tableName = $tableName;
        $this->driver = isset($options['driver']) ? $options['driver'] : Driver::MYSQL;
    }

    public function __toString()
    {
        $this->valuesBind = [];
    }

    /**
     * @param bool $bind
     * @return $this
     */
    public function bind(bool $bind = true): self
    {
        $this->bind = $bind;

        return $this;
    }

    protected function getParamCounter()
    {
        $this->counter++;
        return (string) ":v" .$this->counter;
    }

    /**
     * Get the list of parameters to bind and their values.
     *
     * @return array
     */
    public function getValuesBind(): array
    {
        return $this->valuesBind;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): self
    {
        $this->driver = $driver;

        return  $this;
    }

}

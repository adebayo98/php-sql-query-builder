<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Operation\Create;
use Adebayo\QueryBuilder\Operation\Insert;
use Adebayo\QueryBuilder\Operation\Select;


class QueryBuilder
{

    private array $options;


    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function insert(string $tableName)
    {
        return new Insert($tableName, $this->options);
    }

    public function select(string $tableName)
    {
        return new Select($tableName, $this->options);
    }



    public function update(string $tableName)
    {

    }

    public function delete(string $tableName)
    {

    }

    public function createTable(string $tableName)
    {
        return new Create($tableName);
    }

}

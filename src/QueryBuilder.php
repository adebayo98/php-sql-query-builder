<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Operation\Select;


class QueryBuilder
{

    public static function select(string $tableName)
    {
        return new Select($tableName);
    }

    public static function insert(string $tableName)
    {

    }

    public static function update(string $tableName)
    {

    }

    public static function delete(string $tableName)
    {

    }

}

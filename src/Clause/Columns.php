<?php


namespace Adebayo\QueryBuilder\Clause;


use Adebayo\QueryBuilder\Operation\Select;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Model\ObjectField;
use Adebayo\QueryBuilder\Relation\ObjectColumn;


trait Columns
{

    private array $columns = [];


    public function addColumns(...$fields)
    {
        $this->columns = [...$this->columns, ...$fields];

        return $this;
    }

    public function addSubQueryField(?string $alias, callable $callable)
    {
        $this->addColumns(
            "(" . $callable()->__toString() . ")" . ($alias === null ? '' : " AS {$alias}")
        );

        return $this;
    }

    public function addColumnObject(string $tableName, string $foreignKey, string $localKey, ?callable $callable = null)
    {
        $query = (new ObjectColumn($tableName))
            ->where("{$tableName}.{$localKey} = {$this->tableName()}.{$foreignKey}")
        ;

        if ($callable !== null){
            $query = call_user_func_array($callable, [$query]);
        }

        if ($this->isQueryBase()){
            $this->addSubQueryField($query->getAlias() ?? $query->tableName(), function () use ($query) {
                return $query;
            });
        }

        if (!$this->isQueryBase()){
            $this->addColumns(
                ["(" . $query->__toString() . ")" => ($this->getAlias() === null ? $this->tableName() : $this->getAlias())]
            );
        }

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

}

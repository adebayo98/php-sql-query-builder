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

    public function addColumnObject(string $tableName, string $childKey, string $parentKey, ?callable $callable = null)
    {
        $query = (new ObjectColumn($tableName))
            ->where("{$tableName}.{$childKey} = {$this->tableName()}.{$parentKey}")
            ->limit(1)
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
                ["(" . $query->__toString() . ")" => $query->getAlias() ?? $query->tableName()]
            );
        }

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

}

<?php


namespace Adebayo\QueryBuilder\Clause;


use Adebayo\QueryBuilder\Operation\Select;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Model\ObjectField;
use Adebayo\QueryBuilder\Model\RelationColumn;


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
        // @todo Throw exception if $callable not return Select instance
        $this->addColumns(
            "(" . $callable()->__toString() . ")" . ($alias === null ? '' : " AS {$alias}")
        );

        return $this;
    }

    public function addColumnObject(string $tableName, string $childKey, string $parentKey, ?callable $callable = null)
    {
        $query = (new RelationColumn($tableName, 'object'))
            ->where("{$tableName}.{$childKey} = {$this->tableName()}.{$parentKey}")
            ->limit(1)
        ;

        if ($callable !== null){
            // @todo Throw exception if $callable not return RelationColumn instance
            $query = call_user_func_array($callable, [$query]);
        }

        $this->bindRelationColumnToContext($query);

        return $this;
    }

    public function addColumnCollection(string $tableName, string $childKey, string $parentKey, ?callable $callable = null)
    {
        $query = (new RelationColumn($tableName, 'collection'))
            ->where("{$tableName}.{$childKey} = {$this->tableName()}.{$parentKey}")
        ;

        if ($callable !== null){
            // @todo Throw exception if $callable not return RelationColumn instance
            $query = call_user_func_array($callable, [$query]);
        }

        $this->bindRelationColumnToContext($query);

        return $this;
    }

    private function bindRelationColumnToContext(RelationColumn $instance)
    {
        if ($this->isQueryBase()){
            $this->addSubQueryField($instance->getAlias() ?? $instance->tableName(), function () use ($instance) {
                return $instance;
            });
        }

        if (!$this->isQueryBase()){
            $this->addColumns(
                ["(" . $instance->__toString() . ")" => $instance->getAlias() ?? $instance->tableName()]
            );
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }

}

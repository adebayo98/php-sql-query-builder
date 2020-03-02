<?php


namespace Adebayo\QueryBuilder\Clause;

use Adebayo\QueryBuilder\Model\CaseClause;
use Adebayo\QueryBuilder\Model\RelationColumn;
use Adebayo\QueryBuilder\QueryBuilder;


trait Column
{

    protected array $columns = [];


    public function addColumn(...$fields)
    {
        $this->columns = [...$this->columns, ...$fields];
        return $this;
    }

    public function addColumnSubQuery(?string $columnAlias, string $subQueryTableName, callable $callable)
    {
        // @todo Throw exception if $callable not return Select instance
        $subQuery = call_user_func_array($callable, [QueryBuilder::select($subQueryTableName)]);

        if ($this->isQueryBase()){
            $this->addColumn(
                "(" . $subQuery->__toString() . ")" . ($columnAlias === null ? '' : " AS {$columnAlias}")
            );
        }

        if (!$this->isQueryBase()){
            $this->addColumn(["(" . $subQuery->__toString() . ")" => $columnAlias]);
        }

        return $this;
    }

    public function addColumnCase(string $alias, callable $callable): self
    {
        $caseClause = call_user_func_array($callable, [new CaseClause()]);
        $this->addColumn([$caseClause->__toString() => $alias]);
        return $this;
    }

    public function addColumnObject(string $tableName, string $childKey, string $parentKey, ?callable $callable = null)
    {
        $query = (new RelationColumn($tableName, 'object'))
            ->where("{$tableName}.{$childKey} = {$this->tableName()}.{$parentKey}")
        ;

        if ($callable !== null){
            $query = call_user_func_array($callable, [$query]);
        }

        $this->bindRelationColumnToContext($query->limit(1));

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
            $this->addColumn(
                "(" . $instance->__toString() . ")" . (" AS " . $instance->getAlias() ?? $instance->tableName())
            );
        }

        if (!$this->isQueryBase()){
            $this->addColumn(
                ["(" . $instance->__toString() . ")" => $instance->getAlias() ?? $instance->tableName()]
            );
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }

}
<?php

namespace Adebayo\QueryBuilder\Component\Clause;

use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Model\SubWhere;


trait Where
{

    private array $where = [];


    public function where(string $column, string $compare, string $value): self
    {
        $this->buildWhereRow($column, $compare, $value);
        return $this;
    }

    public function orWhere(string $column, string $compare, string $value): self
    {
        $this->buildWhereRow($column, $compare, $value, 'OR');
        return $this;
    }

    private function buildWhereRow(string $column, string $compare, string $value, $logicOperator = 'AND'): void
    {
        $this->where[] = (object) [
            'logic_operator' => (empty($this->where) ? '' : $logicOperator),
            'column' => $column,
            'compare' => $compare,
            'value' => $value
        ];
    }

    public function subWhere(callable $callable): self
    {
        $this->buildSubWhereRow($callable);
        return $this;
    }

    public function orSubWhere(callable $callable): self
    {
        $this->buildSubWhereRow($callable, 'OR');
        return $this;
    }

    private function buildSubWhereRow(callable $callable, $logicOperator = 'AND')
    {
        $subWhere = new SubWhere();
        $callable($subWhere);
        $this->where[] = [
            'type' => 'sub',
            'logic_operator' => (empty($this->where) ? '' : $logicOperator),
            'conditions' => $subWhere->getWhereData()
        ];
    }

    public function parseWhere(): string
    {
        if (isset($this->bind) ? $this->bind : false){
            return $this->parseWhereBind();
        }else{
            return $this->parseWhereNotBind();
        }
    }

    private function parseWhereNotBind(): string
    {
        return $this->buildWhereParser(function (object $condition){
            return "{$condition->logic_operator} {$condition->column} {$condition->compare} " . ColumnParser::value($condition->value);
        });
    }

    private function parseWhereBind(): string
    {
        return $this->buildWhereParser(function (object $condition){
            $param = $this->getParamCounter();
            $this->valuesBind[$param] = $condition->value;
            return "{$condition->logic_operator} {$this->tableName}.{$condition->column} {$condition->compare} {$param}";
        });
    }

    private function buildWhereParser(callable $rowResolver)
    {
        $conditions = [];
        foreach ($this->where as $row){
            if (is_object($row)){
                $conditions[] = $rowResolver($row);
            }
            if (is_array($row) && $row['type'] === 'sub'){
                $conditions[] = $row['logic_operator'] . ' (' . trim(implode(' ', array_map($rowResolver, $row['conditions']))) . ')';
            }
        }
        return trim(implode(' ', $conditions));
    }

    public function getWhereData()
    {
        return $this->where;
    }

}

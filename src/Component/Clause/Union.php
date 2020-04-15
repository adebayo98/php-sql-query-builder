<?php


namespace Adebayo\QueryBuilder\Component\Clause;

use Adebayo\QueryBuilder\QueryBuilder;


trait Union
{

    private array $union = [];


    public function addUnion(string $tableName, callable $callable = null): self
    {
        $queryInstance = (new QueryBuilder())->select($tableName);
        if ($callable !== null){
            $queryInstance = call_user_func_array($callable, [$queryInstance]);
        }
        $this->union[] = 'UNION ' . $queryInstance->__toString();
        return $this;
    }

    public function addUnionAll(string $tableName, callable $callable = null): self
    {
        $queryInstance = (new QueryBuilder())->select($tableName);
        if ($callable !== null){
            $queryInstance = call_user_func_array($callable, [$queryInstance]);
        }
        $this->union[] = 'UNION ALL ' . $queryInstance->__toString();
        return $this;
    }

    private function parseUnion(): string
    {
        return implode(' ', $this->union);
    }

    public function getUnion(): array
    {
        return $this->union;
    }

}
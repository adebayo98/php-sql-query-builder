<?php


namespace Adebayo\QueryBuilder\Clause;

use Adebayo\QueryBuilder\QueryBuilder;


trait Union
{

    private array $union = [];


    public function addUnion(string $tableName, callable $callable): self
    {
        $queryInstance = QueryBuilder::select($tableName);
        $queryInstance = call_user_func_array($callable, [$queryInstance]);
        $this->union[] = (empty($this->union) ? '' : 'UNION') . $queryInstance->__toString();
        return $this;
    }

    private function parseUnion()
    {
        return implode(' ', $this->union);
    }

    public function getUnion(): array
    {
        return $this->union;
    }

}

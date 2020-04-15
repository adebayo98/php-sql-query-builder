<?php

namespace Adebayo\QueryBuilder\Component\Clause;

use Adebayo\QueryBuilder\QueryBuilder;


trait Intersect
{

    private ?string $intersect = null;


    public function intersect(string $tableName, callable $callable = null): self
    {
        $queryInstance = (new QueryBuilder())->select($tableName);

        if ($callable !== null){
            $queryInstance = call_user_func_array($callable, [$queryInstance]);
        }

        $this->intersect = $queryInstance->__toString();

        return $this;
    }

    public function getIntersect(): string
    {
        return $this->intersect;
    }

}

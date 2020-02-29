<?php


namespace Adebayo\QueryBuilder\Contract;


interface ContextInterface
{
    /**
     * Get the current query context table name.
     *
     * @return string
     */
    public function tableName(): string;

    /**
     * @todo find good word to explain this.
     *
     * @return bool
     */
    public function isQueryBase(): bool;
}

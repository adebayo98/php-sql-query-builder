<?php


namespace Adebayo\QueryBuilder\Component;

/**
 * Part of the sql operations used to create a query with named parameters for each defined column.
 *
 * @link https://www.php.net/manual/fr/pdostatement.bindvalue.php
 *
 * @since 1.0
 * @version 1.0
 * @author HOUNTONDJI Adebayo <hountondjigodwill@gmail.com>
 */
trait Bind
{
    /**
     * Defines if the query must use named parameters for each value of the query.
     *
     * @var bool
     */
    private bool $bind = false;

    /**
     * Associative array of named parameters and their respective values.
     *
     * @var array
     */
    private array $valuesBind = [];


    /**
     * @param bool $bind
     * @return $this
     */
    public function bind(bool $bind = true): self
    {
        $this->bind = $bind;

        return $this;
    }

    /**
     * Get the list of parameters to bind and their values.
     *
     * @return array
     */
    public function getValuesBind(): array
    {
        return $this->valuesBind;
    }

}

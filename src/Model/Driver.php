<?php


namespace Adebayo\QueryBuilder\Model;


class Driver
{
    /**
     * SGBD Mysql database provider.
     *
     * @var string
     */
    public const MYSQL = 'mysql';

    /**
     * SGBD PostgreSQL database provider.
     *
     * @var string
     */
    public const POSTGRSQL = 'pgsql';

    /**
     * SGBD Oracle database provider.
     *
     * @var string
     */
    public const ORACLE = 'oracle';
}

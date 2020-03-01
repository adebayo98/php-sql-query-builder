<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Clause\Cache;
use Adebayo\QueryBuilder\Clause\Columns;
use Adebayo\QueryBuilder\Clause\Distinct;
use Adebayo\QueryBuilder\Clause\GroupBy;
use Adebayo\QueryBuilder\Clause\Having;
use Adebayo\QueryBuilder\Clause\Join;
use Adebayo\QueryBuilder\Clause\Limit;
use Adebayo\QueryBuilder\Clause\Where;
use Adebayo\QueryBuilder\Contract\SelectContextInterface;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Model\SGBD;


abstract class AbstractSelect extends Common implements SelectContextInterface
{
    use Cache;
    use Distinct;
    use Columns;
    use Join;
    use Where;
    use GroupBy;
    use Having;
    use Limit;

    private bool $isBaseQuery;


    public function __construct(string $tableName, bool $isBaseQuery, $options = [])
    {
        parent::__construct($tableName, $options);
        $this->isBaseQuery = $isBaseQuery;
    }

    public function __toString()
    {
        $distinct = $this->isDistinct() ? $this->parseDistinct() : '';

        $sql = "SELECT{$this->parseSqlCache()}{$distinct} {$this->parseColumns()}" . " FROM {$this->tableName}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        if ($this->groupBy !== null){
            $sql.= " GROUP BY {$this->groupBy}" . ($this->withRollUp === null ? '' : ' WITH ROLLUP');
        }

        if ($this->limit !== null){
            $sql.= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    private function parseDistinct()
    {
        return $this->sgbd === SGBD::ORACLE ? ' UNIQUE' : ' DISTINCT';
    }

    public function parseColumns()
    {
        return ColumnParser::stringRow($this->columns);
    }

    public function tableName(): string
    {
        return parent::getTableName();
    }

    public function isQueryBase(): bool
    {
        return $this->isBaseQuery;
    }
}

<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Clause\Cache;
use Adebayo\QueryBuilder\Clause\Column;
use Adebayo\QueryBuilder\Clause\Distinct;
use Adebayo\QueryBuilder\Clause\GroupBy;
use Adebayo\QueryBuilder\Clause\Having;
use Adebayo\QueryBuilder\Clause\Intersect;
use Adebayo\QueryBuilder\Clause\Join;
use Adebayo\QueryBuilder\Clause\Limit;
use Adebayo\QueryBuilder\Clause\Offset;
use Adebayo\QueryBuilder\Clause\OrderBy;
use Adebayo\QueryBuilder\Clause\Union;
use Adebayo\QueryBuilder\Clause\Where;
use Adebayo\QueryBuilder\Contract\SelectContextInterface;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Model\Driver;


abstract class AbstractSelect extends Common implements SelectContextInterface
{
    use Cache;
    use Distinct;
    use Column;
    use Join;
    use Where;
    use GroupBy;
    use Having;
    use Limit;
    use Offset;
    use OrderBy;
    use Union;
    use Intersect;


    private bool $isBaseQuery;


    public function __construct(string $tableName, bool $isBaseQuery, $options = [])
    {
        parent::__construct($tableName, $options);
        $this->isBaseQuery = $isBaseQuery;
    }

    public function __toString()
    {
        $distinct = $this->distinct ? $this->parseDistinct() : '';

        $sql = "SELECT{$this->parseSqlCache()}{$distinct} {$this->parseColumns()}" . " FROM {$this->tableName}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        if ($this->groupBy !== null){
            $sql.= " GROUP BY {$this->groupBy}" . ($this->withRollUp === null ? '' : ' WITH ROLLUP');
        }

        if (!empty($this->having)){
            $sql.= " HAVING {$this->parseHaving()}";
        }

        if ($this->limit !== null){
            $sql.= " LIMIT {$this->limit}"  . ($this->offset === null ? '' : " OFFSET {$this->offset}");
        }

        if (!empty($this->orderBy)){
            $sql.= " ORDER BY {$this->parseOrderBy()}";
        }

        if ($this->intersect !== null){

            if ($this->driver === Driver::MYSQL){
                throw new \Exception('INTERSECT is not available on mysql but you can use whereInSubquery to work around this problem.');
            }

            $sql.= " INTERSECT {$this->intersect}";
        }

        if (!empty($this->union)){
            $sql.= " {$this->parseUnion()}";
        }

        return $sql;
    }

    private function parseDistinct()
    {
        return $this->driver === Driver::ORACLE ? ' UNIQUE' : ' DISTINCT';
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

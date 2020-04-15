<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Component\Clause\Cache;
use Adebayo\QueryBuilder\Component\Clause\Column;
use Adebayo\QueryBuilder\Component\Clause\Distinct;
use Adebayo\QueryBuilder\Component\Clause\GroupBy;
use Adebayo\QueryBuilder\Component\Clause\Having;
use Adebayo\QueryBuilder\Component\Clause\Intersect;
use Adebayo\QueryBuilder\Component\Clause\Join;
use Adebayo\QueryBuilder\Component\Clause\Limit;
use Adebayo\QueryBuilder\Component\Clause\Offset;
use Adebayo\QueryBuilder\Component\Clause\OrderBy;
use Adebayo\QueryBuilder\Component\Clause\Union;
use Adebayo\QueryBuilder\Component\Clause\Where;
use Adebayo\QueryBuilder\Contract\SelectContextInterface;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Adebayo\QueryBuilder\Model\DriverType;


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

            if ($this->driver === DriverType::MYSQL){
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
        return $this->driver === DriverType::ORACLE ? ' UNIQUE' : ' DISTINCT';
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

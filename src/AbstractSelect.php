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
        $sql = "SELECT {$this->parseColumnsData()} FROM {$this->tableName()}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        return $sql;
    }

    private function parseDistinct()
    {
        return $this->driver === Driver::ORACLE ? ' UNIQUE' : ' DISTINCT';
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

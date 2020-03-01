<?php


namespace Adebayo\QueryBuilder;

use Adebayo\QueryBuilder\Clause\Columns;
use Adebayo\QueryBuilder\Clause\Distinct;
use Adebayo\QueryBuilder\Clause\Join;
use Adebayo\QueryBuilder\Clause\Limit;
use Adebayo\QueryBuilder\Clause\Where;
use Adebayo\QueryBuilder\Contract\ContextInterface;


abstract class AbstractSelect extends Common implements ContextInterface
{
    use Distinct;
    use Columns;
    use Join;
    use Where;
    use Limit;

    private bool $isBaseQuery;


    public function __construct(string $tableName, bool $isBaseQuery, $options = [])
    {
        parent::__construct($tableName, $options);
        $this->isBaseQuery = $isBaseQuery;
    }

    public function __toString()
    {
        $sql = "SELECT " . ($this->isDistinct() ? ' DISTINCT ' : '') . $this->parseColumns() . " FROM {$this->tableName}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        if ($this->limit !== null){
            $sql.= " LIMIT {$this->limit}";
        }

        return $sql;
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

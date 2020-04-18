<?php

namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Component\Clause\Where;
use Adebayo\QueryBuilder\Common;
use Adebayo\QueryBuilder\Helper\ColumnParser;

/**
 * Query builder for UPDATE sql request.
 *
 * @link https://sql.sh/cours/update
 *
 * @since 1.0
 * @version 1.0
 * @author HOUNTONDJI Adebayo <hountondjigodwill@gmail.com>
 */
class Update extends Common
{

    use Where;

    /**
     * List of data to update
     *
     * @var array
     */
    private array $data = [];


    public function __toString()
    {
        parent::__toString();

        $sql = "UPDATE {$this->tableName} SET {$this->parseUpdateData()}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        return $sql;
    }

    public function values(array $data): self
    {
        foreach ($data as $key => $datum){
            $this->data[$key] = $datum;
        }
        return $this;
    }

    public function set(string $column, $value): self
    {
        $this->data[$column] = $value;
        return $this;
    }

    public function getValues(): array
    {
        return $this->data;
    }

    private function parseUpdateData()
    {
        $updates = "";

        if ($this->bind){
            foreach ($this->data as $key => $datum){
                $param = $this->getParamCounter();
                $this->valuesBind[$param] = $datum;
                $updates.= " {$key} = {$param},";
            }
        }else{
            foreach ($this->data as $key => $datum){
                $updates.= " {$key} = " . ColumnParser::value($datum) . ",";
            }
        }

        return substr(trim($updates), 0, -1);
    }

}

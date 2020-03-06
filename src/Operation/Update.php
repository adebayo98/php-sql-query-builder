<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Clause\Where;
use Adebayo\QueryBuilder\Common;
use Adebayo\QueryBuilder\Helper\ColumnParser;


class Update extends Common
{
    use Where;


    private array $data = [];


    public function __toString()
    {
        $sql = "UPDATE {$this->tableName} SET {$this->parseUpdateValues()}";

        if (!empty($this->where)){
            $sql.= " WHERE {$this->parseWhere()}";
        }

        return $sql;
    }

    public function values(array $data): self
    {
        foreach ($data as $key => $datum){
            $this->data[$key] = ColumnParser::value($datum);
        }
        return $this;
    }

    public function changeValue(string $column, $value): self
    {
        $this->data[$column] = ColumnParser::value($value);
        return $this;
    }

    public function getValues(): array
    {
        return $this->data;
    }

    private function parseUpdateValues()
    {
        $values = "";
        foreach ($this->data as $key => $datum){
            $values.= " {$key} = {$datum},";
        }
        return substr(trim($values), 0, -1);
    }

}

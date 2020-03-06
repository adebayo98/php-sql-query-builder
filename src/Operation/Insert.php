<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Common;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Exception;


class Insert extends Common
{

    private array $data = [];


    public function __toString()
    {
        if (empty($this->data)){
            throw new Exception('Use method addData to defined data to insert in database');
        }

        return "INSERT INTO {$this->tableName} (" . implode(', ', array_keys($this->data)) . ") VALUES (" . implode(', ', $this->data) . ")";
    }

    public function values(array $data): self
    {
        foreach ($data as $key => $datum){
            $this->data[$key] = ColumnParser::value($datum);
        }
        return $this;
    }

    public function addValue(string $column, $value): self
    {
        $this->data[$column] = ColumnParser::value($value);
        return $this;
    }

    public function getValues(): array
    {
        return $this->data;
    }

}

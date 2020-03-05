<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Common;
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

    public function data(array $data): self
    {
        foreach ($data as $key => $datum){
            $this->data[$key] = $this->parseColumnValue($datum);
        }
        return $this;
    }

    public function addData(string $column, $value): self
    {
        $this->data[$column] = $this->parseColumnValue($value);
        return $this;
    }

    private function parseColumnValue($value)
    {
        if (is_string($value)){
            return "'{$value}'";
        }

        return $value;
    }

    public function getData(): array
    {
        return $this->data;
    }

}

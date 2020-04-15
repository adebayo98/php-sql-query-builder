<?php


namespace Adebayo\QueryBuilder\Operation;

use Adebayo\QueryBuilder\Common;
use Adebayo\QueryBuilder\Component\Bind;
use Adebayo\QueryBuilder\Component\Execute;
use Adebayo\QueryBuilder\Helper\ColumnParser;
use Exception;


/**
 * Builder for INSERT INTO sql request.
 *
 * @link https://sql.sh/cours/insert-into
 *
 * @since 1.0
 * @version 1.0
 * @author HOUNTONDJI Adebayo <hountondjigodwill@gmail.com>
 */
class Insert extends Common
{

    use Bind;
    use Execute;

    /**
     * Associative array with columns (array_key) and their values (array_value).
     *
     * @var array
     */
    private array $data = [];


    public function __toString()
    {
        if (empty($this->data)){
            throw new Exception('Use method addData to defined data to insert in database');
        }

        return "INSERT INTO {$this->tableName} (" . implode(', ', array_keys($this->data)) . ") VALUES (" . $this->parseInsertValues() . ")";
    }

    /**
     * Defines the list of columns and their associated value.
     *
     * @param array $data
     * @return $this
     */
    public function values(array $data): self
    {
        foreach ($data as $key => $datum){
            $this->data[$key] = $datum;
        }
        return $this;
    }

    /**
     * Add a column and its value to the query. If the column already exits its value is overwritten by the new.
     *
     * @param string $column The column name.
     * @param string|int|null $value The column value.
     * @return $this
     */
    public function value(string $column, $value): self
    {
        $this->data[$column] = $value;
        return $this;
    }

    /**
     * Get the request columns values.
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->data;
    }

    private function parseInsertValues(): string
    {
        if (!$this->bind){
            return implode(', ', array_map(function ($value){
                return ColumnParser::value($value);
            }, $this->data));
        }

        foreach ($this->data as $key => $datum){
            $this->valuesBind[':' . $this->tableName . '_' . $key] = $datum;
        }

        return implode(', ', array_keys($this->valuesBind));
    }

}

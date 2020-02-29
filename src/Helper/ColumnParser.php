<?php


namespace Adebayo\QueryBuilder\Helper;


class ColumnParser
{
    public static function stringRow(array $columns)
    {
        $strFields = "";

        foreach ($columns as $column){
            if (is_string($column)){
                $strFields.= "{$column}, ";
            }
            if (is_array($column)){
                $strFields.= array_keys($column)[0] . " AS {$column[array_keys($column)[0]]}, ";
            }
        }

        return empty($strFields) ? '*' : substr(trim($strFields), 0, -1);
    }

    public static function objectRow(array $columns)
    {
        $jsonObjectContent = "";

        foreach ($columns as $column){
            if (is_string($column)){
                $jsonObjectContent.= " '{$column}', {$column},";
            }
            if (is_array($column)){
                $jsonObjectContent.= " '{$column[array_keys($column)[0]]}', " . array_keys($column)[0] . ",";
            }
        }

        return substr(trim($jsonObjectContent), 0, -1);
    }
}
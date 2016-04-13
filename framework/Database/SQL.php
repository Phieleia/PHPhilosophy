<?php

namespace Phphilosophy\Database;

/**
* @author Pandoria <info@hippodora.de>
* @copyright 2015 Pandoria
* @version 0.1.0
* @package Phphilosophy
* @subpackage Database
*/
class SQL {

    /**
     * @var string
     */
    private $insert = 'INSERT INTO ';
    
    /**
     * @var string
     */
    private $select = 'SELECT ';
    
    /**
     * @var string
     */
    private $update = 'UPDATE ';
    
    /**
     * @var $string
     */
    private $delete = 'DELETE FROM ';
    
    /**
     * @var string
     */
    private $set = ' SET ';
    
    /**
     * @access private
     * @var string
     */
    private $where = 'WHERE ';
    
    /**
     * @access private
     * @var string
     */
    private $equals = ' = ';
    
    /**
     * @access private
     * @var string
     */
    private $values = ' VALUES ';
    
    /**
     * @access private
     * @var string
     */
    private $left_bracket = '(';
    
    /**
     * @access private
     * @var string
     */
    private $right_bracket = ')';

    /**
     * @access private
     * @var string
     */
    private $from = ' FROM ';
    
    /**
     * @access private
     * @var string
     */
    private $and = ' AND ';
    
    /**
     * @access private
     * @var string
     */
    private $comma = ', ';
    
    /**
     * @access private
     * @var string
     */
    private $all = '*';
    
    /**
     * @access private
     * @var string
     */
    private $backtick = '`';
    
    /**
    * Check: OK
    * Wraps backticks around a table or column name
    * Before: tablename - After: `tablename`;
    * @access public
    * @param string $value
    * @return string
    */
    public function addBackticks($value)
    {
        $snippet = $this->backtick.$value.$this->backtick;
        return $snippet;
    }
    
    /**
    * Check: OK
    * Wraps every element of an array in backticks by using for.
    * @access public
    * @param array $values
    * @return array
    */
    public function arrayBackticks(array $values = [])
    {
        $elements = count($values);
        $array = [];
        
        for ($i = 0; $i < $elements; $i++) {
            $array[$i] = $this->addBackticks($values[$i]);
        }
        return $array;
    }
    
    /**
    * Check: OK
    * Chains all elemts of an array and seperates them with commas
    * @access public
    * @param array $values
    * @return string
    */
    public function addCommas(array $values)
    {
        $elements = count($values);
        $count = $elements + 1;
        
        for ($i = 0; $i < $count; $i++)
        {
            if ($i == 0 && $i !== $elements) {
                $snippet = $values[$i].$this->comma;
            } elseif ($i > 0 && $i < $elements - 1 && $i !== $elements) {
                $snippet = $snippet.$values[$i].$this->comma;
            } else {
                $snippet = $snippet.$values[$elements - 1];
            }
        }
        return $snippet;
    }
    
    /**
    * Check: OK
    * A string is wrapped in brackets
    * @access public
    * @param string $value
    * @return string
    */
    public function addBrackets($value) {
        return '('.$value.')';
    }
    
    /**
    * Check: OK
    * Create placeholders for hardcoded prepared statements
    * @access public
    * @param string $fieldname
    * @return string
    */
    public function createPlaceholder($fieldname)
    {
        $placeholder = ':'.$fieldname;
        return $placeholder;
    }
    
    /**
    * @access public
    * @param string $values
    * @return string
    */
    public function equalPlaceholder($values)
    {
        if (is_array($values))
        {
            $elements = count($values);
            $count = $elements + 1;
            $snippet = '';
            
            for ($i = 0; $i < $count; $i++) {
                if ($i >= 0 && $i < $elements - 1 && $i !== $elements) {
                    $snippet = $snippet.$this->addBackticks($values[$i]).' = ';
                    $snippet = $snippet.$this->createPlaceholder($values[$i]).', ';
                } else {
                    $snippet = $snippet.$this->addBackticks($values[$elements - 1]);
                    $snippet = $snippet.' = '.$this->createPlaceholder($values[$elements - 1]);
                }
            }
            return $snippet;
        }
        return $this->addBackticks($values).' = '.$this->createPlaceholder($values);
    }
    
    /**
    * Adds WHERE
    * @access public
    * @param array|string $columns
    * @param array|string $operators
    * @return string
    */
    public function addWhere($columns, $operators)
    {
        // Compare one
        if (is_array($columns))
        {
            // Number of columns
            $cleanColumns = $this->arrayBackticks($columns);
            $elements = count($columns);
            $snippet = '';
            
            for ($i = 0; $i < $elements; $i++) {
                
                // First element
                if ($i == 0) {
<<<<<<< HEAD
                    $snippet = 'WHERE '.$cleanColumns[$i];
                } else  {
                    $snippet = $snippet.$this->and.$cleanColumns[$i];
=======
                    $snippet = $this->where.$this->addBackticks($columns[$i]);
                    $snippet = $snippet.' '.$operators[$i].' '.$this->createPlaceholder($columns[$i]);
                } else {
                    $snippet = $snippet.$this->and.$this->addBackticks($columns[$i]);
                    $snippet = $snippet.' '.$operators[$i].' '.$this->createPlaceholder($columns[$i]);
>>>>>>> origin/master
                }
                $snippet = $snippet.' '.$operators[$i].' '.$this->createPlaceholder($columns[$i]);
            }
            
            return $snippet;
        }
        
        return $this->where.$this->addBackticks($columns).' '.$operators.' '.$this->createPlaceholder($columns);
    }
    
    /**
    * ------------------------------
    * === SQL STATEMENT BUILDING ===
    * ------------------------------
    */
    
    /**
    * Creates SELECT for retrieving a single column: 
    * SELECT `id` FROM `users`
    * @access public
    * @param string $column
    * @param string $table
    * @return string
    */
    public function selectOne($column, $table)
    {
        $snippet = $this->select.$this->addBackticks($column);
        $snippet = $snippet.$this->from.$this->addBackticks($table);
        return $snippet;
    }
    
    /**
    * Selects every column through: 
    * SELECT * FROM `users`
    * @access public
    * @param string $table
    * @return string
    */
    public function selectAll($table)
    {
        $snippet = $this->select.$this->all.$this->from.$this->addBackticks($table);
        return $snippet;
    }
    
    /**
    * Creates a SQL such as: 
    * SELECT `id`, `username` FROM `users`
    * @access public
    * @param array $columns
    * @param string $table
    * @return string
    */
    public function selectMany(array $columns, $table)
    {
        $clean_columns = $this->arrayBackticks($columns);
        $snippet = $this->select.$this->addCommas($clean_columns).$this->from.$this->addBackticks($table);
        return $snippet;
    }
    
    /**
    * selectOne, selectAll and selectMany combined
    * @access public
    * @param $columns mixed
    * @param $table string
    * @return string
    */
    public function select($columns, $table)
    {
        // All or one column
        if (!is_array($columns)) {
            // All columns
            if ($columns == '*') {
                return $this->selectAll($table);
            }
            // One column
            return $this->selectOne($columns, $table);
        }
        return $this->selectMany($columns, $table);
    }
    
    /**
    * Chains select() and addWhere()
    * @access public
    * @param array|string $params
    * @param string $table
    * @param array|string $wheres
    * @param array|string $operators
    */
    public function selectWhere($columns, $table, $wheres, $operators) {
        return $this->select($columns, $table).' '.$this->addWhere($wheres, $operators);
    }
    
    /**
    * Updates existing database entries
    * @access public 
    * @param string $table
    * @param array|string $columns
    * @param array|string $wheres
    * @param array|string $operators
    * @return string
    */
    public function update($table, $columns, $wheres, $operators)
    {
        $snippet = $this->update.$this->addBackticks($table).$this->set.$this->equalPlaceholder($columns);
        $snippet = $snippet.' '.$this->addWhere($wheres, $operators);
        return $snippet;
    }
    
    /**
    * Deletes an existing database entry
    * @access public
    * @param string $table
    * @param array|string $wheres
    * @param array|string $operators
    * @return string
    */
    public function delete($table, $wheres, $operators) {
        return $this->delete.$this->addBackticks($table).' '.$this->addWhere($wheres, $operators);
    }
    
    /**
    * @access public
    * @param string $table
    * @param array|string $columns
    */
    public function insert($table, $columns)
    {
        $snippet = $this->insert.$this->addBackticks($table).' ';

        // Add the same number of placeholders
        if (is_array($columns))
        {
            $snippet = $snippet.$this->addBrackets($this->addCommas($this->arrayBackticks($columns)));
            $snippet = $snippet.$this->values;
            // Number of columns
            $elements = count($columns);
            
            for ($i = 0; $i < $elements; $i++) {
                
                // First element opens the brackets
                if ($i === 0) {
                    $snippet = $snippet.'('.$this->createPlaceholder($columns[$i]);
                } else {
                    $snippet = $snippet.$this->comma.$this->createPlaceholder($columns[$i]);
                }
            }
            
            // closes brackets
            return $snippet.')';
        }
        
        $snippet = $snippet.$this->values;
        $snippet = $snippet.$this->addBrackets($this->addBackticks($columns));
        return $snippet.$this->createPlaceholder($columns);
    }
}
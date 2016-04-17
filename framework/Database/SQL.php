<?php

namespace Phphilosophy\Database;

/**
 * Phphilosophy SQL builder class
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class SQL {
    
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
     * @var string
     */
    private $where = 'WHERE ';
    
    /**
     * @var string
     */
    private $values = ' VALUES ';

    /**
     * @var string
     */
    private $from = ' FROM ';
    
    /**
     * @var string
     */
    private $and = ' AND ';
    
    /**
     * @var string
     */
    private $comma = ', ';
    
    /**
     * @var string
     */
    private $all = '*';
    
    /**
     * @var string
     */
    private $backtick = '`';
    
    /**
     * @param   string  $value
     *
     * @return  string
     */
    private function addBackticks($value) {
        return $this->backtick.$value.$this->backtick;
    }
    
    /**
     * @param   array   $values
     *
     * @return  array
     */
    private function arrayBackticks(array $values) {
        return array_map([$this, 'addBackticks'], $values);
    }
    
    /**
     * @param   array   $values
     *
     * @return  string
     */
    private function addCommas(array $values) {
        return implode(', ', $values);
    }
    
    /**
    * @param string $value
    * @return string
    */
    private function addBrackets($value) {
        return '('.$value.')';
    }
    
    /**
     * @param   string  $fieldname
     *
     * @return  string
     */
    public function createPlaceholder($fieldname, $number) {
        return ':'.$fieldname.'_'.$number;
    }
    
    /**
     * @param   array   $fields
     *
     * @return  array
     */
    public function arrayPlaceholders($fields, $suffix = 'w')
    {
        $elements = count($fields);
        
        for ($i = 0; $i < $elements; $i++) {
            $fields[$i] = $this->createPlaceholder($fields[$i], $i).$suffix;
        }
        
        return $fields;
    }
    
    /**
     * @param   string  $is
     * @param   string  $like
     *
     * @return  string
     */
    private function createEquals($is, $like) {
        return $is.' = '.$like;
    }
    
    /**
     * @param   array   $is
     * @param   array   $like
     *
     * @return  array
     */
    public function arrayEquals(array $is, array $like) {
        return array_map([$this, 'createEquals'], $is, $like);
    }
    
    /**
     * @param   string  $values
     *
     * @return  string
     */
    public function equalPlaceholder($values, $suffix = 'w')
    {
        if (is_array($values))
        {
            $fields = $this->arrayBackticks($values);
            $placeholders = $this->arrayPlaceholders($values, $suffix);
            $equals = $this->arrayEquals($fields, $placeholders);
            return $this->addCommas($equals);
        }
        return $this->addBackticks($values).' = '.$this->createPlaceholder($values, 0).$suffix;
    }
    
    /**
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
                    $snippet = 'WHERE '.$cleanColumns[$i];
                } else  {
                    $snippet = $snippet.$this->and.$cleanColumns[$i];
                }
                $snippet = $snippet.' '.$operators[$i].' '.$this->createPlaceholder($columns[$i], $i).'w';
            }
            return $snippet;
        }
        
        return $this->where.$this->addBackticks($columns).' '.$operators.' '.$this->createPlaceholder($columns, 0).'w';
    }
    
    /**
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
    * @param string $table
    * @return string
    */
    public function selectAll($table)
    {
        $snippet = $this->select.$this->all.$this->from.$this->addBackticks($table);
        return $snippet;
    }
    
    /**
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
    * @param array|string $params
    * @param string $table
    * @param array|string $wheres
    * @param array|string $operators
    */
    public function selectWhere($columns, $table, $wheres, $operators) {
        return $this->select($columns, $table).' '.$this->addWhere($wheres, $operators);
    }
    
    /**
    * @param string $table
    * @param array|string $columns
    * @param array|string $wheres
    * @param array|string $operators
    * @return string
    */
    public function update($table, $columns, $wheres, $operators)
    {
        $snippet = $this->update.$this->addBackticks($table).$this->set.$this->equalPlaceholder($columns, 'c');
        $snippet = $snippet.' '.$this->addWhere($wheres, $operators);
        return $snippet;
    }
    
    /**
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
        $snippet = 'INSERT INTO '.$this->addBackticks($table).' ';

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
                    $snippet = $snippet.'('.$this->createPlaceholder($columns[$i], $i).'c';
                } else {
                    $snippet = $snippet.$this->comma.$this->createPlaceholder($columns[$i], $i).'c';
                }
            }
            
            // closes brackets
            return $snippet.')';
        }
        
        $snippet = $snippet.$this->values;
        $snippet = $snippet.$this->addBrackets($this->addBackticks($columns));
        return $snippet.$this->createPlaceholder($columns, 0).'c';
    }
}
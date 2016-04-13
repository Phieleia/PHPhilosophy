<?php

namespace Phphilosophy\Database;

/**
 * Phphilosophy Query Builder class
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Query {
    
    /**
     * @var \Phphilosophy\Database\SQL
     */
    private $sql;
    
    /**
     * @param   string  $name
     */
    public function __construct($name = null)
    {
        $this->sql = new SQL();
        DB::connect($name);
    }
    
    /**
     * @param   array|string    $columns
     * @param   string          $table
     * @return  array
     */
    public function select($columns, $table)
    {
        $sql = $this->sql->select($columns, $table);
        return DB::select($sql);
    }
    
    /**
     * @param   array|string    $columns
     * @param   string          $table
     * @param   array|string    $wheres
     * @param   array|string    $operators
     * @param   array|string    $likes
     * @return  array
     */
    public function selectWhere($columns, $table, $wheres, $operators, $likes)
    {
        // Prepare the statement
        $sql = $this->sql->selectWhere($columns, $table, $wheres, $operators);
        
        $wheres = (array) $wheres;
        $likes = (array) $likes;
        $wheres = $this->sql->arrayPlaceholders($wheres);
        
        $params = [];
        $params = array_combine($wheres, $likes);
        
        return DB::select($sql, $params);
    }
    
    /**
     * @param   string          $table
     * @param   string|array    $columns
     * @param   string|array    $values
     */
    public function insert($table, $columns, $values)
    {
        // Prepare the SQL statement
        $sql = $this->sql->insert($table, $columns);
        
        $columns = (array) $columns;
        $values = (array) $values;
        
        $params = [];
        $params = array_combine($columns, $values);
        
        return DB::insert($sql, $params);
    }
    
    /**
    * @param string $table
    * @param string|array $columns
    * @param string|array $values
    * @param string|array $wheres
    * @param array|string $operators
    * @param string|array $likes
    */
    public function update($table, $columns, $values, $wheres, $operators, $likes)
    {
        $sql = $this->sql->update($table, $columns, $wheres, $operators);
        
        $columns = (array) $columns;
        $values = (array) $values;
        
        $params = [];
        $params[] = array_combine($columns, $values);
        
        $wheres = (array) $wheres;
        $likes = (array) $likes;
        $params[] = array_combine($wheres, $likes);
        
        return DB::update($sql, $params);
    }
    
    /**
    * @access public
    * @param string $table
    * @param array|string $wheres
    * @param array|string $operators
    * @param array|string $likes
    */
    public function delete($table, $wheres, $operators, $likes)
    {
        $sql = $this->sql->delete($table, $wheres, $operators);
        
        $wheres = (array) $wheres;
        $likes = (array) $likes;
        
        $params = [];
        $params = array_combine($wheres, $likes);
        
        return DB::delete($sql, $params);
    }
}
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
     *
     * @return  mixed
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
     *
     * @return  mixed
     */
    public function selectWhere($columns, $table, $wheres, $operators, $likes)
    {
        // Prepare the statement
        $sql = $this->sql->selectWhere($columns, $table, $wheres, $operators);
        $params = $this->mergeParams($wheres, $likes);
        
        return DB::select($sql, $params);
    }
    
    /**
     * @param   string          $table
     * @param   array           $insert
     *
     * @return  int
     */
    public function insert($table, array $insert)
    {
        $columns = array_keys($insert);
        $values = array_values($insert);
        
        // Prepare the SQL statement
        $sql = $this->sql->insert($table, $columns);
        $params = $this->mergeParams($columns, $values, 'c');
        
        return DB::insert($sql, $params);
    }
    
    /**
     * @param   string          $table
     * @param   array           $insert
     * @param   array|string    $wheres
     * @param   array|string    $operators
     * @param   array|string    $likes
     *
     * @return  int
     */
    public function update($table, array $insert, $wheres, $operators, $likes)
    {
        $columns = array_keys($insert);
        $values = array_values($insert);
        
        $sql = $this->sql->update($table, $columns, $wheres, $operators);

        $params1 = $this->mergeParams($columns, $values, 'c');
        $params2 = $this->mergeParams($wheres, $likes);
        $params = array_merge($params1, $params2);
        
        return DB::update($sql, $params);
    }
    
    /**
     * @param   string          $table
     * @param   array|string    $wheres
     * @param   array|string    $operators
     * @param   array|string    $likes
     *
     * @return  int
     */
    public function delete($table, $wheres, $operators, $likes)
    {
        $sql = $this->sql->delete($table, $wheres, $operators);
        $params = $this->mergeParams($wheres, $likes);
        
        return DB::delete($sql, $params);
    }
    
    /**
     * @param   array|string    $columns
     * @param   array|string    $rows
     * @param   string          $suffix
     *
     * @return  array
     */
    private function mergeParams($columns, $rows, $suffix = 'w')
    {
        $columns = (array) $columns;
        $rows = (array) $rows;
        $columns = $this->sql->arrayPlaceholders($columns, $suffix);
        
        return array_combine($columns, $rows);
    }
}
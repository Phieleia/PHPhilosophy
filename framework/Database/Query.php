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
     * @param   string  $name
     */
    public function __construct($name = null) {
        $this->sql = new SQL();
        DB::connect($name);
    }
    
    /**
     * @access public
     * @param $columns array|string
     * @param $table string
     * @return array
     */
    public function select($columns, $table) {
        $sql = $this->sql->select($columns, $table);
        return DB::select($sql);
    }
    
    /**
    * @access public
    * @param $columns array|string
    * @param $table string
    * @param $wheres array|string
    * @param array|string $operators
    * @param $likes array|string
    * @return array
    */
    public function selectWhere($columns, $table, $wheres, $operators, $likes) {
        // Prepare the statement
        $sql = $this->sql->selectWhere($columns, $table, $wheres, $operators);
        $params = array_combine($wheres, $likes);
        return DB::select($sql, $params);
    }
    
    /**
    * @access public
    * @param string $table
    * @param string|array $columns
    * @param string|array $values
    */
    public function insert($table, $columns, $values) {
        // Prepare the SQL statement
        $sql = $this->sql->insert($table, $columns);
        $params = array_combine($columns, $values);
        return DB::insert($sql, $params);
    }
    
    /**
    * @access public
    * @param string $table
    * @param string|array $columns
    * @param string|array $values
    * @param string|array $wheres
    * @param array|string $operators
    * @param string|array $likes
    */
    public function update($table, $columns, $values, $wheres, $operators, $likes) {
        $sql = $this->sql->update($table, $columns, $wheres, $operators);
        $params[] = array_combine($columns, $values);
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
    public function delete($table, $wheres, $operators, $likes) {
        $sql = $this->sql->delete($table, $wheres, $operators);
        $params = array_combine($wheres, $likes);
        return DB::delete($sql, $params);
    }
}
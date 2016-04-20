<?php

namespace Phphilosophy\Database;

/**
 * Phphilosophy base model class
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Model {
    
    /**
     * @var \Phphilosophy\Database\Query
     */
    protected $query;
    
    /**
     * @var string
     */
    protected $table;
    
    /**
     * @param   string  $table
     * @param   string  $name
     */
    public function __construct($table, $name = null)
    {
        $this->query = new Query($name);
        $this->table = $table;
    }
    
    /**
     * @return  mixed
     */
    protected function getAll() {
        return $this->query->select('*', $this->table);
    }
    
    /**
     * @param   array   $columns
     *
     * @return  mixed
     */
    protected function select($columns) {
        return $this->query->select($columns, $this->table);
    }
    
    /**
     * @param   array|string    $columns
     * @param   array|string    $wheres
     * @param   array|string    $operators
     * @param   array|string    $likes
     *
     * @return  mixed
     */
    protected function selectWhere($columns, $wheres, $operators, $likes) {
        return $this->query->selectWhere($columns, $this->table, $wheres, $operators, $likes);
    }
    
    /**
     * @param   array   $inserts
     *
     * @return  int
     */
    protected function insert(array $inserts) {
        $this->query->insert($this->table, $inserts);
    }
    
    /**
     * @param   array           $inserts
     * @param   array|string    $wheres
     * @param   array|string    $operators
     * @param   array|string    $likes
     *
     * @return  int
     */
    protected function update(array $inserts, $wheres, $operators, $likes) {
        return $this->query->update($this->table, $inserts, $wheres, $operators, $likes);
    }
    
    /**
     * @param   array|string    $wheres
     * @param   array|string    $operators
     * @param   array|string    $likes
     *
     * @return  int
     */
    protected function delete($wheres, $operators, $likes) {
        return $this->query->delete($this->table, $wheres, $operators, $likes);
    }
}
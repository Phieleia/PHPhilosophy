<?php

namespace Phphilosophy\Database;

use Phphilosophy\Application\Config;

/**
 * Phphilosophy Database access class
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class DB {
    
    /**
     * @var \Phphilosophy\Database\Connection
     */
    private static $connection;
    
    /**
     * @param   null|string $name
     * @return  void
     */
    public static function connect($name = null)
    {
        if (is_null($name)) {
            $name = 'default';
        }
        
        if (is_null(self::$connection)) {
            $config = Config::get('database');
            self::$connection = new Connection($config[$name]);
        }
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     * @return  void
     */
    public static function select($sql, array $params = null) {
        $result = self::query($sql, $params);
        return $result->fetchAll(\PDO::FETCH_CLASS, 'stdClass');
    }
    
    /**
     * @param   string  $sql
     * @param   array   $params
     * @return  void
     */
    public static function insert($sql, array $params = null) {
        return self::cud($sql, $params);
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     * @return  void
     */
    public static function update($sql, array $params = null) {
        return self::cud($sql, $params);
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     * @return  void
     */
    public static function delete($sql, array $params = null) {
        return self::cud($sql, $params);
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     * @return  void
     */
    private function cud($sql, array $params = null) {
        if (is_null($params)) {
            return $this->execute($sql);
        }
        return $this->query($sql, $params)->rowCount();
    }
    
    /**
     * @param   string      $sql
     * @param   null|array  $params
     * @return  \PDOStatement
     */
    private function query($sql, array $params = null)
    {
        if (is_null($params)) {
            return self::$connection->query($sql);
        }
        return self::$connection->preparedStmt($sql, $params);
    }
    
    /**
     * @param   string  $sql
     * @return  int
     */
    private function execute($sql) {
        return self::$connection->execute($sql);
    }
    
    /**
     * @return  void
     */
    public static function disconnect() {
        self::$connection = null;
    }
}
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
     * @var int
     */
    private static $fetchMode = \PDO::FETCH_CLASS;
    
    /** 
     * @var string
     */
    private static $fetchClass = 'stdClass';
    
    /**
     * @param   null|string $name
     *
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
     * @param   int     $mode
     * @param   string  $class
     *
     * @return  void
     */
    public static function setFetchMode($mode, $class)
    {
        self::$fetchMode = $mode;
        self::$fetchClass = $class;
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     *
     * @return  mixed
     */
    public static function select($sql, array $params = null)
    {
        $result = self::query($sql, $params);
        return $result->fetchAll(self::$fetchMode, self::$fetchClass);
    }
    
    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public static function insert($sql, array $params = null) {
        return self::cud($sql, $params);
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     *
     * @return  int
     */
    public static function update($sql, array $params = null) {
        return self::cud($sql, $params);
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     *
     * @return  int
     */
    public static function delete($sql, array $params = null) {
        return self::cud($sql, $params);
    }
    
    /**
     * @param   string      $sql
     * @param   array       $params
     *
     * @return  int
     */
    private static function cud($sql, array $params = null)
    {
        if (is_null($params)) {
            return self::execute($sql);
        }
        return self::query($sql, $params)->rowCount();
    }
    
    /**
     * @param   string      $sql
     * @param   null|array  $params
     *
     * @return  \PDOStatement
     */
    private static function query($sql, array $params = null)
    {
        if (is_null($params)) {
            return self::$connection->query($sql);
        }
        return self::$connection->preparedStmt($sql, $params);
    }
    
    /**
     * @param   string  $sql
     *
     * @return  int
     */
    private static function execute($sql) {
        return self::$connection->execute($sql);
    }
    
    /**
     * @return  void
     */
    public static function disconnect() {
        self::$connection = null;
    }
}
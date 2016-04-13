<?php

namespace Phphilosophy\Database;

/**
 * Phphilosophy Database Connection
 *
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2015-2016 Lisa Saalfrank
 * @license	http://opensource.org/licenses/MIT MIT License
 * @since       0.1.0
 * @version     0.1.0
 * @package     Phphilosophy
 */
class Connection {
    
    /**
     * @var \PDO
     */
    private $pdo;
    
    /**
     * @param   array   $config
     */
    public function __construct(array $config) {
        $this->connect($config);
    }
    
    /**
     * @var  array   $config
     */
    private function connect(array $config)
    {
        // Build DSN
        $dns = 'mysql:host='.$config['host'].';dbname='.$config['name'];
        
        // Set options
        $options = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$config['char']
        );
        
        // Create new PDO object
        $this->pdo = new \PDO($dns, $config['user'], $config['password'], $options);
    }
    
    /**
     * @param   string      $sql
     * @param   array|null  $params
     * @return  \PDOStatement
     */
    public function preparedStmt($sql, array $params) 
    {
        // Prepare SQL
        $sql = trim($sql);
        $stmt = $this->pdo->prepare($sql);
        
        // Bind parameters
        $names = array_keys($params);
        $elements = count($names);
        
        for ($i = 0; $i < $elements; $i++) {
            $stmt->bindParam(':'.ltrim($names[$i],':'), $params[$names[$i]]);
        }
        
        // Execute statement and return
        $stmt->execute();
        return $stmt;
    }
    
    /**
     * @param   string  $sql
     * @return  \PDOStatement
     */
    public function query($sql)
    {
        $sql = trim($sql);
        $stmt = $this->pdo->query($sql);
        return $stmt;
    }
    
    /**
     * @param   string  $sql
     * @return  int
     */
    public function execute($sql)
    {
        $sql = trim($sql);
        $rows = $this->pdo->exec($sql);
        return $rows;
    }
}
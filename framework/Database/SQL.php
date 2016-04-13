<?php

	namespace Phphilosophy\Database;
	
	/**
	* A class which builds SQL statements for building queries.
	* It will utilize named prepared statements only to reduze 
	* the amount of vulnerabilities and it will be combined with
	* and is built for PHPs PDO. It will be used in PHPhilosophy's 
	* Query class for executing database requests in one line of code.
	*
	* === EXAMPLE USAGE ===
	* -----------------------------------------------------------------
	* <?php
	* use PHPhilosophy\Database\SQL;
	* 
	* $sql = new SQL();
	*
	* // SELECT * FROM `users`
	* $userdata = $sql->select('*', 'users');
	* // SELECT `id` FROM `users`
	* $user_ids = $sql->select('id', 'users');
	* // SELECT `id`, `username` FROM `users`
	* $users = $sql->select(['id', 'username'], 'users'); 
	* // SELECT * FROM `users` WHERE `id` LIKE :id
	* $users = $sql->selectWhere('*', 'users', 'id', 'LIKE');
	*
	* // UPDATE `users` SET `username` = :username, `email` = :email WHERE `id` LIKE :id
	* $users = $sql->update('users', ['username', 'email'], 'id', 'LIKE');
	* 
	* // DELETE FROM `users` WHERE `id` LIKE :id AND `username` LIKE :username
	* $sql->delete('users', ['id', 'username'], ['LIKE', 'LIKE']);
	*
	* // INSERT INTO `users` (`id`, `username`, `password`, `email`, `status`) VALUES (:id, :username, :password, :email, :status)
	* $sql->insert('users', ['id', 'username', 'password', 'email', 'status']);
	* ?>
	* -----------------------------------------------------------------
	* 
	* @author Pandoria <info@hippodora.de>
	* @copyright 2015 Pandoria
	* @version 0.1.0
	* @package Phphilosophy
	* @subpackage Database
	*/
	class SQL {
	
		/**
		* ------------------------------
		* === SQL LANGUAGE FRAGMENTS ===
		* ------------------------------
		*/
		
		/**
        * @access private
        * @var string
        */
        private $insert = 'INSERT INTO ';
		
		/**
        * @access private
        * @var string
        */
        private $select = 'SELECT ';
		
		/**
        * @access private
        * @var $string
        */
        private $update = 'UPDATE ';
		
        /**
        * @access private
        * @var $string
        */
        private $delete = 'DELETE FROM ';
		
		/**
        * @access private
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
		* ----------------------------
		* === SQL SHORTCUT METHODS ===
		* ----------------------------
		*/
		
		/**
		* Check: OK
        * Wraps backticks around a table or column name
        * Before: tablename - After: `tablename`;
        * @access public
        * @param string $value
        * @return string
        */
        public function addBackticks($value) {
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
        public function addCommas(array $values) {
            $elements = count($values);
            $count = $elements + 1;
			
            for ($i = 0; $i < $count; $i++) {
				
                if ($i == 0 && $i !== $elements) {
                    $snippet = $values[$i].$this->comma;
                } 
				
                if ($i > 0 && $i < $elements - 1 && $i !== $elements) {
                    $snippet = $snippet.$values[$i].$this->comma;
                }
				
                if ($i == $elements) {
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
            return $this->left_bracket.$value.$this->right_bracket;
        }
		
		/**
		* Check: OK
		* Create placeholders for hardcoded prepared statements
		* @access public
		* @param string $fieldname
		* @return string
		*/
		public function createPlaceholder($fieldname) {
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
            if (is_array($values)) {
				
                $elements = count($values);
                $count = $elements + 1;
				
                for ($i = 0; $i < $count; $i++) {
                    
                    if ($i == 0 && $i !== $elements) {
                        $snippet = $this->addBackticks($values[$i]).$this->equals;
                        $snippet = $snippet.$this->createPlaceholder($values[$i]).$this->comma;
                    } 
					
                    if ($i > 0 && $i < $elements - 1 && $i !== $elements) {
                        $snippet = $snippet.$this->addBackticks($values[$i]).$this->equals;
                        $snippet = $snippet.$this->createPlaceholder($values[$i]).$this->comma;
                    }
					
                    if ($i == $elements) {
                        $snippet = $snippet.$this->addBackticks($values[$elements - 1]);
                        $snippet = $snippet.$this->equals.$this->createPlaceholder($values[$elements - 1]);
                    }
                }
                return $snippet;
            }
            return $this->addBackticks($values).$this->equals.$this->createPlaceholder($values);
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
                $elements = count($columns);
                $snippet = '';
				
                for ($i = 0; $i < $elements; $i++) {
					
                    // First element
                    if ($i == 0) {
                        $snippet = $this->where.$this->addBackticks($columns[$i]);
						$snippet = $snippet.' '.$operators[$i].' '.$this->createPlaceholder($columns[$i]);
                    } else  {
                        $snippet = $snippet.$this->and.$this->addBackticks($columns[$i]);
                        $snippet = $snippet.' '.$operators[$i].' '.$this->createPlaceholder($columns[$i]);
                    }
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
        public function selectOne($column, $table) {
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
        public function selectAll($table) {
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
        public function selectMany(array $columns, $table) {
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
        public function select($columns, $table) {
			
            // Many columns
            if (is_array($columns)) {
                return $this->selectMany($columns, $table);
            }
			
            // All or one column
            if (is_array($columns) === false) {
				
                // All columns
                if ($columns == '*') {
                    return $this->selectAll($table);
                }
				
                // One column
                return $this->selectOne($columns, $table);
            }
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
        public function update($table, $columns, $wheres, $operators) {
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
		public function insert($table, $columns) {
			
			$snippet = $this->insert.$this->addBackticks($table).' ';
			
			// if many column names shall be inserted
			if (is_array($columns)) {
				$snippet = $snippet.$this->addBrackets($this->addCommas($this->arrayBackticks($columns)));
			} else {
				$snippet = $snippet.$this->addBrackets($this->addBackticks($columns));
			}
			
			// add value keyword
			$snippet = $snippet.$this->values;
			
			// Add the same number of placeholders
			if (is_array($columns)) {
				
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
				$snippet = $snippet.')';
			}

			// if just one element simple add (?)
			if (is_array($columns) === false) {
				$snippet = $snippet.$this->createPlaceholder($columns);
			}
			
			return $snippet;
		}
	}
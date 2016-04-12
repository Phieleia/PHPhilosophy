<?php

	namespace Phphilosophy\Database;
	
	/**
	* The Model Class which will be utilized to seperate the database 
	* from business logic
	*
	* @author Pandoria <info@hippodora.de>
	* @copyright 2015 Pandoria
	* @version 0.1.0
	* @package Phphilosophy
	* @subpackage Database
	*/
	class Model {
		
		/**
		* @access protected
		* @var Phphilosophy\Database\Query
		*/
		protected $query;
		
		/**
		* @access protected
		* @var string
		*/
		protected $table;
		
		/**
		* @access public
		* @param array $database
		* @param string $table
		*/
		public function __construct($table, $name = null) {
			$this->query = new Query($name);
			$this->table = $table;
		}
		
		/**
		* Method to retrieve everything from a database table
		* @access protected
		* @return array
		*/
		protected function getAll() {
			return $this->query->select('*', $this->table);
		}
		
		/**
		* @access protected
		* @param string|array $columns
		* @param string $table
		* @return array
		*/
		protected function select($columns) {
			return $this->query->select($columns, $this->table);
		}
		
		/**
		* @access protected
		* @param string|array $columns
		* @param string|array $wheres
		* @param array|string $operators
		* @param string|array $likes
		* @return array 
		*/
		protected function selectWhere($columns, $wheres, $operators, $likes) {
			return $this->query->selectWhere($columns, $this->table, $wheres, $operators, $likes);
		}
		
		/**
		* @access protected
		* @param string|array $columns
		* @param string|array $values
		*/
		protected function insert($columns, $values) {
			$this->query->insert($this->table, $columns, $values);
		}
		
		/**
		* @access protected
		* @param string|array $columns
		* @param string|array $values
		* @param string|array $wheres
		* @param array|string $operators
		* @param string|array $likes
		*/
		protected function update($columns, $values, $wheres, $operators, $likes) {
			return $this->query->update($this->table, $columns, $values, $wheres, $operators, $likes);
		}
		
		/**
		* @access protected
		* @param string|array $wheres
		* @param array|string $operators
		* @param string|array $likes
		*/
		protected function delete($wheres, $operators, $likes) {
			return $this->query->delete($this->table, $wheres, $operators, $likes);
		}
	}
<?php
class DB {
  private static $_instance = null;
  private $_pdo, $_query, $_error = false, $_results, $_count = 0;

  // Connect to database
  private function __construct() {
    try {
      // line of connection to db
      $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
    }
    // Catch error and die if where are any
    catch(PDOException $e) {
      die($e->getMessage());
    }
  }

  // Check if bd object is allready instantiated
  public static function getInstance() {
    // Check if instance exists
    if(!isset(self::$_instance)) {
      // Create an instance
      self::$_instance = new DB();
    }
    // Return instance
    return self::$_instance;
  }

  // Query db method
  public function query($sql, $params = array()) {
    $this->_error = False;

    // Run pdo prepare method
    if($this->_query = $this->_pdo->prepare($sql)) {

      // Check if parameters exists
      if(count($params)) {
        $x = 1;
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }

      // Execute Query
      if($this->_query->execute()) {
        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
        $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = True;
      }
    }
    return $this;
  }

  // Method to return errors
  public function error(){
    return $this->_error;
  }

  // Action method performed on database
  public function action($action, $table, $where = array()) {

    // Check if the count of where is equal to three
    // becouse I need a flied an operator and a value
    if(count($where) === 3) {

      // List of operator that are allow
      $operators = array('=', '<', '>', '>=', '<=');

      // Extract data from where
      $flied    = $where[0];
      $operator = $where[1];
      $value    = $where[2];

      // Check if operator is allowed
      if(in_array($operator, $operators)) {

        // Construct query
        $sql = "{$action} FROM {$table} WHERE {$flied} {$operator} ?";

        // Use query method to perform a query
        if(!$this->query($sql, array($value))->error()) {
          return $this;
        }
      }
    }
    return False;
  }

  // Method to get data from db
  public function get($table, $where) {
    // Call action method this specified action
    return $this->action('SELECT *', $table, $where);
  }

  // Method to insert data in db
  public function insert($table, $fields = array()) {
    // Check if fields array is not empthy
    if(count($fields)) {
      // Array of keys from flieds
      $keys = array_keys($fields);
      $values = '';

      // Iteration from building values string 
      for($x = 1; $x <= count($fields); $x++) {
        $x == count($fields) ? $values .= '?' : $values .= '?, ';
      }

      // Insert sql query structure
      $sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

      // Query db and check if there is no errors
      if(!$this->query($sql, $fields)->error()) return True;
      // In case of errors return false
      return False;
    }
    // In case fields array is emthy return false
    return False;
  }

  // Method to return query result
  public function results() {
    return $this->_results;
  }

  // Method to return first resolt from resolt array
  public function first() {
    return $this->results()[0];
  }

  // Method to delete data from db
  public function delete($table, $where) {
    // Call action method this specified action
    return $this->action('DELETE', $table, $where);
  }

  // Method to return resolt count
  public function count() {
    return $this->_count;
  }

}

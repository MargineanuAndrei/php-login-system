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
    $this->_error = false;

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
        $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
        $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = true;
      }
    }
    return $this;
  }

  // Method to return errors
  public function error(){
    return $this->_error;
  }
}

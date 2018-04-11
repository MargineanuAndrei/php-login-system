<?php
class DB {
  private static $_instance = null;
  private $_pdo, $_query, $_error = false, $_results, $_count = 0;

  // Connect to database
  private function __construct() {
    try {
      // line of connection to db
      $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
      echo 'Connected';
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
}

<?php
// Start a session
session_start();

// Define glogal config variable
$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => 'Andrei738380',
    'db' => 'login'
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'session_name' => 'user'
  )
);

// This function runs each time class is accessed
spl_autoload_register(function($class){
  require_once 'classes/'.$class.'.php';
});

// Include functions
require_once 'functions/sanitize.php';

<?php
require_once 'core/init.php';

$user = DB::getInstance()->query("SELECT username FROM users WHERE username = ?", array('billy'));

if(!$user->count()) {
  echo 'No user';
} else {
  echo 'Ok';
}

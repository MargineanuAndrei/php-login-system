<?php
require_once 'core/init.php';

$user = DB::getInstance()->insert('users', array(
	'username' => 'Ion',
	'password' => 'password',
	'salt' => 'salt'
));

<?php
class Session {
	# Check is session exists
	public static function exists($name) {
		return (isset($_SESSION[$name])) ? True : False;
	}

	# Return the value of the  session
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

	# Get session value
	public static function get($name) {
		return $_SESSION[$name];
	}

	# Delete a session
	public static function delete($name) {
		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}
}
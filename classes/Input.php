<?php
class Input {
	# Method to check if type exists 
	public static function exists($type = 'post') {
		# Switch with posible types
		switch ($type) {
			case 'post':
				return (empty($_POST)) ? False : True;
			break;
			
			case 'get':
				return (empty($_GET)) ? False : True;
			break;
			
			default:
				return False;
			break;
		}
	}

	# Method to get data from form
	public static function get($item) {
		if(isset($_POST[$item])) return $_POST[$item];
		if (isset($_GET[$item])) return $_GET[$item];
		return '';
	}
}
<?php 
class Token {
	# Method to generate uniq token
	public static function generate() {
		return Session::put(
			Config::get('session/token_name'),
			md5(uniqid())
		);
	}

	# Method to check if token exists and it's correct
	public static function check($token) {
		# Get token name from global config
		$tokenName = Config::get('session/token_name');

		# Check if token exists
		if(Session::exists($tokenName) && $token === Session::get($tokenName)) {

			Session::delete($tokenName);
			return True;
		}
		return False;
	}
}
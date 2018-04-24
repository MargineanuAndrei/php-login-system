<?php
class Validate {
	private $_passed = False, $_errors  = array(), $_db = null;

	# Constructor method (here I get instance of db)
	public function __construct(){
		$this->_db = DB::getInstance();
	}

	# Method to add error to errors array
	private function addError($error) {
		$this->_errors[] = $error;
	}

	# Method to return errors
	public function errors() {
		return $this->_errors;
	}

	# Method to return if validation is passed
	public function passed() {
		return $this->_passed;
	}

	# Method to validate input data
	public function check($source, $items = array()) {
		# Iterate through validation rules object
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				# Get value
				$value = $source[$item];

				# Check if item is required
				if($rule === 'required' && empty($value)) {
					$this->addError("${item} is required");
				}
			}
		}

		/* Check if errors is emthy 
		If errors is emthy validation have passed */
		if(empty($this->_errors)){
			$this->_passed = True;
		}

		return $this;
	}
}

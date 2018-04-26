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
				$value = trim($source[$item]);
				$item = escape($item);

				# Check if item is required
				if($rule === 'required' && empty($value)) {
					# Call add error method (in case value is empty and item is required)
					$this->addError("${item} is required");
				} else if (!empty($value)) {
					# Check all other rules
					switch ($rule) {

						# Case to check if value is smaller then rule value
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$item} must be a minimum of {$rule_value} characters");
							}
						break;

						# Case to check if value is bigar then rule value
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$item} must be a maximum of {$rule_value} characters");
							}
						break;

						# Case to check if needen flieds matches
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$rule_value} must match {$item}");
							}
						break;

						# Case to check if value is unique
						case 'unique':
							$check= $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()) {
								$this->addError("{$item} already exists");
							}
						break;
					}
				}
			}
		}

		# Check if errors is emthy, if errors is emthy validation have passed 
		if(empty($this->_errors)){
			$this->_passed = True;
		}

		return $this;
	}
}

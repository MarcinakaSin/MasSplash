<?php

class Validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		$valid_name = array();

		foreach($items as $item => $rules) { // Used to store Names for validation field names
			foreach($rules as $rule => $rule_value) {
				$rule_vlaue = trim($rule_value);

				switch($item){
					case 'username':
						$valid_name[$item] = "Username";
					break;
					case 'firt_name':
						$valid_name[$item] = "First Name";
					break;
					case 'last_name':
						$valid_name[$item] = "Last Name";
					break;
					case 'email':
						$valid_name[$item] = "E-mail";
					break;
					case 'password':
						$valid_name[$item] = "Password";
					break;
					case 'validate_password':
						$valid_name[$item] = "Confirm Password";
					break;
				}
			}
		}

		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {

				$value = trim($source[$item]);
				$item = escape($item);

				if($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required.");
				} else if(!empty($value)) {
					switch($rule) {
						// sets a min value of characters
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$valid_name[$item]} must be a minimum of {$rule_value} characters.");
							}
						break;
						// sets a max value of characters
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$valid_name[$item]} must be a max of {$rule_value} characters.");
							}
						break;
						// compares values
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$valid_name[$rule_value]} must match {$valid_name[$item]}.");
							}
						break;
						// checks db for duplicate existing records with similar values
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()) {
								$this->addError("{$valid_name[$item]} already exists.");
							}
						break;
						// checks value for spaces
						case 'nospace':
							if(preg_match("/\\s/", $value)){
								$this->addError("Your {$valid_name[$item]} must not contain any spaces.");
							}
						break;
						// checks email formatting
						case 'format':
							if($rule_value = 'email') {
								if(filter_var($value, FILTER_VALIDATE_EMAIL) === false){
									$this->addError("A valid {$valid_name[$item]} address is required.");
								}
							}
						break;
					}
				}
			}
		}

		if(empty($this->_errors)) {
			$this->_passed = true;
		}
			
		return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}

	public function output_errors($errors) {
	// Implode converts arrays into strings, appends first argument if multiple.
	//return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
		return implode('<br />', $errors);
	}
}
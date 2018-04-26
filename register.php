<?php
require_once 'core/init.php';

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		
		$validate = new Validate();

		# Validation Rules
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => True,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
			),
			'password' => array(
				'required' => True,
				'min' => 6
			),
			'password_again' => array(
				'required' => True,
				'matches' => 'password'
			),
			'name' => array(
				'required' => True,
				'min' => 2,
				'max' => 50
			),
		));

		# Check is validation passed
		if($validation->passed()) {
			echo 'Passed';
		} else {
			# Iterate through errors and display them
			foreach($validation->errors() as $errors) {
				echo $errors, '<br>';
			}
		}
	}
}

?>

<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="" autocomplete="off">
	</div>

	<div class="field">
		<label for="password_again">Repete password</label>
		<input type="password" name="password_again" id="password_again" value="" autocomplete="off">
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Register">
</form>
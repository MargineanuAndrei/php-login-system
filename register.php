<?php
require_once 'core/init.php';

if(Input::exists()) {
	
}

?>

<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="" autocomplete="off">
	</div>

	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="" autocomplete="off">
	</div>

	<div class="field">
		<label for="password_again">Repete password</label>
		<input type="password" name="password_again" id="password_again" value="" autocomplete="off">
	</div>

	<input type="submit" value="Register">
</form>
<form class="form-signin" action="" method="post">
	<div align="center">
		<h2 class="form-signin-heading"><?=DOMAIN_TITLE?> CMS</h2>
	</div>
<?
	$error = $this->Session->flash('auth');
	if ($error) {
?>
	<div class="alert alert-error"><?=$error?></div>
<?
	}
	echo $this->Form->input('User.username', array('class' => 'input-block-level', 'placeholder' => __('User name')));
	echo $this->Form->input('User.password', array('class' => 'input-block-level', 'placeholder' => __('Password')));
?>
	<label class="checkbox">
		<input type="checkbox" value="remember-me"> <?=__('Remember me')?>
	</label>
	<button class="btn btn-large btn-primary" type="submit"><?=__('Login')?></button>
</form>
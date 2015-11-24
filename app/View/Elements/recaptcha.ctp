	<div class="search_form_row">
<?
	echo $this->Recaptcha->display();
	if (isset($recaptchaError)) {
?>
		<div class="error-message" style="margin-bottom: 20px;"><?=$recaptchaError?></div>
<?
	}
?>
	</div>
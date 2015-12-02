<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, maximum-scale=1.0, initial-scale=1.0, minimum-scale=1.0">
	<?
	echo $this->Html->charset();
	echo $this->Html->css(array(
		'jquery.mCustomScrollbar.css',
		'style',
		'the-modal',
		'extra',
	));

	$aScripts = array(
		'vendor/jquery/jquery.min-1.11.1',
		'vendor/jquery/jquery.mCustomScrollbar.concat.min',
		'vendor/jquery/jquery.the-modal',
		'rego_custom',
	);
	echo $this->Html->script($aScripts);

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
</head>
<?=$this->fetch('content')?>
</html>
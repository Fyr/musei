<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css(array('bootstrap.min', 'login'));
	echo $this->Html->script(array('vendor/jquery/jquery-1.10.2.min', 'bootstrap.min'));

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
	<div class="container">
		<?php echo $this->fetch('content'); ?>	
	</div>
</body>
</html>

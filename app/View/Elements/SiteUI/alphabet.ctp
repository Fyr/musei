<?
	$url = $this->Html->url(array('controller' => 'SiteProducts', 'action' => 'index', 'objectType' => 'Product'));
?>
<div class="pull-left alphabet" style="clear:both">
	<div>
		<a href="<?=$url?>?D=1">0-9</a>&nbsp;
<?
	for($i = 65; $i <= 90; $i++) {
		$L = chr($i);
?>
		<a href="<?=$url?>?L=<?=$L?>"><?=$L?></a>
<?
	}
?>
	</div>
	<div>
<?
	$ru = 'АБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЫЭЮЯ';
	for($i = 0; $i <= mb_strlen($ru); $i++) {
		$L = mb_substr($ru, $i, 1);
?>
		<a href="<?=$url?>?L=<?=$L?>"><?=$L?></a>
<?
	}
?>

	</div>
</div>
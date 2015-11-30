<div class="logoMain">
	<img src="/img/logo.png" alt="" />
</div>
<ul class="mainMenu clearfix">
<?
	foreach($aNavBar as $id => $item) {
		$active = ($id == $currMenu) ? ' class="active"' : '';
		$url = ($item['href']) ? Router::url($item['href']) : 'javascript:void(0)';
		if ($id == 'Logo') {
?>
	<li class="logo"></li>
<?
		} else {
?>
	<li<?=$active?>><a href="<?=$url?>"><?=$item['label']?></a>
<?
			if (isset($item['submenu'])) {
?>
		<ul class="<?=$item['class']?>">
<?
				foreach($item['submenu'] as $_item) {
?>
			<li><a href="<?=Router::url($_item['href'])?>"><span><?=$_item['label']?></span><span class="arrow"></span></a></li>
<?
				}
?>
		</ul>
<?
			}
?>
	</li>
<?
		}
	}
?>
</ul>
<ul class="nav nav-pills pull-right">
<?
	foreach($aNavBar as $id => $item) {
		$class = (strtolower($id) == strtolower($currMenu)) ? ' class="active"' : '';
		$url = Router::url($item['href']);
		if (isset($item['href']['action']) && $item['href']['action'] == 'index') {
			// $url.= '/';
		}
?>
	<li<?=$class?>><a href="<?=$url?>"><?=$item['label']?></a></li>
<?
	}
?>
</ul>
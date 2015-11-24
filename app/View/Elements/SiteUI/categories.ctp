<ul class="nav nav-list bs-docs-sidenav">
	<li class="head"><?=__('Logotypes by categories')?></li>
<?
	foreach($aCategories as $article) {
		$url = SiteRouter::url($article);
		$title = $article['CategoryProduct']['title'];
		$active = (isset($category) && $category['CategoryProduct']['id'] == $article['CategoryProduct']['id']) ? 'active' : '';
?>
	<li class="<?=$active?>"><a href="<?=$url?>"><i class="icon-chevron-right"></i> <?=$title?></a></li>
<?
	}
?>
</ul>
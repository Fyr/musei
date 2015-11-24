<?
	$title = $this->ObjectType->getTitle('index', $objectType);
	echo $this->element('bread_crumbs', array('aBreadCrumbs' => array(
		__('Home') => '/',
		$title => ''
	)));
	echo $this->element('title', array('pageTitle' => $title));
?>
<div class="block">
	
<?
	foreach($aArticles as $i => $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x');
?>
	<div class="media">
<?
		if ($src) {
?>
		<a class="pull-left" href="<?=$url?>">
			<img class="media-object thumb" src="<?=$src?>" alt="<?=$title?>">
		</a>
<?
		}
?>
		<div class="media-body">
			<h4 class="media-heading"><a href="<?=$url?>"><?=$title?></a></h4>
			<p><?=$teaser?></p>
			<?=$this->element('more', compact('url'))?>
		</div>
	</div>
	<hr />
<?
	}
?>
</div>
<?
	echo $this->element('paginate');
?>
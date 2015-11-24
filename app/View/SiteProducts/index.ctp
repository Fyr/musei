<?
	$title = $this->ObjectType->getTitle('index', $objectType);
	if ($q) {
		echo $this->element('title', array('pageTitle' => __('Search results').' `'.$q.'`'));
	} else {
		$aBreadCrumbs = array(__('Home') => '/');
		if (isset($category)) {
			$aBreadCrumbs[$title] = Router::url(array('action' => 'index', 'objectType' => 'Product'));
			$aBreadCrumbs[$category['CategoryProduct']['title']] = '';
			$title.= ': '.$category['CategoryProduct']['title'];
		} else {
			$aBreadCrumbs[$title] = '';
		}
		echo $this->element('bread_crumbs', compact('aBreadCrumbs'));
		echo $this->element('title', array('pageTitle' => $title));
	}
?>
<div class="block">
	<div class="logo-list clearfix">
<?
	foreach($aArticles as $i => $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x150');
?>
		<div class="item clearfix">
			<div class="title">
				<a href="<?=$url?>"><?=__('Logotype %s', $title)?></a>
			</div>
			<a class="image" href="<?=$url?>" title="<?=__('Download logo %s', $title);?>">
				<img class="media-object" src="<?=$src?>" alt="<?=__('Download logo %s', $title);?>" />
			</a>
			<small>
<?
		if (!isset($category)) {
			echo __('Category').': '.$this->Html->link($article['Category']['title'], SiteRouter::url(array('CategoryProduct' => $article['Category']))).'<br/>';
		}
?>
				<?=$this->element('page_stats', compact('article'))?>
			</small>
			<?=$this->element('more', array('url' => $url, 'title' => __('Download')))?>
		</div>
<?
	}
?>
	</div>
</div>
<?
	echo $this->element('paginate');
	$page = $this->request->param('page');
	if (isset($category)) {
		if (!$page || $page == 1) {
			$relText = sprintf('Релевантный текст по умолчанию для категории логотипа `%s`', $category['CategoryProduct']['title']);
			if (!(trim($category['CategoryProduct']['body']))) {
				$category['CategoryProduct']['body'] = $relText;
			}
			echo $this->ArticleVars->body($category);
		}
	}
?>
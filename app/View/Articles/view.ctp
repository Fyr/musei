<?
	// $title = $this->ObjectType->getTitle('view', $objectType);
	echo $this->element('bread_crumbs', array('aBreadCrumbs' => array(
		__('Home') => '/',
		$this->ObjectType->getTitle('index', $objectType) => array('controller' => 'Articles', 'action' => 'index', 'objectType' => $objectType),
		$this->ObjectType->getTitle('view', $objectType) => ''
	)));
	echo $this->element('title', array('pageTitle' => $article[$objectType]['title']));
?>
<div class="block">
	<?=$this->ArticleVars->body($article)?>
</div>
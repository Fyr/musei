<?
	$title = $this->ObjectType->getTitle('index', $objectType);
	if ($objectType == 'SubcategoryArticle' && $objectID) {
		$title = Hash::get($categoryArticle, 'CategoryArticle.title').': '.$title;
	} elseif ($objectType == 'CarSubtype' && $objectID) {
		$title = Hash::get($carType, 'CarType.title').': '.$title;
	}
    $createURL = $this->Html->url(array('action' => 'edit', 0, $objectType, $objectID));
    $createTitle = $this->ObjectType->getTitle('create', $objectType);
    
    $actions = $this->PHTableGrid->getDefaultActions($objectType);
    $actions['table']['add']['href'] = $createURL;
    $actions['table']['add']['label'] = $createTitle;
    $actions['row']['edit']['href'] = $this->Html->url(array('action' => 'edit', '~id', $objectType, $objectID));

    if ($objectType == 'CategoryArticle') {
    	$actions['row'][] = array(
    		'label' => $this->ObjectType->getTitle('index', 'SubcategoryArticle'), 
    		'class' => 'icon-color icon-open-folder', 
    		'href' => $this->Html->url(array('action' => 'index', 'SubcategoryArticle', '~id'))
    	);
    } elseif ($objectType == 'CarType') {
    	$actions['row'][] = array(
    		'label' => $this->ObjectType->getTitle('index', 'CarSubtype'), 
    		'class' => 'icon-color icon-open-folder', 
    		'href' => $this->Html->url(array('action' => 'index', 'CarSubtype', '~id'))
    	);
    }
    
	$columns = $this->PHTableGrid->getDefaultColumns($objectType);
	if ($objectType == 'CarType') {
		$columns = array_merge(
			array(
				'CarType.image' => array('key' => 'CarType.image', 'label' => 'Фото', 'align' => 'center', 'showFilter' => false, 'showSorting' => false),
			),
			$columns
		);
		unset($columns['Media.id']);
		unset($columns['Media.object_type']);
		unset($columns['Media.file']);
		unset($columns['Media.ext']);
		foreach($aRowset as &$row) {
			$img = $this->Media->imageUrl($row, '100x50');
			$row['CarType']['image'] = ($img) ? $this->Html->image($img) : '<img src="/img/default_cartype.jpg" style="width: 50px; alt="" />';
			/*
	    	$row['Product']['image'] = ($img) ? $this->Html->link(
	    		$this->Html->image($img),
	    		$this->Media->imageUrl($row, 'noresize'),
	    		array('escape' => false, 'class' => 'fancybox', 'rel' => 'gallery')
	    	) : '<img src="/img/default_product.jpg" style="width: 50px; alt="" />';
	    	*/
		}
	}
?>
<?=$this->element('admin_title', compact('title'))?>
<div class="text-center">
<?
	if ($objectType == 'News') {
		/*
?>
	<a class="btn btn-success" href="<?=$this->Html->url(array('controller' => 'AdminContent', 'action' => 'index', 'CategoryNews'))?>">
        <?=$this->ObjectType->getTitle('index', 'CategoryNews')?>
    </a>
<?
	} elseif ($objectType == 'CategoryNews') {
?>
	<a class="btn btn-success" href="<?=$this->Html->url(array('controller' => 'AdminContent', 'action' => 'index', 'News'))?>">
        <?=$this->ObjectType->getTitle('index', 'News')?>
    </a>
<?
	} elseif ($objectType == 'SiteArticle') {
?>
	<a class="btn btn-success" href="<?=$this->Html->url(array('controller' => 'AdminContent', 'action' => 'index', 'CategoryArticle'))?>">
        <?=$this->ObjectType->getTitle('index', 'CategoryArticle')?>
    </a>
<?
	} elseif ($objectType == 'CategoryArticle') {
?>
	<a class="btn btn-success" href="<?=$this->Html->url(array('controller' => 'AdminContent', 'action' => 'index', 'SiteArticle'))?>">
        <?=$this->ObjectType->getTitle('index', 'SiteArticle')?>
    </a>
<?
	} elseif ($objectType == 'SubcategoryArticle') {
?>
	<a class="btn btn-success" href="<?=$this->Html->url(array('controller' => 'AdminContent', 'action' => 'index', 'SiteArticle'))?>">
        <?=$this->ObjectType->getTitle('index', 'SiteArticle')?>
    </a>
    <a class="btn btn-success" href="<?=$this->Html->url(array('controller' => 'AdminContent', 'action' => 'index', 'CategoryArticle'))?>">
        <?=$this->ObjectType->getTitle('index', 'CategoryArticle')?>
    </a>
<?
		*/
	}
?>
    <a class="btn btn-primary" href="<?=$createURL?>">
        <i class="icon-white icon-plus"></i> <?=$createTitle?>
    </a>
</div>
<br/>
<?
    echo $this->PHTableGrid->render($objectType, array(
        'baseURL' => $this->ObjectType->getBaseURL($objectType, $objectID),
        'actions' => $actions,
        'columns' => $columns,
        'data' => $aRowset
    ));
?>
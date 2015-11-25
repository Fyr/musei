<?
	$title = $this->ObjectType->getTitle('index', $objectType);
	if (in_array($objectType, array('ExhibitPhoto', 'CollectionPhoto')) && $objectID) {
		$title = $aOptions[$objectType][$objectID].': '.$title;
	}
    $createURL = $this->Html->url(array('action' => 'edit', 0, $objectType, $objectID));
    $createTitle = $this->ObjectType->getTitle('create', $objectType);
    
    $actions = $this->PHTableGrid->getDefaultActions($objectType);
    $actions['table']['add']['href'] = $createURL;
    $actions['table']['add']['label'] = $createTitle;
    $actions['row']['edit']['href'] = $this->Html->url(array('action' => 'edit', '~id', $objectType, $objectID));

    $columns = $this->PHTableGrid->getDefaultColumns($objectType);
    if (in_array($objectType, array('Exhibit', 'Collection'))) {
    	$actions['row'][] = array(
    		'label' => $this->ObjectType->getTitle('index', $objectType.'Photo'),
            'class' => 'icon-color icon-open-folder',
    		'href' => $this->Html->url(array('action' => 'index', $objectType.'Photo', '~id'))
    	);
    } elseif (in_array($objectType, array('ExhibitPhoto', 'CollectionPhoto'))) {
        $columns = array_merge(array($objectType.'.image' => array(
            'key' => 'Media.image',
            'label' => 'Фото',
            'format' => 'image'
        )), $columns);
        foreach($aRowset as &$row) {
            $image = Hash::get($row, 'Media.image');
            $row['Media']['image'] = ($image) ? $this->Html->image($this->Media->imageUrl($row, 'thumb50x50')) : '- нет фото -';
        }
    }
	echo $this->element('admin_title', compact('title'));
?>
<div class="text-center">
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
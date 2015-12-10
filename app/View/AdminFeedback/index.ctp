<?
$objectType = 'Feedback';
$title = $this->ObjectType->getTitle('index', $objectType);
$createURL = $this->Html->url(array('action' => 'edit', 0));
$createTitle = $this->ObjectType->getTitle('create', $objectType);

$actions = $this->PHTableGrid->getDefaultActions($objectType);
$actions['table']['add']['href'] = $createURL;
$actions['table']['add']['label'] = $createTitle;
$actions['row']['edit']['href'] = $this->Html->url(array('action' => 'edit', '~id'));

$columns = $this->PHTableGrid->getDefaultColumns($objectType);
$columns['Feedback.body']['label'] = 'Отзыв';

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
    'baseURL' => $this->ObjectType->getBaseURL(''),
    'actions' => $actions,
    'columns' => $columns,
    'data' => $aRowset
));
?>
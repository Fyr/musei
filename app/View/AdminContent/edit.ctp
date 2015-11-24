<div class="span8 offset2">
<?
    $id = $this->request->data('Article.id');
    $objectType = $this->request->data('Article.object_type');
    $title = $this->ObjectType->getTitle(($id) ? 'edit' : 'create', $objectType);
    
    $objectID = '';
    if ($objectType == 'SubcategoryArticle') {
    	$objectID = $this->request->data('Article.cat_id');
		$title = Hash::get($categoryArticle, 'CategoryArticle.title').': '.$title;
	}
?>
	<?=$this->element('admin_title', compact('title'))?>
<?
    echo $this->PHForm->create('Article');
    echo $this->Form->hidden('Seo.id', array('value' => Hash::get($this->request->data, 'Seo.id')));
    $aTabs = array(
        'General' => $this->element('/AdminContent/admin_edit_'.$objectType),
		'Text' => $this->element('Article.edit_body'),
		'SEO' => $this->element('Seo.edit')
    );
    if ($id) {
        $aTabs['Media'] = $this->element('Media.edit', array('object_type' => $objectType, 'object_id' => $id));
    }
	echo $this->element('admin_tabs', compact('aTabs'));
	echo $this->element('Form.form_actions', array('backURL' => $this->ObjectType->getBaseURL($objectType, $objectID)));
    echo $this->PHForm->end();
?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	// var $grid = $('#grid_FormField');
});
</script>
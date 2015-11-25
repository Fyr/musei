<div class="span8 offset2">
<?
    $id = $this->request->data('Article.id');
    $objectType = $this->request->data('Article.object_type');
    $objectID = $this->request->data('Article.object_id');
    $title = $this->ObjectType->getTitle(($id) ? 'edit' : 'create', $objectType);
    
    echo $this->element('admin_title', compact('title'));
    echo $this->PHForm->create('Article');
    $aTabs = array(
        'General' => $this->element('/AdminContent/admin_edit_'.$objectType),
		'Text' => $this->element('Article.edit_body'),
    );
    if (in_array($objectType, array('ExhibitPhoto', 'CollectionPhoto'))) {
        unset($aTabs['Text']);
    } elseif ($objectType == 'Quiz') {
        // add Answers tab
        unset($aTabs['Text']);
        $aTabs['Quiz text'] = $this->element('Article.edit_body');
        $aTabs['Answers'] = $this->element('/AdminContent/admin_edit_QuizAnswers');
    }
    if ($id) {
        $aTabs['Media'] = $this->element('Media.edit', array('object_type' => $objectType, 'object_id' => $id));
    }
	echo $this->element('admin_tabs', compact('aTabs'));
	echo $this->element('Form.form_actions', array('backURL' => $this->ObjectType->getBaseURL($objectType, $objectID)));
    echo $this->PHForm->end();
?>
</div>
